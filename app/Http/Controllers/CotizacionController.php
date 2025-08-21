<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Recepcion;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cotizacion;
use App\Models\FotoEquipo;


class CotizacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Cotizacion::with(['recepcion.cliente', 'recepcion.usuario'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where(function ($q) use ($busqueda) {
                $q->where('id', 'like', "%$busqueda%")
                    ->orWhereHas('recepcion', function ($qr) use ($busqueda) {
                        $qr->where('numero_recepcion', 'like', "%$busqueda%")
                            ->orWhereHas('cliente', function ($qc) use ($busqueda) {
                                $qc->where('nombre', 'like', "%$busqueda%");
                            });
                    });
            });
        }

        $cotizaciones = $query->paginate(10)->appends($request->only('buscar'));

        return view('modules.cotizaciones.indexCoti', [
            'cotizaciones' => $cotizaciones
        ]);
    }

    public function create()
    {
        // Aquí puedes implementar la lógica para mostrar el formulario de creación de cotización
        return view('modules.cotizaciones.createCoti', compact('recepciones'));
    }

    public function createFromRecepcion($id)
    {
        // Verificar si ya existe una cotización para esta recepción
        $cotizacionExistente = Cotizacion::where('recepcion_id', $id)->first();

        if ($cotizacionExistente) {
            return redirect()->route('recepciones.index')
                ->with('swal', [
                    'icon' => 'warning',
                    'title' => 'Cotización ya existe',
                    'text' => 'Esta recepción ya tiene una cotización creada.'
                ]);
        }

        $recepcion = Recepcion::with(['cliente', 'equipos.fotos'])->findOrFail($id);
        return view('modules.cotizaciones.editCoti', compact('recepcion'));
    }

    public function store(Request $request, $id)
    {
        // Verificar si ya existe una cotización para esta recepción
        $cotizacionExistente = Cotizacion::where('recepcion_id', $id)->first();

        if ($cotizacionExistente) {
            return redirect()->route('recepciones.index')
                ->with('swal', [
                    'icon' => 'warning',
                    'title' => 'Cotización ya existe',
                    'text' => 'Esta recepción ya tiene una cotización creada.'
                ]);
        }

        // ✅ VALIDACIÓN MEJORADA CON FOTOS OBLIGATORIAS
        $validatedData = $request->validate([
            'equipos' => 'required|array',
            'equipos.*.equipo_id' => 'required|exists:equipos,id',
            'equipos.*.descripcion' => 'required|string|min:10|max:1000',
            'equipos.*.valor_trabajo' => 'required|numeric|min:0.01',
            'equipos.*.repuestos_detalle' => 'required|array|min:1',
            'equipos.*.repuestos_detalle.*.nombre' => 'required|string|min:3|max:100',
            'equipos.*.repuestos_detalle.*.cantidad' => 'nullable|integer',
            'equipos.*.repuestos_detalle.*.precio' => 'nullable|numeric',
            'equipos.*.fotos' => 'required|array|min:1', // ✅ FOTOS OBLIGATORIAS
            'equipos.*.fotos.*' => 'integer|exists:fotos_equipos,id',
            'descuento' => 'nullable|numeric|min:0',
            'equipos.*.servicios_detalle' => 'required|array|min:1',
            'equipos.*.servicios_detalle.*.nombre' => 'required|string|min:3|max:100',
        ], [
            // ✅ MENSAJES PERSONALIZADOS
            'equipos.*.descripcion.required' => 'La descripción del trabajo es obligatoria.',
            'equipos.*.descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'equipos.*.valor_trabajo.required' => 'El valor del trabajo es obligatorio.',
            'equipos.*.valor_trabajo.min' => 'El valor del trabajo debe ser mayor a 0.',
            'equipos.*.repuestos_detalle.required' => 'Debe agregar al menos un repuesto.',
            'equipos.*.repuestos_detalle.min' => 'Debe agregar al menos un repuesto.',
            'equipos.*.repuestos_detalle.*.nombre.required' => 'El nombre del repuesto es obligatorio.',
            'equipos.*.repuestos_detalle.*.nombre.min' => 'El nombre del repuesto debe tener al menos 3 caracteres.',
            'equipos.*.fotos.required' => 'Debe seleccionar al menos una foto para cada equipo.',
            'equipos.*.fotos.min' => 'Debe seleccionar al menos una foto para cada equipo.',
            'equipos.*.servicios_detalle.required' => 'Debe agregar al menos un servicio.',
            'equipos.*.servicios_detalle.min' => 'Debe agregar al menos un servicio.',
            'equipos.*.servicios_detalle.*.nombre.required' => 'El nombre del servicio es obligatorio.',
            'equipos.*.servicios_detalle.*.nombre.min' => 'El nombre del servicio debe tener al menos 3 caracteres.',
        ]);

        // ✅ VALIDACIÓN ADICIONAL PERSONALIZADA
        $recepcion = Recepcion::with('equipos.fotos')->findOrFail($id);
        $errores = [];

        foreach ($validatedData['equipos'] as $index => $equipoData) {
            $equipoNumero = $index + 1;
            $equipo = $recepcion->equipos->where('id', $equipoData['equipo_id'])->first();
            $equipoNombre = $equipo ? $equipo->nombre : "Equipo {$equipoNumero}";

            // ✅ VALIDAR QUE LAS FOTOS SELECCIONADAS PERTENEZCAN AL EQUIPO
            if (!empty($equipoData['fotos'])) {
                $fotosEquipo = $equipo->fotos->pluck('id')->toArray();
                $fotosSeleccionadas = $equipoData['fotos'];

                $fotosInvalidas = array_diff($fotosSeleccionadas, $fotosEquipo);
                if (!empty($fotosInvalidas)) {
                    $errores[] = "Las fotos seleccionadas para {$equipoNombre} no son válidas.";
                }
            }

            // ✅ VALIDAR NOMBRES DE REPUESTOS ÚNICOS POR EQUIPO
            if (!empty($equipoData['repuestos_detalle'])) {
                $nombresRepuestos = collect($equipoData['repuestos_detalle'])->pluck('nombre')->map(function ($nombre) {
                    return strtolower(trim($nombre));
                });

                if ($nombresRepuestos->count() !== $nombresRepuestos->unique()->count()) {
                    $errores[] = "El {$equipoNombre} tiene repuestos con nombres duplicados.";
                }
            }
        }

        // ✅ SI HAY ERRORES, REGRESAR CON SWEET ALERT
        if (!empty($errores)) {
            return redirect()->back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Errores de validación',
                    'html' => '<ul style="text-align: left;">' .
                        implode('', array_map(fn($error) => "<li>{$error}</li>", $errores)) .
                        '</ul>'
                ]);
        }

        return DB::transaction(function () use ($request, $id, $validatedData) {

            // Obtener la recepción
            $recepcion = Recepcion::findOrFail($id);

            // Crear la cotización 
            $cotizacion = Cotizacion::create([
                'recepcion_id' => $id,
                'fecha' => now(),
                'subtotal' => 0,
                'descuento' => $validatedData['descuento'] ?? 0,
                'total' => 0
            ]);

            $subtotalGeneral = 0;

            // Procesa cada equipo
            foreach ($validatedData['equipos'] as $equipoData) {
                $totalRepuestos = 0;
                $repuestosData = [];

                // Procesa repuestos y calcula total
                foreach ($equipoData['repuestos_detalle'] as $repuesto) {
                    $subtotalRepuesto = $repuesto['cantidad'] * $repuesto['precio'];
                    $totalRepuestos += $subtotalRepuesto;
                }

                // Crea el equipo en la cotización
                $cotizacionEquipo = $cotizacion->equipos()->create([
                    'equipo_id' => $equipoData['equipo_id'],
                    'trabajo_realizar' => trim($equipoData['descripcion']),
                    'precio_trabajo' => $equipoData['valor_trabajo'],
                    'total_repuestos' => $totalRepuestos
                ]);

                // Crea repuestos directamente en la relación
                foreach ($equipoData['repuestos_detalle'] as $repuesto) {
                    $cotizacionEquipo->repuestos()->create([
                        'nombre' => trim($repuesto['nombre']),
                        'cantidad' => $repuesto['cantidad'] ?? 0,
                        'precio_unitario' => $repuesto['precio'] ?? 0
                    ]);
                }
                
            // Guarda los servicios realizados
                if (!empty($equipoData['servicios_detalle'])) {
                    foreach ($equipoData['servicios_detalle'] as $servicio) {
                        $cotizacionEquipo->servicios()->create([
                            'nombre' => trim($servicio['nombre'])
                        ]);
                    }
                }

                // Asocia repuestos
                if (!empty($repuestosData)) {
                    $cotizacionEquipo->repuestos()->saveMany($repuestosData);
                }

                // ✅ ASOCIA FOTOS (YA VALIDADAS COMO OBLIGATORIAS)
                $cotizacionEquipo->fotos()->sync($equipoData['fotos']);

                // Suma al subtotal general
                $subtotalGeneral += $equipoData['valor_trabajo'] + $totalRepuestos;
            }

            


            // Actualiza totales de la cotización
            $cotizacion->update([
                'subtotal' => $subtotalGeneral,
                'total' => $subtotalGeneral - $cotizacion->descuento
            ]);

            // ✅ CAMBIAR ESTADO DE LA RECEPCIÓN A DIAGNOSTICADO
            if ($recepcion->estado === 'RECIBIDO') {
                $recepcion->update(['estado' => 'DIAGNOSTICADO']);
            }

            return redirect()
                ->route('cotizaciones.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Cotización creada',
                    'text' => 'La cotización fue creada correctamente.'
                ]);
        });
    }
    public function edit($id)
    {
        // Cargar la cotización existente con todas sus relaciones
        $cotizacion = Cotizacion::with([
            'recepcion.cliente',
            'equipos' => function ($query) {
                $query->with([
                    'equipo.fotos', // Todas las fotos del equipo
                    'fotos',        // Fotos seleccionadas para la cotización
                    'repuestos',    // Repuestos de la cotización
                    'servicios'     // Servicios de la cotización
                ]);
            }
        ])->findOrFail($id);

        return view('modules.cotizaciones.editarCotizacion', compact('cotizacion'));
    }

    public function update(Request $request, $id)
    {
        // Validación similar a la del método store
        $validatedData = $request->validate([
            'equipos' => 'required|array',
            'equipos.*.equipo_id' => 'required|exists:equipos,id',
            'equipos.*.descripcion' => 'required|string|min:10|max:1000',
            'equipos.*.valor_trabajo' => 'required|numeric|min:0.01',
            'equipos.*.repuestos_detalle' => 'required|array|min:1',
            'equipos.*.repuestos_detalle.*.nombre' => 'required|string|min:3|max:100',
            'equipos.*.repuestos_detalle.*.cantidad' => 'nullable|integer',
            'equipos.*.repuestos_detalle.*.precio' => 'nullable|numeric',
            'equipos.*.fotos' => 'required|array|min:1',
            'equipos.*.fotos.*' => 'integer|exists:fotos_equipos,id',
            'descuento' => 'nullable|numeric|min:0',
            'equipos.*.servicios_detalle' => 'required|array|min:1',
            'equipos.*.servicios_detalle.*.nombre' => 'required|string|min:3|max:100',
        ], [
            'equipos.*.descripcion.required' => 'La descripción del trabajo es obligatoria.',
            'equipos.*.descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'equipos.*.valor_trabajo.required' => 'El valor del trabajo es obligatorio.',
            'equipos.*.valor_trabajo.min' => 'El valor del trabajo debe ser mayor a 0.',
            'equipos.*.repuestos_detalle.required' => 'Debe agregar al menos un repuesto.',
            'equipos.*.repuestos_detalle.min' => 'Debe agregar al menos un repuesto.',
            'equipos.*.repuestos_detalle.*.nombre.required' => 'El nombre del repuesto es obligatorio.',
            'equipos.*.repuestos_detalle.*.nombre.min' => 'El nombre del repuesto debe tener al menos 3 caracteres.',
            'equipos.*.fotos.required' => 'Debe seleccionar al menos una foto para cada equipo.',
            'equipos.*.fotos.min' => 'Debe seleccionar al menos una foto para cada equipo.',
            'equipos.*.servicios_detalle.required' => 'Debe agregar al menos un servicio.',
            'equipos.*.servicios_detalle.min' => 'Debe agregar al menos un servicio.',
            'equipos.*.servicios_detalle.*.nombre.required' => 'El nombre del servicio es obligatorio.',
            'equipos.*.servicios_detalle.*.nombre.min' => 'El nombre del servicio debe tener al menos 3 caracteres.',
        ]);

        return DB::transaction(function () use ($request, $id, $validatedData) {
            $cotizacion = Cotizacion::findOrFail($id);

            // Actualizar descuento de la cotización
            $cotizacion->update([
                'descuento' => $validatedData['descuento'] ?? 0,
            ]);

            $subtotalGeneral = 0;

            // Eliminar equipos existentes y sus relaciones
            foreach ($cotizacion->equipos as $equipoExistente) {
                $equipoExistente->repuestos()->delete();
                $equipoExistente->servicios()->delete();
                $equipoExistente->fotos()->detach();
                $equipoExistente->delete();
            }

            // Procesar cada equipo nuevamente
            foreach ($validatedData['equipos'] as $equipoData) {
                $totalRepuestos = 0;

                // Calcular total de repuestos
                foreach ($equipoData['repuestos_detalle'] as $repuesto) {
                    $totalRepuestos += $repuesto['cantidad'] * $repuesto['precio'];
                }

                // Crear el equipo en la cotización
                $cotizacionEquipo = $cotizacion->equipos()->create([
                    'equipo_id' => $equipoData['equipo_id'],
                    'trabajo_realizar' => trim($equipoData['descripcion']),
                    'precio_trabajo' => $equipoData['valor_trabajo'],
                    'total_repuestos' => $totalRepuestos
                ]);

                // Crear repuestos
                foreach ($equipoData['repuestos_detalle'] as $repuesto) {
                    $cotizacionEquipo->repuestos()->create([
                        'nombre' => trim($repuesto['nombre']),
                        'cantidad' => $repuesto['cantidad'] ?? 0,
                        'precio_unitario' => $repuesto['precio'] ?? 0
                    ]);
                }

                // Crear servicios
                if (!empty($equipoData['servicios_detalle'])) {
                    foreach ($equipoData['servicios_detalle'] as $servicio) {
                        $cotizacionEquipo->servicios()->create([
                            'nombre' => trim($servicio['nombre'])
                        ]);
                    }
                }

                // Asociar fotos
                $cotizacionEquipo->fotos()->sync($equipoData['fotos']);

                // Sumar al subtotal general
                $subtotalGeneral += $equipoData['valor_trabajo'] + $totalRepuestos;
            }

            // Actualizar totales de la cotización
            $cotizacion->update([
                'subtotal' => $subtotalGeneral,
                'total' => $subtotalGeneral - $cotizacion->descuento
            ]);

            return redirect()
                ->route('cotizaciones.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Cotización actualizada',
                    'text' => 'La cotización fue actualizada correctamente.'
                ]);
        });
    }

    public function destroy($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);

        // Eliminar equipos y sus relaciones
        foreach ($cotizacion->equipos as $equipo) {
            $equipo->repuestos()->delete();
            $equipo->servicios()->delete();
            $equipo->fotos()->detach();
            $equipo->delete();
        }

        // Eliminar la cotización
        $cotizacion->delete();

        return redirect()->route('cotizaciones.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Cotización eliminada',
                'text' => 'La cotización fue eliminada correctamente.'
            ]);
    }

    public function show($id)
    {
        $cotizacion = Cotizacion::with([
            'recepcion.cliente',
            'equipos' => function ($query) {
                $query->with([
                    'equipo.fotos', // Todas las fotos del equipo
                    'fotos',        // Fotos seleccionadas para la cotización
                    'repuestos'     // Repuestos de la cotización
                ]);
            }
        ])->where('recepcion_id', $id)->first();

        if (!$cotizacion) {
            return redirect()->route('cotizaciones.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se encontró la cotización para esta recepción'
                ]);
        }

        return view('modules.cotizaciones.showCot', compact('cotizacion'));
    }

    public function generarPdf($id)
    {
        // Buscar la cotización con todas las relaciones necesarias
        $cotizacion = Cotizacion::with([
            'recepcion.cliente',
            'equipos' => function ($query) {
                $query->with([
                    'equipo', // Datos del equipo
                    'fotos',  // Fotos seleccionadas para la cotización
                    'repuestos',
                    'servicios' // Servicios de la cotización
                ]);
            }
        ])->where('recepcion_id', $id)->first();

        if (!$cotizacion) {
            return redirect()->route('cotizaciones.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se encontró la cotización para esta recepción'
                ]);
        }

        // Datos para el PDF
        $data = [
            'cotizacion' => $cotizacion,
            'recepcion' => $cotizacion->recepcion,
            'cliente' => $cotizacion->recepcion->cliente,
            'subtotal' => $cotizacion->subtotal,
            'descuento' => $cotizacion->descuento,
            'total' => $cotizacion->total
        ];

        $pdf = Pdf::loadView('modules.cotizaciones.Generarpdf', $data);
        return $pdf->stream('cotizacion_' . $cotizacion->recepcion->numero_recepcion . '.pdf');
    }
}

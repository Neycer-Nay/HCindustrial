<?php

namespace App\Http\Controllers;

use App\Models\Recepcion;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\FotoEquipo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class RecepcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Recepcion::with(['cliente', 'usuario', 'cotizacion']) // Agregar cotizacion
            ->orderBy('created_at', 'desc');
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function ($q) use ($busqueda) {
                $q->where('numero_recepcion', 'like', "%$busqueda%")
                    ->orWhereHas('cliente', function ($qc) use ($busqueda) {
                        $qc->where('nombre', 'like', "%$busqueda%");
                    })
                    ->orWhereHas('usuario', function ($qu) use ($busqueda) {
                        $qu->where('nombre', 'like', "%$busqueda%");
                    });
            });
        }

        $recepciones = $query->paginate(10)->appends($request->only('buscar', 'cliente', 'usuario'));

        return view('modules.recepciones.index', [
            'recepciones' => $recepciones
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $ultimaRecepcion = Recepcion::latest()->first();
        if ($ultimaRecepcion) {
            $ultimoNumero = (int) Str::after($ultimaRecepcion->numero_recepcion, 'REC-00');
            $numeroRecepcion = 'REC-00' . str_pad($ultimoNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $numeroRecepcion = 'REC-005512';
        }

        $usuario = Auth::user();
        $clientes = Cliente::all();

        return view('modules.recepciones.create', compact('clientes', 'numeroRecepcion'));
    }

    public function store(Request $request)
    {


        // Validación de datos
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero_recepcion' => 'required|:recepciones',
            'fecha_ingreso' => 'required|date', // Cambiado a fecha_ingreso para coincidir con BD
            'hora_ingreso' => 'required',
            'observaciones' => 'nullable|string',
            'equipos' => 'required|array|min:1',
            'equipos.*.tipo' => 'required|in:MOTOR_ELECTRICO,MAQUINA_SOLDADORA,GENERADOR_DINAMO,OTROS',
            'equipos.*.marca' => 'required|string|max:255',
            'equipos.*.nombre' => 'required|string|max:255',
            'equipos.*.color' => 'required|array|min:1|max:2',
            'equipos.*.color.*' => 'required|in:Inox,Negro,Blanco,Gris,Rojo,Azul,Verde,Amarillo,Naranja,Morado,Rosado,Marrón,Cian',

            //Aca poner validaciones para las fotos
            'equipos.*.fotos' => 'nullable|array|max:12',
            'equipos.*.fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12288',
            'equipos.*.camera_photos' => 'nullable|array',

        ], [
            'equipos.required' => 'Debes seleccionar al menos un equipo.',
            'equipos.*.fotos.max' => 'Cada equipo solo puede tener hasta 12 fotos.',
            'equipos.*.color.required' => 'El campo color es obligatorio para cada equipo.',
            'equipos.*.color.min' => 'Debes seleccionar al menos un color para cada equipo.',
            'equipos.*.color.max' => 'Solo puedes seleccionar hasta 2 colores por equipo.',
            'equipos.*.color.*.in' => 'El color seleccionado no es válido.',

        ]);

        // Crear la recepción
        $recepcion = Recepcion::create([
            'numero_recepcion' => $request->numero_recepcion,
            'cliente_id' => $request->cliente_id,
            'user_id' => Auth::id(),
            'fecha_ingreso' => $request->fecha_ingreso, // Asegúrate que coincide con el name del input
            'hora_ingreso' => $request->hora_ingreso,
            'observaciones' => $request->observaciones,
            'estado' => 'RECIBIDO'
        ]);

        foreach ($request->equipos as $index => $equipoData) {
            $hasFilePhotos = isset($equipoData['fotos']) && count($equipoData['fotos']) > 0;
            $hasCameraPhotos = isset($equipoData['camera_photos']) && count($equipoData['camera_photos']) > 0;

            if (!$hasFilePhotos && !$hasCameraPhotos) {
                return back()->withErrors([
                    "equipos.{$index}.fotos" => "El equipo #" . ($index + 1) . " debe tener al menos una foto (archivo o cámara)."
                ])->withInput();
            }

            // Guardar los equipos
            foreach ($request->equipos as $index => $equipoData) {
                $equipo = new Equipo([
                    'recepcion_id' => $recepcion->id,
                    'cliente_id' => $request->cliente_id,
                    'nombre' => $equipoData['nombre'],
                    'tipo' => $equipoData['tipo'],
                    'modelo' => $equipoData['modelo'] ?? null,
                    'marca' => $equipoData['marca'],
                    'numero_serie' => $equipoData['serie'] ?? null,
                    'color' => isset($equipoData['color']) ? implode(',', (array) $equipoData['color']) : null,
                    'voltaje' => $equipoData['voltaje'] ?? null,
                    'hp' => $equipoData['hp'] ?? null,
                    'rpm' => $equipoData['rpm'] ?? null,
                    'hz' => $equipoData['hz'] ?? null,
                    'amperaje' => $equipoData['amperaje'] ?? null,
                    'cable_positivo' => $equipoData['cable_positivo'] ?? null,
                    'cable_negativo' => $equipoData['cable_negativo'] ?? null,
                    'kva_kw' => $equipoData['kva_kw'] ?? null,
                    'potencia' => $equipoData['potencia'] ?? null,
                    'potencia_unidad' => $equipoData['potencia_unidad'],
                    //Desabilitar campos que no se usan temporalmente
                    //'partes_faltantes' => $equipoData['partes_faltantes'] ?? null,
                    //'observaciones' => $equipoData['observaciones'] ?? null,

                ]);

                $equipo->save();
                if (isset($equipoData['fotos'])) {
                    foreach ($equipoData['fotos'] as $foto) {
                        $path = $this->storeImage($foto, $equipo->id);

                        FotoEquipo::create([
                            'equipo_id' => $equipo->id,
                            'ruta' => $path,
                            'descripcion' => 'Foto subida'
                        ]);
                    }
                }
                // Guardar fotos de la cámara
                if (isset($equipoData['camera_photos'])) {
                    foreach ($equipoData['camera_photos'] as $base64Photo) {
                        $path = $this->storeBase64Image($base64Photo, $equipo->id);

                        FotoEquipo::create([
                            'equipo_id' => $equipo->id,
                            'ruta' => $path,
                            'descripcion' => 'Foto tomada con cámara'
                        ]);
                    }
                }


            }

            return redirect()->route('recepciones.index')
                ->with('success', 'Recepción registrada correctamente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recepcion $recepcion)
    {
        $recepcion->load(['cliente', 'usuario', 'equipos']);
        // Buscar cotización asociada
        $cotizacion = \App\Models\Cotizacion::where('recepcion_id', $recepcion->id)->first();

        return view('modules.recepciones.show', [
            'recepcion' => $recepcion,
            'cotizacion' => $cotizacion
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recepcion $recepcion)
    {
        $recepcion->load(['cliente', 'usuario', 'equipos.fotos']);

        return view('modules.recepciones.edit_estado', compact('recepcion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recepcion $recepcion)
    {
        // Validación
        $validated = $request->validate([
            'equipos' => 'required|array|min:1',
            'equipos.*.nombre' => 'required|string|max:255',
            'equipos.*.tipo' => 'required|in:MOTOR_ELECTRICO,MAQUINA_SOLDADORA,GENERADOR_DINAMO,OTROS',
            'equipos.*.marca' => 'required|string|max:255',
            'equipos.*.fotos' => 'nullable|array|max:12',
            'equipos.*.fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12288',
            'equipos.*.camera_photos' => 'nullable|array',
            'deleted_photos' => 'nullable|string',
        ]);

        // Eliminar fotos marcadas para eliminación
        if ($request->deleted_photos) {
            $deletedPhotos = json_decode($request->deleted_photos);
            if (is_array($deletedPhotos)) {
                foreach ($deletedPhotos as $photoId) {
                    $foto = FotoEquipo::find($photoId);
                    if ($foto) {
                        // Eliminar archivo físico
                        Storage::disk('public')->delete($foto->ruta);
                        // Eliminar registro de base de datos
                        $foto->delete();
                    }
                }
            }
        }

        // Actualizar equipos
        foreach ($request->equipos as $index => $equipoData) {
            if (isset($equipoData['id'])) {
                // Actualizar equipo existente
                $equipo = Equipo::find($equipoData['id']);
                if ($equipo) {
                    $equipo->update([
                        'nombre' => $equipoData['nombre'],
                        'modelo' => $equipoData['modelo'] ?? null,
                        'marca' => $equipoData['marca'],
                        'numero_serie' => $equipoData['serie'] ?? null,
                        'color' => isset($equipoData['color']) ? implode(',', (array) $equipoData['color']) : null,
                        'voltaje' => $equipoData['voltaje'] ?? null,
                        'hp' => $equipoData['hp'] ?? null,
                        'rpm' => $equipoData['rpm'] ?? null,
                        'hz' => $equipoData['hz'] ?? null,
                        'amperaje' => $equipoData['amperaje'] ?? null,
                        'cable_positivo' => $equipoData['cable_positivo'] ?? null,
                        'cable_negativo' => $equipoData['cable_negativo'] ?? null,
                        'kva_kw' => $equipoData['kva_kw'] ?? null,
                        'potencia' => $equipoData['potencia'] ?? null,
                        'potencia_unidad' => $equipoData['potencia_unidad'] ?? null,
                    ]);
                }
            } else {
                // Crear nuevo equipo
                $equipo = new Equipo([
                    'recepcion_id' => $recepcion->id,
                    'cliente_id' => $recepcion->cliente_id,
                    'nombre' => $equipoData['nombre'],

                    'modelo' => $equipoData['modelo'] ?? null,
                    'marca' => $equipoData['marca'],
                    'numero_serie' => $equipoData['serie'] ?? null,
                    'color' => isset($equipoData['color']) ? implode(',', (array) $equipoData['color']) : null,
                    'voltaje' => $equipoData['voltaje'] ?? null,
                    'hp' => $equipoData['hp'] ?? null,
                    'rpm' => $equipoData['rpm'] ?? null,
                    'hz' => $equipoData['hz'] ?? null,
                    'amperaje' => $equipoData['amperaje'] ?? null,
                    'cable_positivo' => $equipoData['cable_positivo'] ?? null,
                    'cable_negativo' => $equipoData['cable_negativo'] ?? null,
                    'kva_kw' => $equipoData['kva_kw'] ?? null,
                    'potencia' => $equipoData['potencia'] ?? null,
                    'potencia_unidad' => $equipoData['potencia_unidad'] ?? null,
                ]);
                $equipo->save();
            }

            // Guardar nuevas fotos
            if (isset($equipoData['fotos'])) {
                foreach ($equipoData['fotos'] as $foto) {
                    $path = $this->storeImage($foto, $equipo->id);
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $path,
                        'descripcion' => 'Nueva foto agregada'
                    ]);
                }
            }

            // Guardar fotos de cámara
            if (isset($equipoData['camera_photos'])) {
                foreach ($equipoData['camera_photos'] as $base64Photo) {
                    $path = $this->storeBase64Image($base64Photo, $equipo->id);
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $path,
                        'descripcion' => 'Foto tomada con cámara'
                    ]);
                }
            }
        }

        return redirect()->route('recepciones.index', $recepcion)
            ->with('success', 'Equipos actualizados correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recepcion $recepcion)
    {
        try {
            // Eliminar cotización asociada (si existe)
            if ($recepcion->cotizacion) {
                // Si la cotización tiene detalles, elimínalos aquí
                // Por ejemplo: $recepcion->cotizacion->detalles()->delete();
                $recepcion->cotizacion->delete();
            }

            // Eliminar equipos y sus fotos
            foreach ($recepcion->equipos as $equipo) {
                // Eliminar fotos del equipo
                foreach ($equipo->fotos as $foto) {
                    // Eliminar archivo físico
                    \Storage::disk('public')->delete($foto->ruta);
                    $foto->delete();
                }
                $equipo->delete();
            }

            // Finalmente, eliminar la recepción
            $recepcion->delete();

            return redirect()->route('recepciones.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Eliminado!',
                    'text' => 'Recepción eliminada correctamente'
                ]);
        } catch (\Exception $e) {
            return redirect()->route('recepciones.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al eliminar la recepción: ' . $e->getMessage()
                ]);
        }
    }

    private function storeImage($file, $equipoId)
    {
        $filename = 'equipo_' . $equipoId . '_' . time() . '_' . Str::random(8) . '.' . $file->extension();
        $path = $file->storeAs('equipos_fotos', $filename, 'public');
        return $path;
    }

    private function storeBase64Image($base64String, $equipoId)
    {
        // Extraer la imagen del string base64
        $imageData = explode(',', $base64String)[1];
        $imageData = base64_decode($imageData);

        // Crear nombre único para el archivo
        $filename = 'equipo_' . $equipoId . '_camera_' . time() . '_' . Str::random(8) . '.jpg';

        // Guardar en storage
        $path = 'equipos_fotos/' . $filename;
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }


}

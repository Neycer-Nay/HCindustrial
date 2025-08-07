<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngresosController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Ingreso::orderBy('created_at', 'desc');

        // Filtro por fecha
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Filtro por tipo de ingreso
        if ($request->filled('tipo_ingreso')) {
            $query->where('tipo_ingreso', $request->tipo_ingreso);
        }

        // Filtro por método de pago
        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        $ingresos = $query->get();

        // Calcular totales
        $totalIngresos = $ingresos->sum('total');
        $totalSubtotal = $ingresos->sum('subtotal');
        $totalDescuento = $ingresos->sum('descuento');

        // Obtener tipos de ingreso únicos para el filtro
        $tiposIngreso = \App\Models\Ingreso::distinct()->pluck('tipo_ingreso')->filter();
        
        // Obtener métodos de pago únicos para el filtro
        $metodosPago = \App\Models\Ingreso::distinct()->pluck('metodo_pago')->filter();

        return view('contabilidad.ingresos.ingresos', compact(
            'ingresos',
            'totalIngresos',
            'totalSubtotal',
            'totalDescuento',
            'tiposIngreso',
            'metodosPago'
        ));
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación de ingresos
        return view('contabilidad.ingresos.ingresos');
    }

    public function store(Request $request)
    {
        // Lógica para almacenar un nuevo ingreso
        $data = $request->validate([
            'tipo_ingreso' => 'required|string|max:255',
            'glosa' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'nro_recibo' => 'required|string|max:255',
            'metodo_pago' => 'required|in:Efectivo,Banco,Por cobrar',
            'subtotal' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'estado_pago' => 'required|in:Anticipo,Saldo,Completo',
        ]);
        $data['total'] = $data['subtotal'] - ($data['descuento'] ?? 0);
        \App\Models\Ingreso::create($data);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso creado exitosamente.');
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición de un ingreso
        $ingreso = \App\Models\Ingreso::findOrFail($id);
        return view('contabilidad.ingresos.edit', compact('ingreso'));
    }

    public function update(Request $request, $id)
    {   

       $ingreso = \App\Models\Ingreso::findOrFail($id);

    // Si solo se envía metodo_pago, actualiza solo ese campo
    if ($request->has('metodo_pago') && count($request->all()) == 3) { // _token y _method también llegan
        $request->validate([
            'metodo_pago' => 'required|in:Efectivo,Banco,Por cobrar',
        ]);
        $ingreso->update(['metodo_pago' => $request->metodo_pago]);
        return redirect()->route('ingresos.index')->with('success', 'Método de pago actualizado exitosamente.');
    }

        // Lógica para actualizar un ingreso existente
        $data = $request->validate([
            'tipo_ingreso' => 'required|string|max:255',
            'glosa' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'nro_recibo' => 'required|string|max:255',
            'metodo_pago' => 'required|in:Efectivo,Banco,Por cobrar',
            'subtotal' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'estado_pago' => 'required|in:Anticipo,Saldo,Completo',
        ]);
        $data['total'] = $data['subtotal'] - ($data['descuento'] ?? 0);
        $ingreso = \App\Models\Ingreso::findOrFail($id);
        $ingreso->update($data);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado exitosamente.');
    }

    public function destroy($id)
    {
        // Lógica para eliminar un ingreso
        $ingreso = \App\Models\Ingreso::findOrFail($id);
        $ingreso->delete();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado exitosamente.');
    }

    public function show($id)
    {
        // Lógica para mostrar los detalles de un ingreso
        $ingreso = \App\Models\Ingreso::findOrFail($id);
        return view('contabilidad.ingresos.ingreso', compact('ingreso'));
    }
}

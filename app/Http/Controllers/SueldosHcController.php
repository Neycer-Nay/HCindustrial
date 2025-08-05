<?php

namespace App\Http\Controllers;

use App\Models\SueldoHc;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SueldosHcController extends Controller
{
    public function index(Request $request)
    {
        $query = SueldoHc::with('trabajador');

        // Aplicar filtros
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_pago', [
                $request->fecha_inicio,
                $request->fecha_fin
            ]);
        }

        if ($request->filled('trabajador_id')) {
            $query->where('trabajador_id', $request->trabajador_id);
        }

        if ($request->filled('mes_pago')) {
            $query->where('mes_pago', 'like', '%' . $request->mes_pago . '%');
        }

        $sueldos = $query->orderBy('fecha_pago', 'desc')->get();

        // Calcular totales
        $totalSalarios = $sueldos->sum('salario');
        $totalDescuentos = $sueldos->sum('descuento');
        $totalHorasExtras = $sueldos->sum('horas_extras');
        $totalAnticipos = $sueldos->sum('anticipo');
        $totalLiquido = $sueldos->sum('total_liquido');

        // Obtener todos los trabajadores para los filtros
        $trabajadores = Trabajador::orderBy('nombres')->get();

        // Obtener meses únicos para filtros
        $mesesPago = SueldoHc::distinct()->pluck('mes_pago')->filter()->sort();

        return view('contabilidad.sueldos.indexSueldos', compact(
            'sueldos', 
            'totalSalarios', 
            'totalDescuentos', 
            'totalHorasExtras', 
            'totalAnticipos', 
            'totalLiquido',
            'trabajadores',
            'mesesPago'
        ));
    }

    public function storeTrabajador(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
        ]);

        Trabajador::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cargo' => $request->cargo,
        ]);

        return redirect()->route('sueldos.index')->with('success', 'Trabajador registrado exitosamente');
    }

    public function storeSueldo(Request $request)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'mes_pago' => 'required|string|max:255',
            'salario' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'horas_extras' => 'nullable|numeric|min:0',
            'anticipo' => 'nullable|numeric|min:0',
            'fecha_pago' => 'required|date',
        ]);

        // Calcular total líquido
        $salario = $request->salario;
        $descuento = $request->descuento ?? 0;
        $horasExtras = $request->horas_extras ?? 0;
        $anticipo = $request->anticipo ?? 0;
        
        $totalLiquido = $salario + $horasExtras - $descuento - $anticipo;

        SueldoHc::create([
            'trabajador_id' => $request->trabajador_id,
            'mes_pago' => $request->mes_pago,
            'salario' => $salario,
            'descuento' => $descuento,
            'horas_extras' => $horasExtras,
            'anticipo' => $anticipo,
            'total_liquido' => $totalLiquido,
            'fecha_pago' => $request->fecha_pago,
        ]);

        return redirect()->route('sueldos.index')->with('success', 'Pago de sueldo registrado exitosamente');
    }

    public function destroy($id)
    {
        $sueldo = SueldoHc::findOrFail($id);
        $sueldo->delete();

        return redirect()->route('sueldos.index')->with('success', 'Registro de sueldo eliminado exitosamente');
    }

    public function destroyTrabajador($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        
        // Verificar si el trabajador tiene sueldos asociados
        if ($trabajador->sueldos()->count() > 0) {
            return redirect()->route('sueldos.index')->with('error', 'No se puede eliminar el trabajador porque tiene pagos de sueldos asociados');
        }

        $trabajador->delete();

        return redirect()->route('sueldos.index')->with('success', 'Trabajador eliminado exitosamente');
    }

    public function getTrabajadores()
    {
        $trabajadores = Trabajador::orderBy('nombres')->get();
        return response()->json($trabajadores);
    }
}

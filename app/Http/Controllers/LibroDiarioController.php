<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;
use Carbon\Carbon;

class LibroDiarioController extends Controller
{
    public function index(Request $request)
    {
        // Obtener filtros de fecha si existen
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Query para ingresos
        $ingresosQuery = Ingreso::select(
            'id',
            'created_at as fecha',
            'tipo_ingreso as cuenta_nombre',
            'nro_recibo as numero_documento',
            'razon_social as cliente',
            'glosa as detalle',
            'total as importe'
        )->selectRaw("'ingreso' as tipo");

        // Query para egresos con relación a cuenta
        $egresosQuery = Egreso::with('cuenta')
            ->select(
                'id',
                'created_at as fecha',
                'cuenta_id',
                'nro_factura as numero_documento',
                'razon_social as cliente',
                'glosa as detalle',
                'total as importe'
            )->selectRaw("'egreso' as tipo");

        // Aplicar filtros de fecha si existen
        if ($fechaInicio) {
            $ingresosQuery->whereDate('created_at', '>=', $fechaInicio);
            $egresosQuery->whereDate('created_at', '>=', $fechaInicio);
        }

        if ($fechaFin) {
            $ingresosQuery->whereDate('created_at', '<=', $fechaFin);
            $egresosQuery->whereDate('created_at', '<=', $fechaFin);
        }

        // Obtener los datos
        $ingresos = $ingresosQuery->get()->map(function ($ingreso) {
            return [
                'fecha' => $ingreso->fecha,
                'cuenta_nombre' => $ingreso->cuenta_nombre,
                'numero_documento' => $ingreso->numero_documento,
                'cliente' => $ingreso->cliente,
                'detalle' => $ingreso->detalle,
                'importe' => $ingreso->importe,
                'ingreso' => $ingreso->importe,
                'egreso' => 0,
                'tipo' => $ingreso->tipo
            ];
        });

        $egresos = $egresosQuery->get()->map(function ($egreso) {
            return [
                'fecha' => $egreso->fecha,
                'cuenta_nombre' => $egreso->cuenta ? $egreso->cuenta->nombre_cuenta : 'Sin cuenta',
                'numero_documento' => $egreso->numero_documento,
                'cliente' => $egreso->cliente,
                'detalle' => $egreso->detalle,
                'importe' => $egreso->importe,
                'ingreso' => 0,
                'egreso' => $egreso->importe,
                'tipo' => $egreso->tipo
            ];
        });

        // Combinar y ordenar por fecha
        $libroDiario = $ingresos->concat($egresos)->sortBy('fecha')->values();

        // Calcular saldos acumulados
        $saldoAcumulado = 0;
        $libroDiario = $libroDiario->map(function ($item) use (&$saldoAcumulado) {
            $saldoAcumulado += $item['ingreso'] - $item['egreso'];
            $item['saldo'] = $saldoAcumulado;
            return $item;
        });

        // Calcular totales
        $totalIngresos = $ingresos->sum('ingreso');
        $totalEgresos = $egresos->sum('egreso');
        $saldoFinal = $totalIngresos - $totalEgresos;

        return view('contabilidad.libro-diario.index', compact(
            'libroDiario',
            'totalIngresos',
            'totalEgresos',
            'saldoFinal',
            'fechaInicio',
            'fechaFin'
        ));
    }
}
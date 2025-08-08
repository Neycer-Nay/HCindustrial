<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class Dashboard extends Controller
{
   
    
    public function index()
    {
        // Estadísticas básicas
        $totalClientes = \App\Models\Cliente::count();
        $totalRecepciones = \App\Models\Recepcion::count();
        $totalUsuarios = \App\Models\User::count();
        $totalEquipos = \App\Models\Equipo::count();
        $totalCotizaciones = \App\Models\Cotizacion::count();
        
        // Métricas financieras
        $totalIngresos = \App\Models\Ingreso::sum('total') ?? 0;
        $totalEgresos = \App\Models\Egreso::sum('total') ?? 0;
        $totalUtilidad = $totalIngresos - $totalEgresos;
        $ingresosMes = \App\Models\Ingreso::whereMonth('created_at', now()->month)
                                         ->whereYear('created_at', now()->year)
                                         ->sum('total') ?? 0;
        $egresosMes = \App\Models\Egreso::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->sum('total') ?? 0;

        $totalUtilidadMes = $ingresosMes - $egresosMes;

        // Estadísticas de recepciones por estado
        $recepcionesPendientes = \App\Models\Recepcion::where('estado', 'Pendiente')->count();
        $recepcionesEnProceso = \App\Models\Recepcion::where('estado', 'En proceso')->count();
        $recepcionesCompletadas = \App\Models\Recepcion::where('estado', 'Completado')->count();
        
        // Cotizaciones del mes
        $cotizacionesMes = \App\Models\Cotizacion::whereMonth('created_at', now()->month)
                                                ->whereYear('created_at', now()->year)
                                                ->count();
        
        // Recepciones recientes (últimas 5)
        $recepcionesRecientes = \App\Models\Recepcion::with(['cliente', 'usuario'])
                                                   ->orderBy('created_at', 'desc')
                                                   ->limit(5)
                                                   ->get();
        
        // Equipos más frecuentes por tipo
        $equiposPorTipo = \App\Models\Equipo::selectRaw('tipo, COUNT(*) as total')
                                          ->groupBy('tipo')
                                          ->orderBy('total', 'desc')
                                          ->limit(5)
                                          ->get();
        
        return view('modules.dashboard.home', compact(
            'totalClientes', 'totalRecepciones', 'totalUsuarios', 'totalEquipos', 'totalCotizaciones',
            'totalIngresos', 'totalEgresos', 'ingresosMes', 'egresosMes',
            'recepcionesPendientes', 'recepcionesEnProceso', 'recepcionesCompletadas',
            'cotizacionesMes', 'recepcionesRecientes', 'equiposPorTipo',
            'totalUtilidad', 'totalUtilidadMes'
        ));
    }
}

@extends('layouts.main')

@section('contenido')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 style="color:#151414">Panel de Control - HC Servicios Industrial</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Dashboard</div>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Clientes</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($totalClientes ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Equipos</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($totalEquipos ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Recepciones</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($totalRecepciones ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Cotizaciones</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($totalCotizaciones ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Métricas Financieras -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Ingresos Totales</h4>
                        </div>
                        <div class="card-body">
                            Bs. {{ number_format($totalIngresos ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Egresos Totales</h4>
                        </div>
                        <div class="card-body">
                            Bs. {{ number_format($totalEgresos ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Ingresos del Mes</h4>
                        </div>
                        <div class="card-body">
                            Bs. {{ number_format($ingresosMes ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-calendar-minus"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Egresos del Mes</h4>
                        </div>
                        <div class="card-body">
                            Bs. {{ number_format($egresosMes ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

         
        <!-- <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Estado de Recepciones</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="recepcionesChart" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Resumen Mensual</h4>
                    </div>
                    <div class="card-body">
                        <div class="summary-item">
                            <div class="summary-info">
                                <h4>{{ $cotizacionesMes ?? 0 }}</h4>
                                <span>Cotizaciones este mes</span>
                            </div>
                            <div class="summary-percentage">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i>
                                </span>
                            </div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-info">
                                <h4>{{ number_format((($ingresosMes ?? 0) - ($egresosMes ?? 0)), 2) }}</h4>
                                <span>Balance del mes (Bs.)</span>
                            </div>
                            <div class="summary-percentage">
                                <span class="{{ (($ingresosMes ?? 0) - ($egresosMes ?? 0)) >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="fas fa-{{ (($ingresosMes ?? 0) - ($egresosMes ?? 0)) >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

        <!-- Actividad Reciente y Equipos por Tipo -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Recepciones Recientes</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        
                                        <th>Responsable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recepcionesRecientes ?? [] as $recepcion)
                                        <tr>
                                            <td>{{ $recepcion->numero_recepcion }}</td>
                                            <td>{{ $recepcion->cliente->nombre ?? 'N/A' }}</td>
                                            <td>{{ $recepcion->fecha_ingreso ? \Carbon\Carbon::parse($recepcion->fecha_ingreso)->format('d/m/Y') : 'N/A' }}</td>
                                            
                                            <td>{{ $recepcion->usuario->nombre ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay recepciones recientes</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Equipos por Tipo</h4>
                    </div>
                    <div class="card-body">
                        @forelse($equiposPorTipo ?? [] as $equipo)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">{{ Str::title(str_replace('_', ' ', $equipo->tipo)) }}</h6>
                                </div>
                                <div>
                                    <span class="badge badge-primary">{{ $equipo->total }}</span>
                                </div>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ ($equipo->total / ($totalEquipos ?? 1)) * 100 }}%"
                                     aria-valuenow="{{ $equipo->total }}" aria-valuemin="0" aria-valuemax="{{ $totalEquipos ?? 1 }}">
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No hay datos disponibles</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Indicadores de Estado de Recepciones 
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pendientes</h4>
                        </div>
                        <div class="card-body">
                            {{ $recepcionesPendientes ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>En Proceso</h4>
                        </div>
                        <div class="card-body">
                            {{ $recepcionesEnProceso ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Completadas</h4>
                        </div>
                        <div class="card-body">
                            {{ $recepcionesCompletadas ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </section>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de estado de recepciones
    const ctx = document.getElementById('recepcionesChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'En Proceso', 'Completadas'],
            datasets: [{
                data: [
                    {{ $recepcionesPendientes ?? 0 }},
                    {{ $recepcionesEnProceso ?? 0 }},
                    {{ $recepcionesCompletadas ?? 0 }}
                ],
                backgroundColor: [
                    '#ffc107',
                    '#17a2b8',
                    '#28a745'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
@endsection
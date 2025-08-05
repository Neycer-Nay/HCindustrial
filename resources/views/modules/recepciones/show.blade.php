@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Detalle recepción N°:
                    {{ $recepcion->numero_recepcion }}
                </h1>
                <div class="section-header-breadcrumb">

                    <a href="{{ route('recepciones.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <div class="section-body">
                <!-- Información General de la Recepción -->
                <div class="card card-primary shadow-sm mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-info-circle"></i> Información General</h5>
                        <div class="card-header-action">
                            <!--<span class="badge badge-{{ 
                                        $recepcion->estado == 'RECIBIDO' ? 'primary' :
            ($recepcion->estado == 'EN_REPARACION' ? 'warning' :
                ($recepcion->estado == 'REPARADO' ? 'success' : 'secondary'))
                                    }}">
                                    {{ str_replace('_', ' ', $recepcion->estado) }}
                                </span>-->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-user"></i> Cliente:</strong> {{ $recepcion->cliente->nombre }}
                                </p>
                                <p><strong><i class="fas fa-user-tie"></i> Atendido por:</strong>
                                    {{ optional($recepcion->usuario)->nombre ?? 'N/A' }}</p>
                                
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-calendar-alt"></i> Fecha Recepción:</strong>
                                    {{ \Carbon\Carbon::parse($recepcion->fecha_ingreso)->format('d/m/Y') }}</p>
                                <p><strong><i class="fas fa-clock"></i> Hora Recepción:</strong>
                                    {{ \Carbon\Carbon::parse($recepcion->hora_ingreso)->format('H:i') }}</p>
                            </div>
                            <div class="col-12 mt-2">
                                <p><strong><i class="fas fa-sticky-note"></i> Observaciones de la Recepción:</strong></p>
                                <div class="form-control bg-light" style="min-height: 80px;">
                                    {{ $recepcion->observaciones ?: 'Sin observaciones' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipos Recibidos -->
                <div class="card card-info shadow-sm mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-tools"></i> Equipos Recibidos</h5>
                    </div>
                    <div class="card-body">
                        @foreach($recepcion->equipos as $equipo)
                            <div class="card card-warning shadow-sm mb-4">
                                <div class="card-header text-dark">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cog"></i> {{ $equipo->nombre }}

                                    </h5>
                                </div>

                                <div class="card-body">
                                    <h6 class="mb-0">
                                        <i class="fas fa-tools "></i>Categoria: {{ Str::title(str_replace('_', ' ',$equipo->tipo)) }}

                                    </h6>
                                    <div class="row">

                                        <!-- Columna izquierda - Datos del equipo -->
                                        <div class="col-lg-5 border-end">
                                            <div class="equipo-info p-3">
                                                <h6 class="text-primary"><i class="fas fa-info-circle"></i> Información Técnica
                                                </h6>
                                                <ul class="list-unstyled equipo-datos">
                                                    <!--<li><strong>N° de Serie:</strong> {{ $equipo->numero_serie ?? 'N/A' }}</li>-->

                                                    @if($equipo->tipo == 'MOTOR_ELECTRICO')
                                                        <li><strong>Marca:</strong> {{ $equipo->marca ?? 'N/A' }}</li>
                                                        <li><strong>Modelo:</strong> {{ $equipo->modelo ?? 'N/A' }}</li>
                                                        <li><strong>Color:</strong> {{ $equipo->color ?? 'N/A' }}</li>
                                                        <li><strong>Voltaje:</strong> {{ $equipo->voltaje ?? 'N/A' }}</li>
                                                        <li><strong>HP:</strong> {{ $equipo->hp ?? 'N/A' }}</li>
                                                        <li><strong>RPM:</strong> {{ $equipo->rpm ?? 'N/A' }}</li>
                                                        <li><strong>Hz:</strong> {{ $equipo->hz ?? 'N/A' }}</li>

                                                    @elseif($equipo->tipo == 'MAQUINA_SOLDADORA')
                                                        <li><strong>Marca:</strong> {{ $equipo->marca ?? 'N/A' }}</li>
                                                        <li><strong>Modelo:</strong> {{ $equipo->modelo ?? 'N/A' }}</li>
                                                        <li><strong>Color:</strong> {{ $equipo->color ?? 'N/A' }}</li>
                                                        <li><strong>Voltaje:</strong> {{ $equipo->voltaje ?? 'N/A' }}</li>
                                                        <li><strong>AMP:</strong> {{ $equipo->amperaje ?? 'N/A' }}</li>
                                                        <li><strong>Cable +:</strong> {{ $equipo->cable_positivo ?? 'N/A' }}</li>
                                                        <li><strong>Cable -:</strong> {{ $equipo->cable_negativo ?? 'N/A' }}</li>

                                                    @elseif($equipo->tipo == 'GENERADOR_DINAMO')
                                                        <li><strong>Marca:</strong> {{ $equipo->marca ?? 'N/A' }}</li>
                                                        <li><strong>Modelo:</strong> {{ $equipo->modelo ?? 'N/A' }}</li>
                                                        <li><strong>Color:</strong> {{ $equipo->color ?? 'N/A' }}</li>
                                                        <li><strong>Voltaje:</strong> {{ $equipo->voltaje ?? 'N/A' }}</li>
                                                        <li><strong>RPM:</strong> {{ $equipo->rpm ?? 'N/A' }}</li>
                                                        <li><strong>Hz:</strong> {{ $equipo->hz ?? 'N/A' }}</li>
                                                        <li><strong>Kva/Kw:</strong> {{ $equipo->kva_kw ?? 'N/A' }}</li>

                                                    @else
                                                        <li><strong>Marca:</strong> {{ $equipo->marca ?? 'N/A' }}</li>
                                                        <li><strong>Modelo:</strong> {{ $equipo->modelo ?? 'N/A' }}</li>
                                                        <li><strong>Color:</strong> {{ $equipo->color ?? 'N/A' }}</li>
                                                        <li><strong>Voltaje:</strong> {{ $equipo->voltaje ?? 'N/A' }}</li>
                                                        <li><strong>Potencia:</strong> {{ $equipo->potencia ?? 'N/A' }}</li>
                                                    @endif
                                                </ul>

                                                <!-- Información adicional oculta temportalmente 
                                                                <div class="mt-3">
                                                                    <h6 ><i class="fas fa-exclamation-triangle"></i>
                                                                        Información Adicional</h6>
                                                                    <ul class="list-unstyled">
                                                                        <li><strong>Partes Faltantes:</strong>
                                                                            {{ $equipo->partes_faltantes ?? 'N/A' }}</li>
                                                                        <li><strong>Observaciones:</strong>
                                                                            {{ $equipo->observaciones ?? 'N/A' }}</li>
                                                                    </ul>
                                                                </div>-->
                                            </div>
                                        </div>

                                        <!-- Columna derecha - Fotos del equipo -->
                                        <div class="col-lg-7">
                                            <div class="p-3">
                                                <h6 class="text-primary"><i class="fas fa-camera"></i> Fotos del Equipo</h6>
                                                <div class="fotos-container d-flex flex-wrap gap-2">
                                                    @if($equipo->fotos->count() > 0)
                                                        @foreach($equipo->fotos as $foto)
                                                            <div class="foto-item position-relative">
                                                                <a href="{{ Storage::url($foto->ruta) }}"
                                                                    data-lightbox="equipo-{{ $equipo->id }}"
                                                                    data-title="{{ $equipo->nombre }}">
                                                                    <img src="{{ asset('storage/' . $foto->ruta) }}"
                                                                        alt="Foto del equipo" class="img-thumbnail foto-img"
                                                                        width="250">
                                                                </a>
                                                                @if($foto->descripcion)
                                                                    <div class="foto-descripcion">
                                                                        <small class="text-muted">{{ $foto->descripcion }}</small>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="alert alert-info w-100">
                                                            <i class="fas fa-info-circle"></i> No hay fotos disponibles para este
                                                            equipo
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-right mb-3">
                    <a href="{{ route('recepciones.edit', $recepcion->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar Recepción
                    </a>

                </div>
                <!-- Botones de acción 
                <div class="text-right">
                    @if(!$cotizacion)
                        <a href="{{ route('cotizaciones.createFromRecepcion', $recepcion->id) }}" class="btn btn-success">
                            <i class="fas fa-file-invoice-dollar"></i> Crear Cotización
                        </a>
                    @else
                        <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Cotización
                        </a>
                        <a href="{{ route('cotizaciones.show', $cotizacion->recepcion->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver Cotización
                        </a>
                    @endif
                </div>-->
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <style>
        /* Estilos personalizados - Mismos que editCoti */
        .equipo-info {
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .foto-item {
            position: relative;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .foto-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            transition: all 0.3s;
        }

        .foto-img:hover {
            transform: scale(1.05);
            border: 2px solid #0d6efd;
        }

        .foto-descripcion {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2px 5px;
            font-size: 10px;
            border-radius: 0 0 6px 6px;
        }

        .badge {
            font-size: 0.9em;
            padding: 0.4em 0.8em;
        }

        .card-header-action {
            display: flex;
            align-items: center;
        }

        .alert {
            border-left: 4px solid #17a2b8;
            margin: 0;
        }

        .border-end {
            border-right: 1px solid #dee2e6 !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .list-unstyled li {
            margin-bottom: 0.25rem;
        }

        .text-muted {
            font-size: 0.9em;
        }
    </style>
@endsection
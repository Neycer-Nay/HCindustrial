
@extends('layouts.main')

@section('contenido')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 style="color:#151414">Detalle del Cliente</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('clientes.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="section-body">
            <!-- Datos del Cliente -->
            <div class="card card-primary shadow-sm mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-user-tie"></i> {{ $cliente->nombre }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag"></i> Tipo:</strong> {{ Str::title($cliente->tipo) }}</p>
                            <p><strong><i class="fas fa-id-card"></i> Documento:</strong> {{ $cliente->tipo_documento }} - {{ $cliente->numero_documento }}</p>
                            <p><strong><i class="fas fa-phone"></i> Teléfonos:</strong> {{ $cliente->telefono_1 }}
                                {{ $cliente->telefono_2 ? '  - ' . $cliente->telefono_2 : '' }}
                                {{ $cliente->telefono_3 ? '  - ' . $cliente->telefono_3 : '' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $cliente->email }}</p>
                            <p><strong><i class="fas fa-map-marker-alt"></i> Ciudad y Dirección:</strong> {{ $cliente->ciudad }} - {{ $cliente->direccion }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipos Relacionados -->
            <div class="card card-info shadow-sm mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-tools"></i> Equipos Relacionados del cliente</h5>
                </div>
                <div class="card-body">
                    @forelse($cliente->equipos as $equipo)
                        <div class="card card-warning shadow-sm mb-4">
                            <div class="card-header text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-cog"></i> {{ $equipo->nombre }}
                                    
                                </h5>
                            </div>
                            
                            <div class="card-body">
                                <h6 >
                                    <i class="fas fa-tools"></i>Categoria: {{ Str::title(str_replace('_', ' ', $equipo->tipo)) }}
                                </h6>
                                <div class="row">
                                    <!-- Columna izquierda - Datos del equipo -->
                                    <div class="col-lg-5 border-end">
                                        <div class="equipo-info p-3">
                                            <h6 class="text-primary"><i class="fas fa-info-circle"></i> Información Técnica</h6>
                                            <ul class="list-unstyled equipo-datos">
                                                <li><strong>N° Recepción:</strong> {{ $equipo->recepcion->numero_recepcion ?? 'Sin recepción asociada' }}</li>
                                                <!--<li><strong>Serie:</strong> {{ $equipo->numero_serie }}</li>-->
                                                <li><strong>Marca:</strong> {{ $equipo->marca }}</li>
                                                <li><strong>Modelo:</strong> {{ $equipo->modelo }}</li>
                                                <li><strong>Color:</strong> {{ $equipo->color ?? 'N/A' }}</li>
                                                <li><strong>Voltaje:</strong> {{ $equipo->voltaje ?? 'N/A' }}</li>
                                                @if($equipo->tipo == 'MOTOR_ELECTRICO')
                                                    <li><strong>Hp:</strong> {{ $equipo->hp ?? 'N/A' }}</li>
                                                    <li><strong>RPM:</strong> {{ $equipo->rpm ?? 'N/A' }}</li>
                                                    <li><strong>Hz:</strong> {{ $equipo->hz ?? 'N/A' }}</li>
                                                @elseif($equipo->tipo == 'MAQUINA_SOLDADORA')
                                                    <li><strong>AMP:</strong> {{ $equipo->amperaje ?? 'N/A' }}</li>
                                                    <li><strong>Cable +:</strong> {{ $equipo->cable_positivo ?? 'N/A' }}</li>
                                                    <li><strong>Cable -:</strong> {{ $equipo->cable_negativo ?? 'N/A' }}</li>

                                                @elseif($equipo->tipo == 'GENERADOR_DINAMO')
                                                    <li><strong>RPM:</strong> {{ $equipo->rpm ?? 'N/A' }}</li>
                                                    <li><strong>Hz:</strong> {{ $equipo->hz ?? 'N/A' }}</li>
                                                    <li><strong>Kva/Kw:</strong> {{ $equipo->kva_kw ?? 'N/A' }}</li>
                                                @else($equipo->tipo == 'OTRO')
                                                    <li><strong>Potencia:</strong> {{ $equipo->potencia ?? 'N/A' }}</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <!-- Columna derecha - Fotos del equipo -->
                                    <div class="col-lg-7">
                                        <div class="p-3">
                                            <h6 class="text-primary"><i class="fas fa-camera"></i> Fotos del Equipo</h6>
                                            <div class="fotos-container d-flex flex-wrap gap-2">
                                                @if($equipo->fotos && $equipo->fotos->count())
                                                    @foreach($equipo->fotos as $foto)
                                                        <div class="foto-item position-relative">
                                                            <a href="{{ Storage::url($foto->ruta) }}" target="_blank"
                                                               data-lightbox="equipo-{{ $equipo->id }}" 
                                                               data-title="{{ $equipo->nombre }}">
                                                                <img src="{{ asset('storage/' . $foto->ruta) }}" 
                                                                     alt="Foto del equipo" 
                                                                     class="img-thumbnail foto-img" width="250">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p class="text-muted">Sin fotos disponibles</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Este cliente no tiene equipos registrados.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recepciones asociadas -->
            <div class="card card-success shadow-sm mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-clipboard-list"></i> Recepciones asociadas al Cliente</h5>
                </div>
                <div class="card-body">
                    @forelse($cliente->recepciones as $recepcion)
                        <div class="card card-outline-info shadow-sm mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-1">
                                            N° Recepción: {{ $recepcion->numero_recepcion }}
                                        </h6>
                                        <p class="mb-1">
                                            <strong> Fecha y hora:</strong>
                                            {{ \Carbon\Carbon::parse($recepcion->fecha_ingreso)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($recepcion->hora_ingreso)->format('H:i') }}
                                        </p>
                                        <!--<p class="mb-1">
                                            <strong><i class="fas fa-flag"></i> Estado:</strong>
                                            <span class="badge badge-{{ $recepcion->estado == 'EN_REPARACION' ? 'warning' : ($recepcion->estado == 'REPARADO' ? 'success' : 'secondary') }}">
                                                {{ str_replace('_', ' ', $recepcion->estado) }}
                                            </span>
                                        </p>-->
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a href="{{ route('recepciones.show', $recepcion->id) }}"
                                           class="btn btn-info btn-sm" title="Ver detalle">
                                            <i class="fas fa-eye"></i> Ver detalle
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Este cliente no tiene recepciones registradas.
                        </div>
                    @endforelse
                </div>
            </div>
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
    
    .card-outline-info {
        border: 1px solid #17a2b8;
    }
    
    .badge {
        font-size: 0.8em;
    }
    
    .alert {
        border-left: 4px solid #17a2b8;
    }
</style>
@endsection
@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color: #151414">Detalle Cotización N°:
                    {{ $cotizacion->recepcion->numero_recepcion }}
                </h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('cotizaciones.pdf', $cotizacion->recepcion->id) }}" class="btn btn-danger"
                        target="_blank">
                        <i class="fas fa-file-pdf"></i> Generar PDF
                    </a>
                </div>
            </div>

            <div class="section-body">
                <!-- Datos del Cliente -->
                <div class="card card-primary shadow-sm mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-user"></i> Datos del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-id-card"></i> Nombre:</strong>
                                    {{ $cotizacion->recepcion->cliente->nombre }}</p>
                                <p><strong><i class="fas fa-phone"></i> Teléfono:</strong>
                                    {{ $cotizacion->recepcion->cliente->telefono_1 }}
                                    {{ $cotizacion->recepcion->cliente->telefono_2 ? '  - ' . $cotizacion->recepcion->cliente->telefono_2 : '' }}
                                    {{ $cotizacion->recepcion->cliente->telefono_3 ? '  - ' . $cotizacion->recepcion->cliente->telefono_3 : '' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-envelope"></i> Email:</strong>
                                    {{ $cotizacion->recepcion->cliente->email }}</p>
                                <p><strong><i class="fas fa-map-marker-alt"></i> Dirección:</strong>
                                    {{ $cotizacion->recepcion->cliente->ciudad }} -
                                    {{ $cotizacion->recepcion->cliente->direccion }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen de la Cotización -->
                <div class="card card-info shadow-sm mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-calculator"></i> Resumen de la Cotización</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Subtotal</h6>
                                        <h4>Bs. {{ number_format($cotizacion->subtotal, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Descuento</h6>
                                        <h4>Bs. {{ number_format($cotizacion->descuento, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h6>Total</h6>
                                        <h4>Bs. {{ number_format($cotizacion->total, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipos de la Cotización -->
                @foreach($cotizacion->equipos as $cotizacionEquipo)
                    @php
                        $equipo = $cotizacionEquipo->equipo;
                        $fotosSeleccionadas = $cotizacionEquipo->fotos; // Relación, no JSON
                        $repuestos = $cotizacionEquipo->repuestos;
                        $servicios = $cotizacionEquipo->servicios;
                    @endphp

                    <div class="card card-warning shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-tools"></i> Equipo: {{ $equipo->nombre }}

                            </h5>
                        </div>

                        <div class="card-body">
                            <h6>
                                <i class="fas fa-tools"></i>Categoria: {{ Str::title(str_replace('_', ' ', $equipo->tipo)) }}
                            </h6>
                            <div class="row">
                                <!-- Columna izquierda - Datos del equipo -->
                                <div class="col-lg-5 border-end">
                                    <div class="equipo-info p-3">
                                        <h6 class="text-primary"><i class="fas fa-info-circle"></i> Información Técnica</h6>
                                        <ul class="list-unstyled equipo-datos">
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
                                                <li>
                                                    <strong>Potencia:</strong>
                                                    {{ $equipo->potencia ?? 'N/A' }}
                                                    @if($equipo->potencia_unidad)
                                                    <span>{{ $equipo->potencia_unidad ?? 'N/A'}}</span>
                                                    @endif
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    <!-- Fotos seleccionadas -->
                                    <div class="mt-4">
                                        <h6 class="text-primary"><i class="fas fa-camera"></i> Fotos Seleccionadas para PDF</h6>
                                        <div class="fotos-container d-flex flex-wrap gap-2">
                                            @if($fotosSeleccionadas && $fotosSeleccionadas->count())
                                                @foreach($fotosSeleccionadas as $foto)
                                                    <div class="foto-item">
                                                        <a href="{{ Storage::url($foto->ruta) }}"
                                                            data-lightbox="equipo-{{ $equipo->id }}" data-title="{{ $equipo->nombre }}">
                                                            <img src="{{ asset('storage/' . $foto->ruta) }}" alt="Foto seleccionada"
                                                                class="img-thumbnail"
                                                                style="width: 80px; height: 80px; object-fit: cover;">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted">No se seleccionaron fotos para el PDF</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna derecha - Trabajo y repuestos -->
                                <div class="col-lg-7">
                                    <div class="trabajo-info p-3">
                                        <h6><i class="fas fa-wrench"></i> Trabajo a Realizar</h6>
                                        <p class="bg-light p-2 rounded">
                                            {{ $cotizacionEquipo->trabajo_realizar ?: 'No especificado' }}
                                        </p>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <strong>Precio del Trabajo:</strong> Bs.
                                                {{ number_format($cotizacionEquipo->precio_trabajo, 2) }}
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Total Repuestos:</strong> Bs.
                                                {{ number_format($cotizacionEquipo->total_repuestos, 2) }}
                                            </div>
                                        </div>

                                        <h6><i class="fas fa-cogs"></i> Repuestos a Usar</h6>
                                        @if(!empty($repuestos))
                                            <div class="table-responsive">
                                                <table class="table table-sm table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Repuesto</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio Unit.</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($repuestos as $repuesto)
                                                            <tr>
                                                                <td>{{ $repuesto['nombre'] ?? 'N/A' }}</td>
                                                                <td>{{ $repuesto['cantidad'] ?? 0 }}</td>
                                                                <td>Bs. {{ number_format($repuesto['precio_unitario'] ?? 0, 2) }}</td>
                                                                <td>Bs.
                                                                    {{ number_format(($repuesto['cantidad'] ?? 0) * ($repuesto['precio_unitario'] ?? 0), 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">No se especificaron repuestos</p>
                                        @endif

                                        <!-- Servicios a realizar -->
                                        <h6><i class="fas fa-cogs"></i> Servicios a Realizar</h6>
                                        @if(!empty($servicios))
                                            <div class="table-responsive">
                                                <table class="table table-sm table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Servicio</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($servicios as $servicio)
                                                            <tr>
                                                                <td>{{ $servicio['nombre'] ?? 'N/A' }}</td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">No se especificaron servicios</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-right">
                <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar Cotización
                </a>
            </div>
        </section>
    </div>
@endsection
@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Editar Cotización N° {{ $cotizacion->recepcion->numero_recepcion }}</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('cotizaciones.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <div class="section-body">
                <!-- Datos del Cliente -->
                <div class="card card-primary shadow-sm mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-user-tie"></i> Datos del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-id-card"></i> Nombre:</strong> {{ $cotizacion->recepcion->cliente->nombre }}</p>
                                <p><strong><i class="fas fa-phone"></i> Teléfono:</strong> {{ $cotizacion->recepcion->cliente->telefono_1 }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $cotizacion->recepcion->cliente->email }}</p>
                                <p><strong><i class="fas fa-map-marker-alt"></i> Dirección:</strong> {{ $cotizacion->recepcion->cliente->ciudad }} - {{ $cotizacion->recepcion->cliente->direccion }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST" id="cotizacionForm">
                    @csrf
                    @method('PUT')

                    <!-- Sección de Descuento -->
                    <div class="card card-info shadow-sm mb-4">
                        <div class="card-header">
                            <h5><i class="fas fa-percentage"></i> Descuento General</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="descuento" class="col-md-2 col-form-label text-md-right">
                                    <strong>Monto de descuento (Bs):</strong>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                        <input type="number" min="0" step="0.01" name="descuento" id="descuento"
                                            class="form-control" value="{{ old('descuento', $cotizacion->descuento) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipos -->
                    @foreach($cotizacion->equipos as $cotizacionEquipo)
                        @php
                            $equipo = $cotizacionEquipo->equipo;
                        @endphp
                        <div class="card card-warning shadow-sm mb-4">
                            <div class="card-header text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-tools"></i> Equipo: {{ $equipo->nombre }}
                                </h5>
                            </div>

                            <div class="card-body">
                                <input type="hidden" name="equipos[{{ $loop->index }}][equipo_id]" value="{{ $equipo->id }}">
                                <h6 class="mb-3">
                                    <i class="fas fa-tools"></i>Categoria: {{ Str::title(str_replace('_', ' ', $equipo->tipo)) }}
                                </h6>

                                <div class="row">
                                    <!-- Columna izquierda - Datos del equipo -->
                                    <div class="col-lg-5 border-end">
                                        <div class="equipo-info p-3">
                                            <h6 class="text-primary"><i class="fas fa-info-circle"></i> Información Técnica</h6>
                                            <ul class="list-unstyled">
                                                <li><strong>Serie:</strong> {{ $equipo->numero_serie }}</li>
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
                                                @else
                                                    <li><strong>Potencia:</strong> {{ $equipo->potencia ?? 'N/A' }}</li>
                                                @endif
                                            </ul>

                                            <!-- Fotos del equipo -->
                                            <div class="mt-4">
                                                <h6 class="text-primary"><i class="fas fa-camera"></i> Fotos Asociadas</h6>
                                                <p class="text-muted">Seleccione fotos para incluir en el PDF:</p>
                                                <div class="fotos-container d-flex flex-wrap gap-2" data-equipo="{{ $loop->index }}">
                                                    @if($equipo->fotos && $equipo->fotos->count())
                                                        @foreach($equipo->fotos as $foto)
                                                            @php
                                                                $isSelected = $cotizacionEquipo->fotos->contains('id', $foto->id);
                                                            @endphp
                                                            <div class="foto-item position-relative" data-foto-id="{{ $foto->id }}">
                                                                <input type="checkbox"
                                                                    id="foto_{{ $loop->parent->index }}_{{ $foto->id }}"
                                                                    name="equipos[{{ $loop->parent->index }}][fotos][]"
                                                                    value="{{ $foto->id }}" 
                                                                    class="foto-checkbox visually-hidden" 
                                                                    {{ $isSelected ? 'checked' : '' }}>
                                                                <label for="foto_{{ $loop->parent->index }}_{{ $foto->id }}" class="foto-label">
                                                                    <img src="{{ asset('storage/' . $foto->ruta) }}"
                                                                        alt="Foto del equipo" class="img-thumbnail foto-img">
                                                                    <div class="foto-overlay">
                                                                        
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted">No hay fotos disponibles para este equipo</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Columna derecha - Formulario de cotización -->
                                    <div class="col-lg-7">
                                        <!-- Descripción del trabajo -->
                                        <div class="mb-4">
                                            <label for="descripcion_{{ $equipo->id }}" class="form-label text-primary">
                                                <i class="fas fa-clipboard-list"></i> Descripción del trabajo a realizar <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="equipos[{{ $loop->index }}][descripcion]"
                                                id="descripcion_{{ $equipo->id }}" class="form-control" rows="3"
                                                placeholder="Describa detalladamente el trabajo a realizar...">{{ old('equipos.' . $loop->index . '.descripcion', $cotizacionEquipo->trabajo_realizar) }}</textarea>
                                        </div>

                                        <!-- Valor del trabajo -->
                                        <div class="mb-4">
                                            <label for="valor_trabajo_{{ $equipo->id }}" class="form-label text-primary">
                                                <i class="fas fa-dollar-sign"></i> Valor del trabajo (Bs) <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">Bs</span>
                                                <input type="number" min="0" step="0.01"
                                                    name="equipos[{{ $loop->index }}][valor_trabajo]"
                                                    id="valor_trabajo_{{ $equipo->id }}" class="form-control"
                                                    value="{{ old('equipos.' . $loop->index . '.valor_trabajo', $cotizacionEquipo->precio_trabajo) }}">
                                            </div>
                                        </div>

                                        <!-- Repuestos -->
                                        <div class="repuestos-container">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-cogs"></i> Repuestos a utilizar <span class="text-danger">*</span>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="agregarRepuesto({{ $loop->index }})">
                                                    <i class="fas fa-plus"></i> Agregar
                                                </button>
                                            </h6>

                                            <div id="repuestos-container-{{ $loop->index }}">
                                                @foreach($cotizacionEquipo->repuestos as $repuesto)
                                                    <div class="repuesto-item card mb-3">
                                                        <div class="card-body">
                                                            <div class="row g-2">
                                                                <div class="col-md-6">
                                                                    <label class="form-label small">Nombre del repuesto <span class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        name="equipos[{{ $loop->parent->index }}][repuestos_detalle][{{ $loop->index }}][nombre]"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ old('equipos.' . $loop->parent->index . '.repuestos_detalle.' . $loop->index . '.nombre', $repuesto->nombre) }}">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label small">Cantidad <span class="text-danger">*</span></label>
                                                                    <input type="number" 
                                                                        name="equipos[{{ $loop->parent->index }}][repuestos_detalle][{{ $loop->index }}][cantidad]"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ old('equipos.' . $loop->parent->index . '.repuestos_detalle.' . $loop->index . '.cantidad', $repuesto->cantidad) }}">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label small">Precio U. (Bs) <span class="text-danger">*</span></label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-text">Bs</span>
                                                                        <input type="number" 
                                                                            name="equipos[{{ $loop->parent->index }}][repuestos_detalle][{{ $loop->index }}][precio]"
                                                                            class="form-control"
                                                                            value="{{ old('equipos.' . $loop->parent->index . '.repuestos_detalle.' . $loop->index . '.precio', $repuesto->precio_unitario) }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="text-end mt-2">
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="eliminarRepuesto(this)">
                                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Servicios -->
                                        <div class="servicios-container mt-4">
                                            <h6 class="mb-3">
                                                <i class="fas fa-cogs"></i> Servicios a realizar <span class="text-danger">*</span>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="agregarServicio({{ $loop->index }})">
                                                    <i class="fas fa-plus"></i> Agregar
                                                </button>
                                            </h6>
                                            <div id="servicios-container-{{ $loop->index }}">
                                                @foreach($cotizacionEquipo->servicios as $servicio)
                                                    <div class="servicio-item card mb-2">
                                                        <div class="card-body py-2">
                                                            <div class="row g-2 align-items-center">
                                                                <div class="col-md-10">
                                                                    <label class="form-label small mb-1">Nombre del servicio <span class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        name="equipos[{{ $loop->parent->index }}][servicios_detalle][{{ $loop->index }}][nombre]"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ old('equipos.' . $loop->parent->index . '.servicios_detalle.' . $loop->index . '.nombre', $servicio->nombre) }}">
                                                                </div>
                                                                <div class="col-md-2 text-end">
                                                                    <button type="button" class="btn btn-danger btn-sm mt-3"
                                                                        onclick="eliminarServicio(this)">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="text-right mb-3">
                                <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Cotización
                                </button>
                            
                        </div>
                    
                    @endforeach

                    <!-- Botones de acción -->
                    
                       
                </form>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <style>
        .equipo-info {
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .foto-item {
            position: relative;
            cursor: pointer;
            margin: 5px;
        }

        .foto-label {
            display: block;
            cursor: pointer;
            position: relative;
            margin: 0;
        }

        .foto-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .foto-checkbox:checked+.foto-label .foto-img {
            border: 3px solid #0d6efd;
            opacity: 0.8;
        }

        .foto-overlay {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(13, 110, 253, 0.9);
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .foto-checkbox:checked+.foto-label .foto-overlay {
            opacity: 1;
        }

        .repuesto-item {
            border-left: 3px solid #0dcaf0;
        }

        .fixed-bottom {
            position: sticky;
            bottom: 0;
            z-index: 1030;
        }

        .visually-hidden {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
        }

        .fotos-container {
            transition: border 0.3s ease;
            padding: 10px;
            border: 2px dashed #dee2e6;
            border-radius: 5px;
        }

        .fotos-container.has-selection {
            border-color: #28a745;
        }

        .fotos-container.no-selection {
            border-color: #dc3545;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function agregarRepuesto(equipoIndex) {
            const container = document.getElementById(`repuestos-container-${equipoIndex}`);
            const count = container.querySelectorAll('.repuesto-item').length;

            const html = `
                <div class="repuesto-item card mb-3">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Nombre del repuesto <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="equipos[${equipoIndex}][repuestos_detalle][${count}][nombre]"
                                       class="form-control form-control-sm">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small">Cantidad <span class="text-danger">*</span></label>
                                <input type="number" min="1" max="9999"
                                       name="equipos[${equipoIndex}][repuestos_detalle][${count}][cantidad]"
                                       class="form-control form-control-sm"
                                       value="0">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small">Precio U. (Bs) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Bs</span>
                                    <input type="number" 
                                           name="equipos[${equipoIndex}][repuestos_detalle][${count}][precio]"
                                           class="form-control"
                                           value="0">
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-2">
                            <button type="button" class="btn btn-danger btn-sm"
                                    onclick="eliminarRepuesto(this)">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
                `;

            container.insertAdjacentHTML('beforeend', html);
        }

        function eliminarRepuesto(button) {
            const repuestoItem = button.closest('.repuesto-item');
            const container = repuestoItem.closest('[id^="repuestos-container-"]');

            if (container.querySelectorAll('.repuesto-item').length > 1) {
                repuestoItem.remove();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No se puede eliminar',
                    text: 'Debe tener al menos un repuesto por equipo.',
                    confirmButtonText: 'Entendido'
                });
            }
        }

        function agregarServicio(equipoIndex) {
            const container = document.getElementById(`servicios-container-${equipoIndex}`);
            const count = container.querySelectorAll('.servicio-item').length;

            const html = `
                <div class="servicio-item card mb-2">
                    <div class="card-body py-2">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-10">
                                <label class="form-label small mb-1">Nombre del servicio <span class="text-danger">*</span></label>
                                <input type="text"
                                    name="equipos[${equipoIndex}][servicios_detalle][${count}][nombre]"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-danger btn-sm mt-3"
                                    onclick="eliminarServicio(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function eliminarServicio(button) {
            const servicioItem = button.closest('.servicio-item');
            const container = servicioItem.closest('[id^="servicios-container-"]');
            if (container.querySelectorAll('.servicio-item').length > 1) {
                servicioItem.remove();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No se puede eliminar',
                    text: 'Debe tener al menos un servicio por equipo.',
                    confirmButtonText: 'Entendido'
                });
            }
        }

        // Manejo visual de fotos y validaciones
        document.addEventListener('DOMContentLoaded', function () {
            function actualizarEstadoFotos() {
                document.querySelectorAll('.fotos-container').forEach(container => {
                    const fotosSeleccionadas = container.querySelectorAll('.foto-checkbox:checked');
                    container.classList.remove('has-selection', 'no-selection');

                    if (fotosSeleccionadas.length > 0) {
                        container.classList.add('has-selection');
                    } else {
                        container.classList.add('no-selection');
                    }
                });
            }

            document.addEventListener('change', function (e) {
                if (e.target.matches('.foto-checkbox')) {
                    actualizarEstadoFotos();
                }
            });

            actualizarEstadoFotos();

            // Validación del formulario
            const form = document.getElementById('cotizacionForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    
                    let equiposConErrores = [];
                    const equipos = document.querySelectorAll('.card-warning');

                    equipos.forEach((equipo, index) => {
                        const equipoNumero = index + 1;
                        const equipoNombreElement = equipo.querySelector('h5');
                        const equipoNombre = equipoNombreElement ? equipoNombreElement.textContent.trim() : `Equipo ${equipoNumero}`;

                        // Validar fotos
                        const fotosSeleccionadas = equipo.querySelectorAll('.foto-checkbox:checked');
                        if (fotosSeleccionadas.length === 0) {
                            equiposConErrores.push(`${equipoNombre}: Debe seleccionar al menos una foto`);
                        }

                        // Validar descripción
                        const descripcion = equipo.querySelector('textarea[name*="[descripcion]"]');
                        if (!descripcion || !descripcion.value.trim()) {
                            equiposConErrores.push(`${equipoNombre}: La descripción del trabajo es obligatoria`);
                        } else if (descripcion.value.trim().length < 10) {
                            equiposConErrores.push(`${equipoNombre}: La descripción debe tener al menos 10 caracteres`);
                        }

                        // Validar valor del trabajo
                        const valorTrabajo = equipo.querySelector('input[name*="[valor_trabajo]"]');
                        if (!valorTrabajo || !valorTrabajo.value || parseFloat(valorTrabajo.value) <= 0) {
                            equiposConErrores.push(`${equipoNombre}: El valor del trabajo debe ser mayor a 0`);
                        }

                        // Validar repuestos SOLO NOMBRE
        const repuestos = equipo.querySelectorAll('.repuesto-item');
        if (repuestos.length === 0) {
            equiposConErrores.push(`${equipoNombre}: Debe agregar al menos un repuesto`);
        } else {
            repuestos.forEach((repuesto, repuestoIndex) => {
                const nombreRepuesto = repuesto.querySelector('input[name*="[nombre]"]');
                const repuestoNum = repuestoIndex + 1;

                if (!nombreRepuesto || !nombreRepuesto.value.trim()) {
                    equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: El nombre es obligatorio`);
                } else if (nombreRepuesto.value.trim().length < 3) {
                    equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: El nombre debe tener al menos 3 caracteres`);
                }
            });
        }

        // Validar servicios SOLO NOMBRE
        const servicios = equipo.querySelectorAll('.servicio-item');
        if (servicios.length === 0) {
            equiposConErrores.push(`${equipoNombre}: Debe agregar al menos un servicio`);
        } else {
            servicios.forEach((servicio, servicioIndex) => {
                const nombreServicio = servicio.querySelector('input[name*="[nombre]"]');
                const servicioNum = servicioIndex + 1;

                if (!nombreServicio || !nombreServicio.value.trim()) {
                    equiposConErrores.push(`${equipoNombre} - Servicio ${servicioNum}: El nombre del servicio es obligatorio`);
                } else if (nombreServicio.value.trim().length < 3) {
                    equiposConErrores.push(`${equipoNombre} - Servicio ${servicioNum}: El nombre del servicio debe tener al menos 3 caracteres`);
                }
            });
        }
                    });

                    if (equiposConErrores.length > 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Errores en el formulario',
                            html: `<div style="text-align: left; max-height: 400px; overflow-y: auto; padding: 10px;">
                                       <p><strong>Corrige los siguientes errores:</strong></p>
                                       <ul style="margin: 0;">
                                           ${equiposConErrores.map(error => `<li style="margin-bottom: 5px;">${error}</li>`).join('')}
                                       </ul>
                                   </div>`,
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#dc3545',
                            width: '600px'
                        });
                    } else {
                        Swal.fire({
                            icon: 'question',
                            title: '¿Actualizar cotización?',
                            text: 'Se actualizará la cotización con todos los cambios realizados.',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, actualizar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#6c757d'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Actualizando...',
                                    text: 'Por favor espere mientras se procesa la actualización.',
                                    allowOutsideClick: false,
                                    didOpen: () => Swal.showLoading()
                                });
                                form.submit();
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
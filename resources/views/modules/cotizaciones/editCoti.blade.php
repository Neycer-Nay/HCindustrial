@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414"> Cotización para Recepción N° {{ $recepcion->numero_recepcion }}</h1>
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
                                <p><strong><i class="fas fa-id-card"></i> Nombre:</strong> {{ $recepcion->cliente->nombre }}
                                </p>
                                <p><strong><i class="fas fa-phone"></i> Teléfono:</strong>
                                    {{ $recepcion->cliente->telefono_1 }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $recepcion->cliente->email }}
                                </p>
                                <p><strong><i class="fas fa-map-marker-alt"></i> Dirección:</strong>
                                    {{ $recepcion->cliente->ciudad }} - {{ $recepcion->cliente->direccion }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cotizaciones.store', $recepcion->id) }}" method="POST" id="cotizacionForm">
                    @csrf

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
                                            class="form-control" value="{{ old('descuento', 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipos -->
                    @foreach($recepcion->equipos as $equipo)
                        <div class="card card-warning shadow-sm mb-4">
                            <div class="card-header text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-tools"></i> Equipo: {{ $equipo->nombre }}
                                </h5>
                            </div>

                            <div class="card-body">
                                <input type="hidden" name="equipos[{{ $loop->index }}][equipo_id]" value="{{ $equipo->id }}">
                                <h6 class="mb-3">
                                    <i class="fas fa-tools"></i> Categoria: {{ Str::title( str_replace('_', ' ', $equipo->tipo)) }}
                                </h6>

                                <div class="row">
                                    <!-- Columna izquierda - Datos del equipo -->
                                    <div class="col-lg-5 border-end">
                                        <div class="equipo-info p-3">
                                            <h6 class="text-primary"><i class="fas fa-info-circle"></i> Información Técnica</h6>
                                            <ul class="list-unstyled equipo-datos">
                                                
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
                                                <div class="fotos-container d-flex flex-wrap gap-2"
                                                    data-equipo="{{ $loop->index }}">
                                                    @if($equipo->fotos && $equipo->fotos->count())
                                                        @foreach($equipo->fotos as $foto)
                                                            <div class="foto-item position-relative" data-foto-id="{{ $foto->id }}">
                                                                <input type="checkbox"
                                                                    id="foto_{{ $loop->parent->index }}_{{ $foto->id }}"
                                                                    name="equipos[{{ $loop->parent->index }}][fotos][]"
                                                                    value="{{ $foto->id }}" class="foto-checkbox visually-hidden" {{ isset(old('equipos')[$loop->parent->index]['fotos']) && in_array($foto->id, old('equipos')[$loop->parent->index]['fotos']) ? 'checked' : '' }}>
                                                                <label for="foto_{{ $loop->parent->index }}_{{ $foto->id }}"
                                                                    class="foto-label">
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
                                                <i class="fas fa-clipboard-list"></i> Descripción del trabajo a realizar <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <textarea name="equipos[{{ $loop->index }}][descripcion]"
                                                id="descripcion_{{ $equipo->id }}" class="form-control" rows="3"
                                                placeholder="Describa detalladamente el trabajo a realizar...">{{ old('equipos.' . $loop->index . '.descripcion') }}</textarea>
                                        </div>

                                        <!-- Valor del trabajo -->
                                        <div class="mb-4">
                                            <label for="valor_trabajo_{{ $equipo->id }}" class="form-label text-primary">
                                                <i class="fas fa-dollar-sign"></i> Valor del trabajo (Bs) <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">Bs</span>
                                                <input type="number" min="0" step="0.01"
                                                    name="equipos[{{ $loop->index }}][valor_trabajo]"
                                                    id="valor_trabajo_{{ $equipo->id }}" class="form-control"
                                                    value="{{ old('equipos.' . $loop->index . '.valor_trabajo', 0) }}">
                                            </div>
                                        </div>

                                        <!-- Repuestos -->
                                        <div class="repuestos-container">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-cogs"></i> Repuestos a utilizar <span
                                                    class="text-danger">*</span>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="agregarRepuesto({{ $loop->index }})">
                                                    <i class="fas fa-plus"></i> Agregar
                                                </button>
                                            </h6>

                                            <div id="repuestos-container-{{ $loop->index }}">
                                                @php
                                                    $repuestos = old('equipos.' . $loop->index . '.repuestos_detalle', []);
                                                    if (empty($repuestos)) {
                                                        $repuestos = [['nombre' => '', 'cantidad' => 1, 'precio' => 0]];
                                                    }
                                                @endphp

                                                @foreach($repuestos as $index => $repuesto)
                                                    <div class="repuesto-item card mb-3">
                                                        <div class="card-body">
                                                            <div class="row g-2">
                                                                <div class="col-md-6">
                                                                    <label class="form-label small">Nombre del repuesto <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        name="equipos[{{ $loop->parent->index }}][repuestos_detalle][{{ $index }}][nombre]"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $repuesto['nombre'] }}">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label small">Cantidad <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" min="1" max="9999"
                                                                        name="equipos[{{ $loop->parent->index }}][repuestos_detalle][{{ $index }}][cantidad]"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $repuesto['cantidad'] }}">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label small">Precio U. (Bs) <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-text">Bs</span>
                                                                        <input type="number" min="0.01" max="999999.99" step="0.01"
                                                                            name="equipos[{{ $loop->parent->index }}][repuestos_detalle][{{ $index }}][precio]"
                                                                            class="form-control" value="{{ $repuesto['precio'] }}">
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
                                        <div class="servicios-container mt-4">
                                            <h6 class=" mb-3">
                                                <i class="fas fa-cogs"></i>Servicios a realizar <span
                                                    class="text-danger">*</span>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="agregarServicio({{ $loop->index }})">
                                                    <i class="fas fa-plus"></i> Agregar
                                                </button>
                                            </h6>
                                            <div id="servicios-container-{{ $loop->index }}">
                                                @php
                                                    $servicios = old('equipos.' . $loop->index . '.servicios_detalle', []);
                                                    if (empty($servicios)) {
                                                        $servicios = [['nombre' => '']];
                                                    }
                                                @endphp

                                                @foreach($servicios as $sindex => $servicio)
                                                    <div class="servicio-item card mb-2">
                                                        <div class="card-body py-2">
                                                            <div class="row g-2 align-items-center">
                                                                <div class="col-md-10">
                                                                    <label class="form-label small mb-1">Nombre del servicio <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        name="equipos[{{ $loop->parent->index }}][servicios_detalle][{{ $sindex }}][nombre]"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $servicio['nombre'] }}">
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
                    @endforeach

                    <!-- Botones de acción -->
                    <div class="fixed-bottom bg-white p-3 shadow-lg border-top">
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Guardar Cotización
                                </button>
                            </div>
                        </div>
                    </div>
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
                                           value="1">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small">Precio U. (Bs) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">Bs</span>
                                        <input type="number" min="0.01" max="999999.99" step="0.01"
                                               name="equipos[${equipoIndex}][repuestos_detalle][${count}][precio]"
                                               class="form-control"
                                               value="0.01">
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

            // No eliminar si es el último repuesto
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

        // Esperar a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM cargado - Iniciando validaciones');

            // Manejo visual de fotos
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

            // Escuchar cambios en checkboxes de fotos
            document.addEventListener('change', function (e) {
                if (e.target.matches('.foto-checkbox')) {
                    actualizarEstadoFotos();
                }
            });

            // Inicializar estado visual
            actualizarEstadoFotos();

            // VALIDACIÓN DEL FORMULARIO
            const form = document.getElementById('cotizacionForm');
            if (!form) {
                console.error('No se encontró el formulario');
                return;
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                console.log('Formulario enviado - Iniciando validación');

                let equiposSinFoto = [];
                let equiposConErrores = [];

                // Obtener todos los equipos
                const equipos = document.querySelectorAll('.card-warning');
                console.log('Equipos encontrados:', equipos.length);

                equipos.forEach((equipo, index) => {
                    const equipoNumero = index + 1;
                    const equipoNombreElement = equipo.querySelector('h5');
                    const equipoNombre = equipoNombreElement ? equipoNombreElement.textContent.trim() : `Equipo ${equipoNumero}`;

                    // ✅ VALIDAR FOTOS SELECCIONADAS (OBLIGATORIAS)
                    const fotosSeleccionadas = equipo.querySelectorAll('.foto-checkbox:checked');
                    console.log(`Equipo ${equipoNumero} - Fotos seleccionadas:`, fotosSeleccionadas.length);

                    if (fotosSeleccionadas.length === 0) {
                        equiposConErrores.push(`${equipoNombre}: Debe seleccionar al menos una foto`);
                    }

                    // ✅ VALIDAR DESCRIPCIÓN DEL TRABAJO (MEJORADA)
                    const descripcion = equipo.querySelector('textarea[name*="[descripcion]"]');
                    if (!descripcion || !descripcion.value.trim()) {
                        equiposConErrores.push(`${equipoNombre}: La descripción del trabajo es obligatoria`);
                    } else if (descripcion.value.trim().length < 10) {
                        equiposConErrores.push(`${equipoNombre}: La descripción debe tener al menos 10 caracteres`);
                    }

                    // ✅ VALIDAR VALOR DEL TRABAJO (MEJORADA)
                    const valorTrabajo = equipo.querySelector('input[name*="[valor_trabajo]"]');
                    if (!valorTrabajo || !valorTrabajo.value || parseFloat(valorTrabajo.value) <= 0) {
                        equiposConErrores.push(`${equipoNombre}: El valor del trabajo debe ser mayor a 0`);
                    }

                    // ✅ VALIDAR REPUESTOS
                    const repuestos = equipo.querySelectorAll('.repuesto-item');
                    if (repuestos.length === 0) {
                        equiposConErrores.push(`${equipoNombre}: Debe agregar al menos un repuesto`);
                    } else {
                        // Validar nombres únicos de repuestos
                        const nombresRepuestos = [];
                        let hayDuplicados = false;

                        repuestos.forEach((repuesto, repuestoIndex) => {
                            const nombreRepuesto = repuesto.querySelector('input[name*="[nombre]"]');
                            const cantidadRepuesto = repuesto.querySelector('input[name*="[cantidad]"]');
                            const precioRepuesto = repuesto.querySelector('input[name*="[precio]"]');

                            const repuestoNum = repuestoIndex + 1;

                            // Validar nombre
                            if (!nombreRepuesto || !nombreRepuesto.value.trim()) {
                                equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: El nombre es obligatorio`);
                            } else if (nombreRepuesto.value.trim().length < 3) {
                                equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: El nombre debe tener al menos 3 caracteres`);
                            } else {
                                const nombreLower = nombreRepuesto.value.trim().toLowerCase();
                                if (nombresRepuestos.includes(nombreLower)) {
                                    hayDuplicados = true;
                                }
                                nombresRepuestos.push(nombreLower);
                            }

                            // Validar cantidad
                            if (!cantidadRepuesto || !cantidadRepuesto.value || parseInt(cantidadRepuesto.value) <= 0) {
                                equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: La cantidad debe ser mayor a 0`);
                            } else if (parseInt(cantidadRepuesto.value) > 9999) {
                                equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: La cantidad no puede ser mayor a 9999`);
                            }

                            // Validar precio
                            if (!precioRepuesto || !precioRepuesto.value || parseFloat(precioRepuesto.value) <= 0) {
                                equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: El precio debe ser mayor a 0`);
                            } else if (parseFloat(precioRepuesto.value) < 0.01) {
                                equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: El precio mínimo es 0.01 Bs`);
                            } else if (parseFloat(precioRepuesto.value) > 999999.99) {
                                equiposConErrores.push(`${equipoNombre} - Repuesto ${repuestoNum}: El precio no puede ser mayor a 999,999.99 Bs`);
                            }
                        });

                        if (hayDuplicados) {
                            equiposConErrores.push(`${equipoNombre}: No puede tener repuestos con nombres duplicados`);
                        }
                    }
                });

                // ✅ MOSTRAR ERRORES (SIN OPCIÓN DE CONTINUAR SIN FOTOS)
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
                    // ✅ TODO CORRECTO, CONFIRMAR GUARDADO
                    Swal.fire({
                        icon: 'question',
                        title: '¿Guardar cotización?',
                        text: 'Se guardará la cotización con todos los datos ingresados.',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Guardando...',
                                text: 'Por favor espere mientras se procesa la cotización.',
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading()
                            });
                            form.submit();
                        }
                    });
                }
            });

            function validarCampos(equiposConErrores) {
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
                        title: '¿Guardar cotización?',
                        text: 'Se guardará la cotización con todos los datos ingresados.',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Guardando...',
                                text: 'Por favor espere mientras se procesa la cotización.',
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading()
                            });
                            form.submit();
                        }
                    });
                }
            }

            // ✅ VALIDACIÓN EN TIEMPO REAL PARA REPUESTOS
            document.addEventListener('input', function (e) {
                // Validar nombre del repuesto
                if (e.target.matches('input[name*="[nombre]"]')) {
                    const input = e.target;
                    const value = input.value.trim();

                    if (value.length === 0) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (value.length < 3) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (value.length > 100) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                }

                // Validar cantidad
                if (e.target.matches('input[name*="[cantidad]"]')) {
                    const input = e.target;
                    const value = parseInt(input.value);

                    if (isNaN(value) || value <= 0) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (value > 9999) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                }

                // Validar precio
                if (e.target.matches('input[name*="[precio]"]')) {
                    const input = e.target;
                    const value = parseFloat(input.value);

                    if (isNaN(value) || value <= 0) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (value < 0.01) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (value > 999999.99) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                }

                // Validar descripción y valor del trabajo
                if (e.target.matches('textarea[name*="[descripcion]"]')) {
                    const input = e.target;
                    if (input.value.trim().length === 0) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                }

                if (e.target.matches('input[name*="[valor_trabajo]"]')) {
                    const input = e.target;
                    const value = parseFloat(input.value);
                    if (isNaN(value) || value <= 0) {
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                }
            });
        });
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
    </script>
@endsection
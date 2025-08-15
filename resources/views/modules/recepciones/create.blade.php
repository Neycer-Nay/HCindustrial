@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Recepcion de equipos</h1>
                <div class="section-header-breadcrumb">

                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('recepciones.store') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="fas fa-user-tag"></i> Datos del Cliente</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Seleccionar
                                                Cliente
                                                Existente</strong>
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" id="cliente_id" name="cliente_id"
                                                required>
                                                <option value="">Seleccione un cliente...</option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}" @if(request('cliente_id') == $cliente->id)
                                                    selected @endif data-nombre="{{ $cliente->nombre }}"
                                                        data-documento="{{ $cliente->tipo_documento }}: {{ $cliente->numero_documento }}"
                                                        data-telefono="{{ $cliente->telefono_1 }}  {{ $cliente->telefono_2 ? '  - ' . $cliente->telefono_2 : '' }}  {{ $cliente->telefono_3 ? '  - ' . $cliente->telefono_3 : '' }}"
                                                        data-email="{{ $cliente->email ?? '-' }}"
                                                        data-direccion="{{ $cliente->ciudad }} @if($cliente->direccion), {{ $cliente->direccion }} @endif">
                                                        {{ $cliente->nombre }} || {{ $cliente->numero_documento }} ||
                                                        {{ $cliente->telefono_1 }}
                                                    </option>
                                                @endforeach
                                                <!-- Opciones se llenarán dinámicamente -->
                                            </select>
                                            <div class="invalid-feedback">Por favor seleccione un cliente</div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                                data-target="#nuevoClienteModal">
                                                <i class="fas fa-plus"></i> Registar cliente
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Información del cliente seleccionado (oculto inicialmente) -->
                                    <div class="row mt-3 d-none" id="clienteInfo">
                                        <div class="col-12 col-md-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="mr-3">
                                                    <i class="fas fa-user text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Nombre</small>
                                                    <span id="clienteNombre" class="font-weight-bold">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="mr-3">
                                                    <i class="far fa-id-card text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Documento</small>
                                                    <span id="clienteDocumento" class="font-weight-bold">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="mr-3">
                                                    <i class="fas fa-phone text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Teléfonos</small>
                                                    <span id="clienteTelefono" class="font-weight-bold">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="mr-3">
                                                    <i class="fas fa-envelope text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Email</small>
                                                    <span id="clienteEmail" class="font-weight-bold">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="mr-3">
                                                    <i class="fas fa-map-marker-alt text-primary"
                                                        style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Dirección</small>
                                                    <span id="clienteDireccion" class="font-weight-bold">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="fas fa-clipboard-list"></i> Datos de la Recepción</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-2"><strong>N°
                                                Recepción
                                            </strong><span class="text-danger">*</span></label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" id="numero_recepcion"
                                                name="numero_recepcion" value="{{ $numeroRecepcion ?? '' }}" required
                                                readonly>
                                            <div class="invalid-feedback">Ingrese el número de recepción</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-2"><strong>Fecha
                                            </strong><span class="text-danger">*</span></label>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"
                                                value="{{ date('Y-m-d') }}" required>
                                            <div class="invalid-feedback">Seleccione la fecha</div>
                                        </div>

                                        <label class="col-form-label text-md-right col-12 col-md-2 col-lg-1"><strong>Hora
                                            </strong><span class="text-danger">*</span></label>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso"
                                                value="{{ date('H:i') }}" required>
                                            <div class="invalid-feedback">Ingrese la hora</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-2"><strong>Encargado
                                            </strong><span class="text-danger">*</span></label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" value="{{ Auth::user()->nombre }}"
                                                readonly>
                                            <input type="hidden" name="encargado_id" value="{{ Auth::user()->id }}">
                                            <div class="invalid-feedback">El encargado es requerido</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-2"><strong>Observaciones</strong></label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" id="observaciones" name="observaciones"
                                                rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @include('modules.equipos.formulario_equipo')
                            <div class="d-flex justify-content-center mt-4 ">
                                <a href="{{ route('recepciones.index') }}" class="btn btn-outline-secondary mr-2">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary px-2">
                                    <i class="fas fa-save"></i>Guardar Recepción
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Modal Nuevo Cliente -->
    <div class="modal fade" tabindex="-1" role="dialog" id="nuevoClienteModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> Registrar Nuevo Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formNuevoCliente" method="POST" action="{{ route('clientes.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Nombre/Razón Social
                                </strong><span class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" value="{{ old('nombre') }}" name="nombre" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Tipo</strong> <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-9">
                                <select class="form-control" name="tipo" required>
                                    <option value="">-- Seleccione --</option>
                                    <option value="PERSONA" {{ old('tipo') == 'PERSONA' ? 'selected' : '' }}>Persona</option>
                                    <option value="EMPRESA" {{ old('tipo') == 'EMPRESA' ? 'selected' : '' }}>Empresa</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Tipo Documento
                                </strong><span class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-9">
                                <select class="form-control" name="tipo_documento" required>
                                    <option value="">-- Seleccione --</option>
                                    <option value="CI" {{old('tipo_documento') == 'CI' ? 'selected' : ''}}>Carnet de Identidad
                                    </option>
                                    <option value="NIT" {{old('tipo_documento') == 'NIT' ? 'selected' : ''}}>NIT</option>
                                    <option value="PASAPORTE" {{old('tipo_documento') == 'PASAPORTE' ? 'selected' : ''}}>
                                        Pasaporte</option>
                                    <option value="OTRO" {{old('tipo_documento') == 'OTRO' ? 'selected' : ''}}>Otro</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Número
                                    Documento</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="number" class="form-control @error('numero_documento') is-invalid @enderror"
                                    value="{{ old('numero_documento') }}" name="numero_documento" required>
                                @error('numero_documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Teléfono
                                    Principal</strong> <span class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="number" class="form-control" value="{{ old('telefono_1') }}" name="telefono_1"
                                    required>

                            </div>
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Teléfono Secundario
                                </strong><span class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="number" class="form-control" value="{{ old('telefono_2') }}" name="telefono_2">

                            </div>
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Teléfono Terciario
                                </strong><span class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="number" class="form-control" value="{{ old('telefono_3') }}" name="telefono_3">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Email</strong></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="email" class="form-control" value="{{ old('email') }}" name="email">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Ciudad</strong></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" name="ciudad" value="Santa Cruz">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><strong>Dirección</strong></label>
                            <div class="col-sm-12 col-md-9">
                                <textarea name="direccion"
                                    class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectCliente = document.getElementById('cliente_id');
            const clienteInfo = document.getElementById('clienteInfo');

            // Función para mostrar datos del cliente seleccionado
            function mostrarInfoCliente() {
                if (selectCliente.value === '') {
                    clienteInfo.classList.add('d-none');
                    return;
                }

                const selectedOption = selectCliente.options[selectCliente.selectedIndex];

                // Actualiza los campos
                document.getElementById('clienteNombre').textContent = selectedOption.dataset.nombre || '-';
                document.getElementById('clienteDocumento').textContent = selectedOption.dataset.documento || '-';
                document.getElementById('clienteTelefono').textContent = selectedOption.dataset.telefono || '-';
                document.getElementById('clienteEmail').textContent = selectedOption.dataset.email || '-';
                document.getElementById('clienteDireccion').textContent = selectedOption.dataset.direccion || '-';

                clienteInfo.classList.remove('d-none');
            }

            // Evento change
            selectCliente.addEventListener('change', mostrarInfoCliente);

            // Mostrar info si ya hay un cliente seleccionado al cargar la página
            if (selectCliente.value !== '') {
                mostrarInfoCliente();
            }
        });
    </script>


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Cliente registrado',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Solo abre el modal si hay errores específicos del formulario de cliente
                const hasClienteErrors = @json($errors->has('nombre') || $errors->has('tipo_documento') /* etc... */);

                if (hasClienteErrors) {
                    $('#nuevoClienteModal').modal('show');
                } else {
                    // Muestra errores generales del formulario de recepción
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el formulario',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                    });
                }
            });
        </script>
    @endif


@endsection
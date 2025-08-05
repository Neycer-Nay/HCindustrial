@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Recepciones</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('recepciones.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Recepción
                    </a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="font-size:21px">Lista de recepciones</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <label style="color:#151414; font-size: 17px;" for="">Buscar recepciones por N° de
                                        recepcion, usuario o cliente</label>
                                    <form method="GET" action="{{ route('recepciones.index') }}" class="form-inline mb-3">
                                        <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar "
                                            value="{{ request('buscar') }}">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                            Buscar</button>
                                        @if(request('buscar'))
                                            <a href="{{ route('recepciones.index') }}"
                                                class="btn btn-secondary ml-2">Limpiar</a>
                                        @endif
                                    </form>
                                    <!-- Tabla para pantallas medianas y grandes -->
                                    <div class="d-none d-md-block">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>N° Recepción</th>
                                                    <th>Fecha y hora</th>
                                                    <th>Cliente</th>
                                                    <th>Usuario</th>
                                                    <!--<th>Estado</th>-->
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recepciones as $recepcion)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $recepcion->numero_recepcion }}</td>
                                                        <td>{{ $recepcion->fecha_ingreso->format('d/m/Y') }} -
                                                            {{ \Carbon\Carbon::parse($recepcion->hora_ingreso)->format('H:i') }}
                                                        </td>
                                                        <td>{{ $recepcion->cliente->nombre ?? 'N/A' }}</td>
                                                        <td>{{ $recepcion->usuario->nombre ?? 'N/A' }}</td>
                                                        <!--<td>
                                                                                            <span
                                                                                                class="badge badge-{{  $recepcion->estado == ($recepcion->estado == 'EN_REPARACION' ? 'warning' : ($recepcion->estado == 'REPARADO' ? 'success' : 'secondary')) }}">
                                                                                                {{ str_replace('_', ' ', $recepcion->estado) }}
                                                                                            </span>
                                                                                        </td>-->
                                                        <td>
                                                            <a href="{{ route('recepciones.show', $recepcion->id) }}"
                                                                class="btn btn-info btn-sm" title="Ver">
                                                                <i class="fas fa-eye"></i> Ver
                                                            </a>
                                                            <a href="{{ route('recepciones.edit', $recepcion->id) }}"
                                                                class="btn btn-warning btn-sm" title="Editar">
                                                                <i class="fas fa-pencil-alt"></i> Editar
                                                            </a>


                                                            @if($recepcion->cotizacion)
                                                                <a href="{{ route('cotizaciones.show', $recepcion->id) }}"
                                                                    class="btn btn-success btn-sm" title="Ver Cotización">
                                                                    <i class="fas fa-file-invoice-dollar"></i> Ver Cotización
                                                                </a>
                                                            @else
                                                                <a href="{{ route('cotizaciones.createFromRecepcion', $recepcion->id) }}"
                                                                    class="btn btn-warning btn-sm" title="Crear Cotización">
                                                                    <i class="fas fa-plus"></i> Cotizar
                                                                </a>
                                                            @endif
                                                            <!-- Por el momento ocultare el boton de eliminar recepcion
                                                                    <form action="{{ route('recepciones.destroy', $recepcion->id) }}"
                                                                        method="POST" style="display: inline-block;"
                                                                        class="form-eliminar-recepcion">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                            title="Eliminar">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form> -->
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center">
                                            {{ $recepciones->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>

                                    <!-- Tarjetas para pantallas pequeñas -->
                                    <div class="d-block d-md-none">
                                        @foreach($recepciones as $recepcion)
                                            <div class="card mb-2">
                                                <div class="card-body p-2">
                                                    <h5 class="card-title mb-1">N° Recepción: {{ $recepcion->numero_recepcion }}
                                                    </h5>

                                                    <p class="mb-1"><strong>Fecha y hora:</strong>
                                                        {{ $recepcion->fecha_ingreso->format('d/m/Y') }} -
                                                        {{ \Carbon\Carbon::parse($recepcion->hora_ingreso)->format('H:i') }}
                                                    </p>
                                                    <p class="mb-1"><strong>Cliente:</strong>
                                                        {{ $recepcion->cliente->nombre ?? 'N/A' }}</p>
                                                    <p class="mb-1"><strong>Usuario:</strong>
                                                        {{ $recepcion->usuario->nombre ?? 'N/A' }}</p>
                                                    <!--<p class="mb-1"><strong>Estado:</strong>
                                                                                        <span
                                                                                            class="badge badge-{{  $recepcion->estado == ($recepcion->estado == 'EN_REPARACION' ? 'warning' : ($recepcion->estado == 'REPARADO' ? 'success' : 'secondary')) }}">
                                                                                            {{ str_replace('_', ' ', $recepcion->estado) }}
                                                                                        </span>
                                                                                    </p>-->
                                                    <div>
                                                        <a href="{{ route('recepciones.show', $recepcion->id) }}"
                                                            class="btn btn-info btn-sm" title="Ver">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </a>
                                                        <a href="{{ route('recepciones.edit', $recepcion->id) }}"
                                                            class="btn btn-warning btn-sm" title="Editar">
                                                            <i class="fas fa-pencil-alt"></i> Editar
                                                        </a>


                                                        @if($recepcion->cotizacion)
                                                            <a href="{{ route('cotizaciones.show', $recepcion->id) }}"
                                                                class="btn btn-success btn-sm" title="Ver Cotización">
                                                                <i class="fas fa-file-invoice-dollar"></i> Ver
                                                            </a>
                                                        @else
                                                            <a href="{{ route('cotizaciones.createFromRecepcion', $recepcion->id) }}"
                                                                class="btn btn-warning btn-sm" title="Crear Cotización">
                                                                <i class="fas fa-plus"></i> Cotizar
                                                            </a>
                                                        @endif

                                                        <!-- Por el momento ocultare el boton de eliminar recepcion
                                                                <form action="{{ route('recepciones.destroy', $recepcion->id) }}"
                                                                    method="POST" style="display: inline-block;"
                                                                    class="form-eliminar-recepcion ">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        title="Eliminar">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>-->
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="d-flex justify-content-center">
                                            {{ $recepciones->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')

<!-- SweetAlert para mensajes de sesión -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Recepción registrada',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    timer: 3000
                });
            });
        </script>
    @endif

    <!-- Confirmación SweetAlert para eliminar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.form-eliminar-recepcion').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará la recepción y todos sus datos relacionados.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    

    
    @if(session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: '{{ session('swal.icon') }}',
                    title: '{{ session('swal.title') }}',
                    text: '{{ session('swal.text') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if($recepciones->isEmpty() && request('buscar'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin resultados',
                    text: 'No se encontraron recepciones que coincidan con la búsqueda.',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endpush
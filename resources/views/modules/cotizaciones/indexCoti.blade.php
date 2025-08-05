@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Cotizaciones</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 style="font-size:21px">Lista de cotizaciones</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <label style="color:#151414; font-size: 17px;" for="">Buscar cotizaciones por N° de
                                        cotización, recepción o cliente</label>
                                    <form method="GET" action="{{ route('cotizaciones.index') }}" class="form-inline mb-3">
                                        <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar"
                                            value="{{ request('buscar') }}">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                            Buscar</button>
                                        @if(request('buscar'))
                                            <a href="{{ route('cotizaciones.index') }}"
                                                class="btn btn-secondary ml-2">Limpiar</a>
                                        @endif
                                    </form>

                                    <!-- Tabla para pantallas medianas y grandes -->
                                    <div class="d-none d-md-block">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th></th>                                                
                                                    <th>N° Cotización</th>
                                                    <th>Fecha y hora</th>
                                                    <th>Cliente</th>
                                                    <th>Subtotal</th>
                                                    <th>Descuento</th>
                                                    <th>Total</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cotizaciones as $cotizacion)
                                                    <tr>  
                                                        <td>{{ $loop->iteration }}</td>                                                      
                                                        <td>{{ $cotizacion->recepcion->numero_recepcion }}</td>
                                                        <td>{{ $cotizacion->created_at->format('d/m/Y - H:i') }}</td>
                                                        <td>{{ $cotizacion->recepcion->cliente->nombre ?? 'N/A' }}</td>
                                                        <td>{{ number_format($cotizacion->subtotal, 2) }}Bs</td>
                                                        <td>{{ number_format($cotizacion->descuento, 2) }}Bs</td>
                                                        <td>{{ number_format($cotizacion->total, 2) }}Bs</td>
                                                        <td>
                                                            <a href="{{ route('cotizaciones.show', $cotizacion->recepcion->id) }}"
                                                                class="btn btn-info btn-sm" title="Ver">
                                                                <i class="fas fa-eye"></i> Ver
                                                            </a>
                                                            
                                                            <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}"
                                                                class="btn btn-warning btn-sm" title="Editar">
                                                                <i class="fas fa-edit"></i> Editar
                                                            </a>
                                                            
                                                            <a href="{{ route('cotizaciones.pdf', $cotizacion->recepcion->id) }}" class="btn btn-danger btn-sm" target="_blank">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </a>
                                                            <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" class="d-inline form-eliminar-cotizacion">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                                    <i class="fas fa-trash"></i> Eliminar
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center">
                                            {{ $cotizaciones->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>

                                    <!-- Tarjetas para pantallas pequeñas -->
                                    <div class="d-block d-md-none">
                                        @foreach($cotizaciones as $cotizacion)
                                            <div class="card mb-2">
                                                <div class="card-body p-2">
                                                    <h5 class="card-title mb-1"><strong>Cotización N°:</strong>
                                                        {{ $cotizacion->recepcion->numero_recepcion }}</h5>
                                                    <p class="mb-1"></p>
                                                    <p class="mb-1"><strong>Fecha:</strong> {{ $cotizacion->fecha}}</p>
                                                    <p class="mb-1"><strong>Cliente:</strong>
                                                        {{ $cotizacion->recepcion->cliente->nombre ?? 'N/A' }}</p>
                                                    <p class="mb-1"><strong>Subtotal:</strong>
                                                        {{ number_format($cotizacion->subtotal, 2) }}Bs</p>
                                                    <p class="mb-1"><strong>Descuento:</strong>
                                                        {{ number_format($cotizacion->descuento, 2) }}Bs</p>
                                                    <p class="mb-1"><strong>Total:</strong>
                                                        {{ number_format($cotizacion->total, 2) }}Bs</p>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <a href="{{ route('cotizaciones.show', $cotizacion->recepcion->id) }}"
                                                            class="btn btn-info btn-sm" title="Ver">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </a>
                                                        
                                                        <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}"
                                                            class="btn btn-warning btn-sm" title="Editar">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        
                                                        <a href="{{ route('cotizaciones.pdf', $cotizacion->recepcion->id) }}" class="btn btn-danger btn-sm" target="_blank">
                                                            <i class="fas fa-file-pdf"></i> PDF
                                                        </a>
                                                        <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" class="d-inline form-eliminar-cotizacion">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" ">
                                                                <i class="fas fa-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="d-flex justify-content-center">
                                            {{ $cotizaciones->links('pagination::bootstrap-4') }}
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

<!-- Confirmación SweetAlert para eliminar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.form-eliminar-cotizacion').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará la cotización y todos sus datos relacionados.",
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
                    position: 'center',
                    icon: '{{ session('swal.icon') }}',
                    title: '{{ session('swal.title') }}',
                    text: '{{ session('swal.text') }}',
                    showConfirmButton: true,
                    timer: 3000
                });
            });
        </script>
    @endif

@endpush
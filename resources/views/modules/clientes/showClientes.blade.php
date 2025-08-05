@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414" >Clientes</h1>
                <div class="section-header-breadcrumb">
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="font-size:21px">Lista de clientes</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <label style="color:#151414; font-size: 17px;" for="">Buscar clientes por nombre, teléfonos o número de documento</label>
                                    <form method="GET" action="{{ route('clientes.index') }}" class="form-inline mb-3">
                                        <input type="text" name="buscar" class="form-control mr-2"
                                            placeholder="Buscar clientes" value="{{ request('buscar') }}">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                            Buscar</button>
                                        @if(request('buscar'))
                                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary ml-2">Limpiar</a>
                                        @endif
                                    </form>
                                    <!-- Tabla para pantallas medianas y grandes -->
                                    <div class="d-none d-md-block">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th></th>     
                                                    <th>Nombre</th> 
                                                    <th>N° Documento</th>
                                                    <th>Teléfonos</th>
                                                    <th>Correo</th>
                                                    <th>Dirección</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($clientes as $cliente)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>

                                                        <td>{{ $cliente->nombre }} - <strong>{{ Str::title($cliente->tipo) }}</strong></td>

                                                        <td>{{ $cliente->tipo_documento}}-{{ $cliente->numero_documento }}</td>
                                                        <td>{{ $cliente->telefono_1 }}{{ $cliente->telefono_2 ? ' - ' . $cliente->telefono_2 : '' }}{{ $cliente->telefono_3 ? ' - ' . $cliente->telefono_3 : '' }}
                                                        </td>
                                                        <td>{{ $cliente->email }}</td>
                                                        <td>{{ $cliente->ciudad }}-{{ $cliente->direccion }}</td>
                                                        <td>
                                                            <a href="{{ route('clientes.show', $cliente->id) }}"
                                                                class="btn btn-info btn-sm" title="Ver">
                                                                <i class="fas fa-eye"></i> Ver
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center">
                                            {{ $clientes->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>

                                    <!-- Tarjetas para pantallas pequeñas -->
                                    <div class="d-block d-md-none">
                                        @foreach($clientes as $cliente)
                                            <div class="card mb-2">
                                                <div class="card-body p-2">
                                                    <h5 class="card-title mb-1">{{ $cliente->nombre }}</h5>
                                                    <p class="mb-1"><strong>Tipo:</strong> {{ $cliente->tipo }}</p>
                                                    <p class="mb-1"><strong>N° Documento:</strong>
                                                        {{ $cliente->tipo_documento}}-{{ $cliente->numero_documento }}</p>
                                                    <p class="mb-1"><strong>Teléfonos:</strong>
                                                        {{ $cliente->telefono_1 }}{{ $cliente->telefono_2 ? ' - ' . $cliente->telefono_2 : '' }}{{ $cliente->telefono_3 ? ' - ' . $cliente->telefono_3 : '' }}
                                                    </p>
                                                    <p class="mb-1"><strong>Correo:</strong> {{ $cliente->email }}</p>
                                                    <p class="mb-1"><strong>Dirección:</strong>
                                                        {{ $cliente->ciudad }}-{{ $cliente->direccion }}</p>
                                                    <div>
                                                        <a href="{{ route('clientes.show', $cliente->id) }}"
                                                            class="btn btn-info btn-sm" title="Ver">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="d-flex justify-content-center">
                                            {{ $clientes->links('pagination::bootstrap-4') }}
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
@section('scripts')
    @if($clientes->isEmpty() && request('buscar'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin resultados',
                    text: 'No se encontraron clientes que coincidan con la búsqueda.',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

@endsection
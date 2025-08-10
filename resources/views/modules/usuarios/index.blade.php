@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Usuarios</h1>
                <div class="section-header-breadcrumb">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usuarioModal">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </button>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="font-size:21px">Lista de usuarios</h4>
                            </div>
                            <!-- Tabla para pantallas medianas y grandes -->
                            <div class="card-body">
                                <div class="table-responsive"></div>
                                <div class="d-none d-md-block">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nombre</th>
                                                <th>Correo</th>
                                                <th>Rol</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->nombre }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->rol }}</td>
                                                    <td>
                                                        <a href="{{ route('usuarios.edit', $user->id) }}"
                                                            class="btn btn-warning btn-sm" title="Editar"><i
                                                                class="fas fa-edit"></i> Editar</a>
                                                        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm delete-btn"
                                                                data-name="{{ $user->nombre ?? 'usuario' }}"><i
                                                                    class="fas fa-trash"></i>
                                                                Eliminar</button>
                                                        </form>
                                                        @if(auth()->user()->rol === 'Gerente' && $user->rol !== 'Gerente')
                                                            <form action="{{ route('usuarios.toggle', $user->id) }}" method="POST"
                                                                style="display:inline-block;">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="btn btn-{{ $user->activo ? 'secondary' : 'success' }} btn-sm"
                                                                    title="{{ $user->activo ? 'Desactivar' : 'Activar' }}">
                                                                    <i class="fas fa-toggle-{{ $user->activo ? 'on' : 'off' }}"></i>
                                                                    {{ $user->activo ? 'Desactivar' : 'Activar' }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    </div>

    <!-- Tarjetas para pantallas pequeñas -->
    <div class="d-block d-md-none">
        @foreach($users as $user)
            <div class="card mb-2">
                <div class="card-body p-2">
                    <h5 class="card-title mb-1">{{ $user->nombre }}</h5>
                    <p class="mb-1"><strong>Correo:</strong> {{ $user->email }}</p>
                    <p class="mb-1"><strong>Rol:</strong> {{ $user->rol }}</p>
                    <div>
                        <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Editar"><i
                                class="fas fa-edit"></i> Editar</a>
                        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn"
                                data-name="{{ $user->nombre ?? 'usuario' }}"><i class="fas fa-trash"></i> Eliminar</button>
                        </form>
                        @if(auth()->user()->rol === 'Gerente' && $user->rol !== 'Gerente')
                            <form action="{{ route('usuarios.toggle', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $user->activo ? 'secondary' : 'success' }} btn-sm"
                                    title="{{ $user->activo ? 'Desactivar' : 'Activar' }}">
                                    <i class="fas fa-toggle-{{ $user->activo ? 'on' : 'off' }}"></i>
                                    {{ $user->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>

    </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usuarioModalLabel">Registrar Nuevo Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="usuarioForm" action="{{ route('usuarios.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                required value="{{ old('nombre') }}">
                            @error('nombre')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                required value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select class="form-control w-100 @error('rol') is-invalid @enderror" id="rol" name="rol"
                                required>
                                <option value="Gerente" {{ old('rol') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                                <option value="Contabilidad" {{ old('rol') == 'Contabilidad' ? 'selected' : '' }}>Contabilidad
                                </option>
                                <option value="Supervisor" {{ old('rol') == 'Supervisor' || !old('rol') ? 'selected' : '' }}>
                                    Supervisor</option>
                            </select>
                            @error('rol')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="usuarioForm" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mostrar alertas de sesión (éxito/error)
            @if(session('swal'))
                Swal.fire({
                    icon: '{{ session('swal')['icon'] }}',
                    title: '{{ session('swal')['title'] }}',
                    text: '{{ session('swal')['text'] }}',
                    confirmButtonColor: '#3085d6',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: true
                });
            @endif

            // Confirmación para eliminar usuarios
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const userName = this.getAttribute('data-name');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `Vas a eliminar a ${userName}. Esta acción no se puede deshacer.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Abrir modal si hay errores
            @if($errors->any())
                $('#usuarioModal').modal('show');
                $('.is-invalid').first().focus();
            @endif
                                });
    </script>

    @if($users->isEmpty() && request('buscar'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin resultados',
                    text: 'No se encontraron usuarios que coincidan con la búsqueda.',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endsection
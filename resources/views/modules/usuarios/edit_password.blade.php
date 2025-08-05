
@extends('layouts.main')

@section('contenido')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 style="color:#151414">Actualizar Contraseña</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h4>Usuario: {{ $user->nombre }}</h4></div>
                        <div class="card-body">
                            <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                                <div class="form-group text-right">
                                    <a href="{{ route('usuarios.index') }}"  class="btn btn-outline-secondary mr-2">
                                         Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Contraseña
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
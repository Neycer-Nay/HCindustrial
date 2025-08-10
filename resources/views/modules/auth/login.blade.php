@extends('layouts.login')
@section('contenido')

  <section class="section">
    <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
      <div class="login-brand">
        <!--<h2>HC BOBINADOS INDUSTRIALES</h2>--> 
        <img src="{{ asset('dist/assets/img/logo.png') }}" alt="logo" width="300" >
      </div>
      <div class="card card-secondary">
        <div class="card-header">
        <h4>Inicio de sesión</h4>
        </div>
        <div class="card-body">
        <form method="POST" action="{{ route('logear') }}" s class="needs-validation" novalidate="">
          @csrf
          <div class="form-group">
          <label for="email">Correo</label>
          <input id="email" type="email" class="form-control" name="email" tabindex="1"
            placeholder="Por favor coloque su correo" required autofocus>
          <div class="invalid-feedback">
            Porfavor coloca tu email
          </div>
          </div>
          <div class="form-group">
          <div class="d-block">
            <label for="password" class="control-label">Contraseña
          </div>
          <input id="password" type="password" class="form-control" name="password" tabindex="2"
            placeholder="Por favor coloque su contraseña" required>
          <div class="invalid-feedback">
            Por favor coloca tu contraseña
          </div>
          </div>
          <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Ingresar
          </button>
          </div>
        </form>
        <div>
          @if ($errors->any())
        <div class="alert alert-danger mt-2">
        <ul>
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
      @endif
        </div>
        </div>
      </div>
      <div class="simple-footer">
        Copyright &copy; Design By Software Production
      </div>
      </div>
    </div>
    </div>
  </section>

@endsection
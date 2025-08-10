<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route("dashboard.index") }}"><img src="{{ asset('dist/assets/img/logo.png') }}" alt="logo"
                    width="70" ></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route("dashboard.index") }}"><img src="{{ asset('dist/assets/img/logo.png') }}" alt="logo"
                    width="50" ></a>
        </div>
        <ul class="sidebar-menu">

            <li class="dropdown ">
                <a href="{{ route("dashboard.index") }}" class="nav-link "><i
                        class="fas fa-tachometer-alt"></i><span>Inicio</span></a>

            </li>

            <li class="dropdown">
                <a href="{{ route('recepciones.index') }}" class="nav-link "><i class="fas fa-cogs"></i>
                    <span>Equipos recibidos</span></a>

            </li>
            <li class="dropdown">
                <a href="{{ route('cotizaciones.index') }}" class="nav-link "><i class="fas fa-file-invoice"></i>
                    <span>Cotizaciones</span></a>

            </li>
            <li><a class="nav-link" href="{{ route('recepciones.create') }}"><i class="fas fa-file-signature"></i>
                    <span>
                        Registrar equipos
                    </span></a></li>

            <li class="dropdown">
                <a href="{{ route('clientes.index') }}" class="nav-link "><i class="fas fa-users"></i>
                    <span>Clientes</span></a>
            </li>
            @auth
                @if(auth()->user()->rol === 'Gerente')
                    <li class="dropdown">
                        <a href="{{ route('usuarios.index') }}" class="nav-link "><i class="far fa-user"></i>
                            <span>Usuarios</span></a>

                    </li>
                @endif
            @endauth
            {{-- Solo Gerente y Contabilidad pueden ver el menú contable --}}
            @auth
                @if(auth()->user()->rol === 'Gerente' || auth()->user()->rol === 'Contabilidad')
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="fas fa-calculator"></i> <span>Contabilidad</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!--<li><a class="nav-link" href="#"><i class="fas fa-file-invoice-dollar"></i> Recibos</a></li>-->
                            <li><a class="nav-link" href="{{ route('ingresos.index') }}"><i class="fas fa-arrow-down"></i>
                                    Ingresos</a></li>
                            <li><a class="nav-link" href="{{ route('egresos.index') }}"><i class="fas fa-arrow-up"></i>
                                    Egresos</a></li>
                            <li><a class="nav-link" href="{{ route('libro-diario.index') }}"><i class="fas fa-book"></i> Libro
                                    Diario</a></li>
                            <!--<li><a class="nav-link" href="#"><i class="fas fa-chart-line"></i> Reportes</a></li>-->
                            <li><a class="nav-link" href="{{ route('sueldos.index') }}"><i class="fas fa-money-check-alt"></i> Sueldos</a></li>
                        </ul>
                    </li>
                @endif
            @endauth
        </ul>


    </aside>
</div>
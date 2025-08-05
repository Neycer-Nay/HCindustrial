
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg "></a>

        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('dist/assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{Auth::user()->nombre}}</div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                
                
                <a  class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ Auth::user()->nombre }}
                </a>
                
                <a  class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> {{ Auth::user()->rol }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ asset('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </li>
    </ul>
</nav>
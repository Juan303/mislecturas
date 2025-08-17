<nav class="nav-class navbar navbar-expand-lg bg-white fixed-top" style="z-index: 500" >
    <div class="container">
        <div class="navbar-translate text-nowrap">
            <a class="navbar-brand pt-0  pb-0" href="{{ route('welcome') }}">
                <div class="d-none d-md-block">
                    <img class="align-bottom" style="width: 80px" src="{{ asset('images/logo_OP.png') }}" alt="logo">
                </div>
                <div class="d-block d-md-none">
                    <img class="align-bottom" style="width: 50px" src="{{ asset('images/logo_OP.png') }}" alt="logo">
                </div>
            </a>
            <h3 class="d-none d-xl-inline-block title m-auto">Lecturas</h3>
            @include('partials.buscadores.buscador_principal_movil')
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                @if(auth()->user())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-scroll href="{{ route('usuario.colecciones.index') }}">{{ __('mangas') }}</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item py-1" href="{{ route('usuario.colecciones.index') }}">{{ __('Mi Colección') }}</a>
                            <a class="dropdown-item py-1" href="{{ route('usuario.colecciones.prevision-compras') }}">{{ __('Proximos lanzamientos') }}</a>
                            <!-- Separacion -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-1" href="{{route('coleccion.listadoColecciones')}}">{{ __('Colecciones') }}</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll href="{{ route('usuario.libros.index') }}">{{ __('libros') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll href="{{ route('usuario.buscados.index') }}">{{ __('Buscados') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll href="{{ route('usuario.prestamos.index') }}">{{ __('Préstamos') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-scroll href="{{ route('usuario.lectura.index') }}">{{ __('Zona de lectura') }}</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item py-1" href="{{ route('usuario.lectura.index', ['estado' => 'leyendo']) }}">{{ __('Leyendo') }}</a>
                            <a class="dropdown-item py-1" href="{{ route('usuario.lectura.index', ['estado' => 'leidos']) }}">{{ __('Leídos') }}</a>
                            <a class="dropdown-item py-1" href="{{ route('usuario.lectura.index', ['estado' => 'quiero-leer']) }}">{{ __('Quiero leer') }}</a>
                            <!-- Separacion -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-1" href="{{ route('usuario.lectura.retos') }}">{{ __('Retos') }}</a>
                            <a class="dropdown-item py-1" href="{{ route('usuario.resumen.index') }}">{{ __('Resumen') }}</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll href="{{ route('usuario.estadisticas') }}">{{ __('Estadisticas') }}</a>
                    </li>
                @endif
                @include('partials.navigations.users')
            </ul>
        </div>
    </div>
</nav>

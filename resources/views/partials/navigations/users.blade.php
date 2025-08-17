@if(auth()->user())
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-scroll href="{{ route('usuario.lectura.index') }}">{{ auth()->user()->email }}</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item py-1"  href="{{ route('home') }}">
                <i class="fas fa-home"></i>&nbsp;{{ __('Home') }}
            </a>
            <hr class="m-0 p-1">
            <a class="dropdown-item py-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>&nbsp;{{ __('Logout')}}
            </a>
            <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </li>
@else
    <a class="nav-link text-success"  href="{{ route('login') }}">
        {{ __('Login') }} <span class="caret"></span>
    </a>
    <a class="nav-link text-success"  href="{{ route('register') }}">
        {{ __('Registro') }} <span class="caret"></span>
    </a>
@endif







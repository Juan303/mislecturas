@extends('layouts.app')

@section('body-class', 'login-page sidebar-collapse')

@section('navigation')
    @include('partials.navigations.navigation_welcome')
@endsection

@section('styles')
    <style>
        html{
            min-height: 100%;
        }
        .wrapper {
            padding-top: 90px;
            padding-bottom: 145px;
        }
        .bmd-form-group {
            padding-top: 42px;
        }
        .form-group input, .form-group select, .form-group textarea{
            background-color: whitesmoke;
        }
        .is-invalid{
            border: 1px solid red;
        }
    </style>
@endsection



@section('content')
    @yield('variables')
    <div class="main main-section pb-5 bg-white">
        <div class="container pt-2">
            <div class="row @movile @else mt-5 @endmovile">
                <div class="col-12">
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link active h6" href="#tab_cuenta" data-toggle="tab">Cuenta</a></li>
                        <li class="nav-item"><a class="nav-link h6" href="#tab_amigos" data-toggle="tab">Amigos</a></li>
                    </ul>
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="tab_cuenta">
                            <h5 class="text-uppercase">Información de la cuenta</h5>
                        </div>
                        <div class="tab-pane" id="tab_amigos">
                            <h5 class="text-uppercase border-bottom">Registro de amigos</h5>
                            <!-- Formulario para añadir amigos -->
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email del amigo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection

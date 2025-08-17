@extends('layouts.app')

@section('styles')
    <style>
        html {
            min-height: 100%;
            position: relative;
        }
        body {
            margin: 0;
        //margin-bottom: 50px;
        }
        footer {
        //background-color: black;
            position: absolute;
            bottom: 0;
            width: 100%;

            color: white;
        }
        .wrapper {
            padding-bottom: 0;
        }
        .login-page .page-header > .container {
            padding-bottom: 120px;
            padding-top:100px;
        }
        .login-page .page-header {
            min-height: 100vh;
            max-height: 1000px;
            height: 100%;
        }
        .page-header{
            align-items: normal;
        }
    </style>
@endsection

@section('content')
    <div class="page-header header-filter" style="background-image: url('{{ asset('images/fondo.png') }}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8 ml-auto mr-auto">
                    <div class="card card-login text-center">
                        <div class="card-body">
                            <h4 class="card-title text-center">{{ __('Verifica tu dirección de correo electrónico') }}</h4>
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('Se ha enviado un nuevo link para la confirmacion del correo electrónico') }}
                                </div>
                            @endif
                            <p>{{ __('Antes de continuar, por favor comprueba tu mail en busca del link de confirmación.') }}</p>
                            <p>{{ __('Si no has recibido el link de confirmación') }}, <a href="{{ route('verification.resend') }}">{{ __('haz click aquí para reenviar otro') }}</a>.</p>
                            <a href="{{ route('logout') }}" class="btn btn-info" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Salir') }}
                            </a>
                            <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

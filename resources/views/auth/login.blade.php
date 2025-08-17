@extends('layouts.app')

@section('body-class', 'login-page sidebar-collapse')

@section('navigation')
    @include('partials.navigations.navigation_welcome')
@endsection

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
    </style>
@endsection

@section('content')
    <div class="page-header header-filter" style="background-image: url('{{ asset('images/fondo.png') }}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                    <div class="card card-login">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title text-center">{{ __('auth.login') }}</h4>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="material-icons">mail</i>
                                        </span>
                                    </div>
                                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('auth.email') }}...">
                                    @if ($errors->has('email'))
                                        <span class="ml-5 invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('auth.contraseña') }}...">
                                </div>
                                <div class="form-check text-center">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="remember" type="checkbox" value="1">
                                        Recordarme
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="footer text-center">
                                <button type="submit" class="btn btn-vzero btn-wd btn-lg mt-4">{{ __('auth.entrar') }}</button>
                                <br/>
                                <a href="{{ route('register') }}" class="btn btn-link text-success">{{ __('auth.crear_cuenta') }}</a>
                                <a href="{{ route('password.request') }}" class="btn btn-link text-success mt-0 pt-0">{{ __('¿Has olvidado tu contraseña?') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

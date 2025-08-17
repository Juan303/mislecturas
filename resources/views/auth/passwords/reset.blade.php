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
                    <div class="card card-login">
                        <form class="form" method="POST" action="{{  route('password.update') }}">
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title text-center">{{ __('Restablecer contraseña') }}</h4>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="material-icons">mail</i>
                                        </span>
                                    </div>
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('auth.email') }}..." autocomplete="email">
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
                                    <input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Nueva contraseña') }}..." required autocomplete="new-password">
                                    @if ($errors->has('password'))
                                        <span class="ml-5 invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="{{ __('Confirmar nueva contraseña') }}..." autocomplete="new-password">
                                </div>
                            </div>
                            <div class="footer text-center">
                                <button type="submit" class="btn btn-vzero btn-wd btn-lg mt-4">{{ __('Restablecer') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

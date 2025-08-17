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

@section('scripts')
    <script>
        /*$(document).ready(function(){
            $('#register-form').submit(function(e){
                //e.preventDefault();
                var privacy = $('#privacy').prop('checked');
                if(privacy){
                    return true;
                }
                $("#privacy-form-check").css('border', '2px solid red');
                return false
            })


        })*/

    </script>
@endsection

@section('content')
    <div class="page-header header-filter" style="background-image: url('{{ asset('images/fondo.png') }}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 ml-auto mr-auto">
                    <div class="card card-login">
                        <form id="register-form" class="form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="card-body px-3 py-2">
                                <h4 class="card-title">{{ __('auth.registro') }}</h4>
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label text-md-right">{{ __('auth.email') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @if ($errors->has('email'))
                                                <span class="ml-5 invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-form-label text-md-right">{{ __('auth.contraseña') }}</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            @if ($errors->has('password'))
                                                <span class="ml-5 invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="password-confirm" class="col-form-label text-md-right">{{ __('auth.repetir_contraseña') }}</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            @if ($errors->has('password_confirmation'))
                                                <span class="ml-5 invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="form-row justify-content-center">
                                    <div class="form-group">
                                        <label class="form-check-label" id="privacy-form-check">
                                            <input required value="privacy_ok" class="form-check-input" type="checkbox" name="privacy" id="privacy"><a href="{{ route('privacy') }}">{{ __('auth.condiciones') }}</a>
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>--}}
                                <div class="form-row justify-content-center text-center">
                                    <div class="form-group mb-0">

                                        <button type="submit" class="btn btn-vzero">

                                            {{ __('auth.registrar') }}
                                        </button>
                                        <br>
                                        <a href="{{ route('login') }}" class="btn btn-link text-success">{{ __('login') }}</a>
                                    </div>
                                </div>
                                <div class="form-row justify-content-center text-center">
                                    {!!  GoogleReCaptchaV3::renderField('contact_us_id','contact_us_action') !!}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

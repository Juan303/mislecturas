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

@endsection

@section('content')
    @yield('variables')
    <div class="page-header header-filter" style="background-image: url('{{ asset('img/bg7.jpg') }}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 ml-auto mr-auto">
                    <div class="card card-login">
                        @yield('formulario-item')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

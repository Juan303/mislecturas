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
            <div class="row">
                @yield('formulario-item')
            </div>
        </div>
    </div>
@endsection


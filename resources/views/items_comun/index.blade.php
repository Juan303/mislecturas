@extends('layouts.app')

@section('body-class', 'sidebar-collapse')

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
@append

@section('scripts')

@append

@section('content')
    @yield('variables')
    <div class="main main-section pb-5 bg-white">
        <div class="container pt-2">
            @yield("zona-items")
        </div>
    </div>
    @yield("modals")
@endsection

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
            padding-top: 120px;
            padding-bottom: 145px;
            background-color: transparent;
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
    <div class="main main-section pb-5">
        <div class="container pt-2">
            @include('partials.buscadores.buscador_principal')
            @if(auth()->check())
                <div class="row @movile @else mt-5 @endmovile">
                    <div class="col-12 col-md-6" id="bloqueUltimasLecturas">
                        <div class="widgetLoaderPanel w-100 py-5" hidden>
                            <div class="widgetLoader m-auto w-25"></div>
                        </div>
                        {{--@include('partials.lecturas.bloque-ultimas-lecturas')--}}
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-12 p-0 pb-3" id="bloqueRetoActual">
                                <div class="widgetLoaderPanel w-100 py-5" hidden>
                                    <div class="widgetLoader m-auto w-25"></div>
                                </div>
                                {{--@include('partials.lecturas.bloque-reto-actual', ['zona' => 'welcome'])--}}
                            </div>
                            <div class="col-12 p-0" id="bloqueDatosInteres">
                                <div class="widgetLoaderPanel w-100 py-5" hidden>
                                    <div class="widgetLoader m-auto w-25"></div>
                                </div>
                                {{--@include('partials.lecturas.bloque-datos-interes')--}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/welcome/welcome.js') }}?v={{ time() }}"></script>
@endsection

@section("modals")
    @include('partials.messages.modal_registro_lectura')
    @include('partials.messages.modal_detalles_item')
@endsection

@extends('layouts.app')

@section('body-class', 'login-page sidebar-collapse')

@section('navigation')
    @include('partials.navigations.navigation')
@endsection

@section('styles')
    <style>
        .wrapper{
            padding-bottom: 80px;
            padding-top: 20px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/smooth-scroll.min.js') }}"></script>
    <script>
        var scroll = new SmoothScroll('a[href*="#"]', {
            speed: 600
        });
        $(document).ready(function () {
            $('#contact-form').submit(function (e) {
                e.preventDefault();
                var url = $(this).attr('action');
                $('.form-error').css('display', 'none');
                $.post(url, $(this).serialize(), function(data){
                    $("#modal_message .alert").attr('class', 'alert alert-success');
                    $('#modal_message .alert').html(data.text);
                    $('#modal_message').modal('show')
                }).fail(function(data){
                    var json = JSON.stringify(data);
                    var json_array = $.parseJSON(json);
                    $.each(json_array.responseJSON.errors, function(key, value){
                        $('#'+key+'_error').css('display', 'block');
                        $('#'+key+'_error').html(value);
                    });
                })
            })
        })
    </script>
    <!-- Script para la validacion de la casilla de la politica de privacidad -->
    <script>
        $(document).ready(function(){
            $('#register-form').submit(function(e){
                //e.preventDefault();
                var privacy = $('#privacy').prop('checked');
                if(privacy){
                    return true;
                }
                $("#privacy-form-check").css('border', '2px solid red');
                return false
            })
        })
    </script>

@endsection

@section('content')
    <div class="page-header header-filter" style="background-image: url('{{ asset('img/bg7.jpg') }}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                @include('partials.forms.contact_form')
                <div class="col-md-4">
                    <div class="card mt-0">
                        <div class="card-body">
                            <p class="title text-dark mb-1 mt-1">VZERO ENGINEERING SOLUTIONS, S.L.</p>
                            <p class="m-1">Calle Primavera, 26</p>
                            <p class="m-1">28850, Torrejón de Ardoz</p>
                            <p class="m-1">Madrid, SPAIN</p>
                            <p class="m-1">+34 667 382 128</p>
                            <p class="m-1"><a href="mailto:info@vzero.eu">info@vzero.eu</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

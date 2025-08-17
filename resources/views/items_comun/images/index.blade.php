
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
    </style>

@endsection

@section('scripts')
    <script src="{{ asset('js/jquery.collapser.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.text-new').collapser({
                mode: 'words',
                truncate: 25,
                ellipsis: '...',
                showText: ''
            });
        })
    </script>
    <script>
        $(document).ready(function () {
            $(".article img").addClass('rounded');
            $(".article img").each(function(){
                if($(this).hasClass('note-float-left')){
                    $(this).addClass('mr-3');
                }
                if($(this).hasClass('note-float-right')){
                    $(this).addClass('ml-3');
                }
            })
        })
    </script>

    <script type="text/javascript">
        Dropzone.autoDiscover = true;
        Dropzone.options.mydropzone = {
            addRemoveLinks: true,
            autoProcessQueue: false,
            dictRemoveFile: "Eliminar",
            uploadMultiple: true,
            parallelUploads: 3,
            maxFilesize: 10,
            maxFiles: null,
            init: function(file) {
                var dropz = this;
                this.on("queuecomplete", function(data) {
                    location.reload()
                });
                $('#procesar_fotos').click(function () {
                    dropz.processQueue();
                })
            }
        }
    </script>

@endsection

@section('content')
    @yield('variables')
    <div class="main main-section pb-5 bg-white">
        <div class="container pt-2">
            <div class="row justify-content-center">
                <h3 class="mt-5">{{ $titulo }}</h3>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <form id="mydropzone" name="file[]" type="file" multiple class="dropzone"  action="{{ $ruta_store }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="dz-message" data-dz-message><span>Arrastra aquí tus imágenes</span></div>
                        <div class="row justify-content-center">
                            <button id="procesar_fotos" type="button" class="btn btn-warning btn-lg">Procesar fotos</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @yield('zona-items')
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ $ruta_volver }}" class="btn btn-warning btn-lg">Volver</a>
                    {{--<a href="{{ route ('product_files.index', ['product'=>$product->id]) }}" class="btn btn-warning btn-lg">Subir archivos</a>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
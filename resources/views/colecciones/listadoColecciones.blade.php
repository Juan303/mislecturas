@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
    
        <div class="col-md-12" id="tablaListadoColeccionesBloque">
            <h4 class="text-center">Listado de colecciones</h4>
            <div class="text-center toolbar" id="toolbarColecciones">
                <button class="btn btn-primary btn-sm py-2 btnCambiarTabla">
                    <i class="fas fa-exchange-alt"></i> 
                    Autores
                </button>
                <div class="ml-4 form-check form-check-inline">
                    <input class="form-check form-check-inline checkSoloColeccionando" type="checkbox">
                    <label class="form-check form-check-inline" for="checkSoloColeccionando">Solo coleccionando</label>
                </div>
            </div>
            <!-- boton para cambiar de tabla -->
            <table id="tablaListadoColecciones" class="table table-sm table-bordered small">
                <thead>
                <tr>
                    <th data-sortable="true" data-field="nombre">Nombre</th>
                    <th data-sortable="true" data-field="autor">Autor</th>
                    <th class="text-center" data-formatter="tablaListadoColeccionesFormatterActionsRow">Detalles</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="col-md-12 d-none" id="tablaListadoAutoresBloque">
            <h4 class="text-center">Listado de autores</h4>
            <div class="text-center toolbar" id="toolbarAutores">
                <button class="btn btn-primary btn-sm py-2 btnCambiarTabla">
                    <i class="fas fa-exchange-alt"></i> 
                    Colecciones
                </button>
                <!-- check para mostrar solo los autores que estoy coleccionando -->
                <div class="ml-4 form-check form-check-inline ">
                    <input class="form-check form-check-inline checkSoloColeccionando" type="checkbox">
                    <label class="form-check form-check-inline" for="checkSoloColeccionando">Solo coleccionando</label>
                </div>
            </div>
            <table id="tablaListadoAutores" class="table table-sm table-bordered small">
                <thead>
                <tr>
                    <th data-sortable="true" data-field="autor">Autor</th>
                    <th data-sortable="true" data-field="obras">Obras</th>
                    <th class="text-center" data-formatter="tablaListadoAutoresFormatterActionsRow">Detalles</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section("scripts")
    {{--<!-- Gestion Mangas -->--}}
    <script src="{{ asset('js/gestion-listadoColecciones.js?v=123456') }}" type="text/javascript"></script>
    <script src="{{ asset('js/gestion-listadoColeccionesFormatter.js?v=123456') }}" type="text/javascript"></script>
@endsection


@section("modals")
    @include('partials.messages.modal_registro_lectura')
    @include('partials.messages.modal_detalles_item')
    @include('colecciones.usuario.partials.modal_obras_autor')
@endsection




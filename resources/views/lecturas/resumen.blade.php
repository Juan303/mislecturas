@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
    <style>
        .nav-link.active{
            background-color: #3d923d !important;
        }
        .scrolling-wrapper {
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
        <div class="col col-md-2 text-nowrap text-start  align-items-baseline">
            <span class="@movile h5 @else h3 @endmovile text-uppercase text-muted">Resumen</span>
        </div>
        <div class="col col-md-5 text-right">
            <span class="@movile h5 @else h3 @endmovile text-uppercase text-muted">Total: <span id="lecturasTotales"></span></span>
        </div>
        <div class="col-md-12">
            <hr class="border-top text-muted">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <div class="form-group d-inline">
                <select id="selectAnyo" class="form-control form-inline  px-2 py-0 mr-2" style="height: 2rem">
                    @for($i = date('Y'); $i >= 2017; $i--)
                        <option value="{{ $i }}" @if($i == date('Y')) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group d-inline">
                <select id="selectTipo" class="form-control form-inline  px-2 py-0" style="height: 2rem">
                    <option selected value="">Todos</option>
                    <option value="manga">Mangas</option>
                    <option value="libro">Libros</option>
                </select>
            </div>
        </div>
    </div>
    <div id="bloqueResumen">
    </div>
@endsection

@section("scripts")
    {{--<!-- Gestion Mangas -->--}}
    <script src="{{ asset('js/gestion-mangas.js') }}" type="text/javascript"></script>
    {{--<!-- Filtros -->--}}
    <script src="{{ asset('js/filtros-items_v2.js?v=2') }}" type="text/javascript"></script>
    {{--<!-- Resumen -->--}}
    <script src="{{ asset('js/lecturas/resumen.js?v=2') }}" type="text/javascript"></script>
    {{--<!-- Carga perezosa de imagenes -->--}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
@endsection


@section("modals")
    @include('partials.messages.modal_detalles_item')
@endsection




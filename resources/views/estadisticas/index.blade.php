@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/estadisticas/estadisticas.css') }}" />
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
            <span class="@movile h5 @else h3 @endmovile text-uppercase text-muted">Estadísticas</span>
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
    <div id="bloqueEstadisticasAnualesLectura" class="mb-4">
        <div class="row">
            <div class="col-md-12 border-1 rounded">
                <h4 class="text-center">Gráfico anual de lectura/compra</h4>
                <!-- aqui debera mostrarse un grafico con las lecturas anuales -->
                <progress id="initialProgress" max="1" value="0" style="width: 100%;"></progress>
                <div id="graficoEstadisticasAnualesLectura" class="chart-container">
                    <canvas id="chartEstadisticasAnualesLectura"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div id="bloqueDatosEstadisticasTabla">
        <!-- aqui debera mostrarse una bootstraTable con los datos de las estadisticas -->
        <div class="row">
            <div class="col-12 col-md-6 border-1 rounded mb-3">
                <h4 class="text-center">Estadísticas de lectura</h4>
                <table id="tablaEstadisticasLecturas" class="table table-sm table-bordered small">
                    <thead>
                        <tr>
                            <th data-sortable="true" data-field="mes" data-formatter="fechaFormatterNombreMes">Mes</th>
                            <th class="text-right" data-sortable="true" data-field="cantidad" data-formatter="numberFormatterWith0Decimals" data-footer-formatter="sumaNumberFooterFormatterWith0Decimals">Lecturas</th>
                            <th class="text-right" data-sortable="true" data-field="paginas" data-formatter="numberFormatterWith0Decimals" data-footer-formatter="sumaNumberFooterFormatterWith0Decimals">Páginas</th>
                            <th class="text-center" data-formatter="tablaEstadisticasLecturasFormatterActionsRow">Detalles</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-12 col-md-6 border-1 rounded">
                <h4 class="text-center">Estadísticas de compras</h4>
                <table id="tablaEstadisticasCompras" class="table table-sm table-bordered small">
                    <thead>
                        <tr>
                            <th data-sortable="true" data-field="mes" data-formatter="fechaFormatterNombreMes">Mes</th>
                            <th class="text-right" data-sortable="true" data-field="cantidad" data-formatter="numberFormatterWith0Decimals" data-footer-formatter="sumaNumberFooterFormatterWith0Decimals">Cantidad</th>
                            <th class="text-right" data-sortable="true" data-field="precio" data-formatter="monedaFormatterWith2Decimals" data-footer-formatter="sumaMonedaFooterFormatterWith2Decimals">Precio</th>
                            <th class="text-right" data-sortable="true" data-field="precioD" data-formatter="monedaFormatterWith2Decimals" data-footer-formatter="sumaMonedaFooterFormatterWith2Decimals">Precio d.</th>
                            <th class="text-center" data-formatter="tablaEstadisticasComprasFormatterActionsRow">Detalles</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    {{--<!-- Gestion Mangas -->--}}
    <script src="{{ asset('js/gestion-mangas.js') }}" type="text/javascript"></script>
    {{--<!-- Filtros -->--}}
    <script src="{{ asset('js/filtros-items_v2.js?v=2') }}" type="text/javascript"></script>
    {{--<!-- Resumen -->--}}
    <script src="{{ asset('js/gestion-estadisticas.js?v=2') }}" type="text/javascript"></script>
    {{--<!-- Carga perezosa de imagenes -->--}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
    <script src="{{ asset('js/estadisticas/estadisticasFormatter.js?v=2') }}" type="text/javascript"></script>
@endsection


@section("modals")
    @include('estadisticas.modal.modal_detalles_mes')
@endsection




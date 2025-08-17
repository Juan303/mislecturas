@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
    <style>
        .btn.btn-link{
            white-space: normal !important;
        }
    </style>
@endsection

@section('zona-items')
    @include('partials.buscadores.buscador_principal')
    <div class="row mt-2">
        <div class="col-md-12">
            <h3 class="text-uppercase text-muted">Mi biblioteca</h3>
            <hr class="border-top text-muted">
        </div>
        <div class="d-none d-lg-block col-12 col-lg-2">
            <table class="table table-sm">
                <tr class="font-weight-bold">
                    <td class="text-uppercase">Colecciones</td>
                    <td class="text-right">{{$datosColeccionesGlobales['n_totalColecciones']}}</td>
                </tr>
                <tr>
                    <td>Completas:</td>
                    <td class="text-right">{{$datosColeccionesGlobales['n_coleccionesCompletas']}}</td>
                </tr>
                <tr>
                    <td>Incompletas:</td>
                    <td class="text-right">{{$datosColeccionesGlobales['n_coleccionesIncompletas']}}</td>
                </tr>
                <tr>
                    <td>Al día:</td>
                    <td class="text-right">{{$datosColeccionesGlobales['n_coleccionesAlDia']}}</td>
                </tr>
            </table>
            <table class="table table-sm">
                <tr class="font-weight-bold">
                    <td class="text-uppercase">Mangas</td>
                    <td class="text-right">{{$datosColeccionesGlobales['n_totalComics']}}</td>
                </tr>
                <tr>
                    <td>Tengo:</td>
                    <td class="text-right">{{$datosColeccionesGlobales['n_comicsTengoEditados']}}</td>
                </tr>
                <tr>
                    <td>Me faltan:</td>
                    <td class="text-right">{{$datosColeccionesGlobales['n_comicsMeFaltan']}}</td>
                </tr>
            </table>
        </div>
        <div class="col-12 col-lg-10">
            <div class="row">
                <!--BOTONES FILTRO PARA MOVIL-->
                <div class="d-block d-lg-none col-md-8">
                    <button class="btn-filtro-al-dia btn btn-sm px-1 py-1 mr-0 btn-outline-secondary text-success"><i class="fa fa-list"></i> Al día</button>
                    <button class="btn-filtro-completas btn px-1 py-1 mr-0 btn-sm btn-outline-secondary text-success"><i class="fa fa-list-ul"></i> Completas</button>
                    <button class="btn-filtro-incompletas btn px-1 py-1 mr-0 btn-sm btn-outline-secondary text-warning"><i class="fa fa-list-ul"></i> Incompletas</button>
                    <button class="btn-filtro-todas btn px-1 py-1 mr-0 btn-sm btn-outline-secondary text-info"><i class="fa fa-th"></i> Todas</button>
                </div>
                <!--BOTONES FILTRO PARA WEB-->
                <div class="d-none d-lg-block col-md-6">
                    <button class="btn-filtro-al-dia px-2 py-2 mr-0 btn btn-outline-secondary text-success"><i class="fa fa-list"></i> Al día</button>
                    <button class="btn-filtro-completas px-2 py-2 mr-0 btn btn-outline-secondary text-success"><i class="fa fa-list-ul"></i> Completas</button>
                    <button class="btn-filtro-incompletas px-2 py-2 mr-0 btn btn-outline-secondary text-warning"><i class="fa fa-list-ul"></i> Incompletas</button>
                    <button class="btn-filtro-todas px-2 py-2 mr-0 btn btn-outline-secondary text-info"><i class="fa fa-th"></i> Todas</button>
                </div>
                <!--ORDENAR Y BUSCAR PARA MOVIL-->
                <div class="col-6 col-md-4 text-left text-md-right align-baseline d-block d-lg-none">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary text-muted px-1 py-1 dropdown-toggle" type="button" id="dropdownMenuButton_web" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sort-amount-down-alt"></i> Ordenar por...
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_web">
                            <a data-ordenar-por="coleccion" class="orden-item dropdown-item" href="">Titulo...</a>
                            <a data-ordenar-por="orden-item-id" class="orden-item dropdown-item" href="">Más recientes...</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-2 text-left text-md-right align-baseline d-block d-lg-none">
                    <input class="form-control form-control-lg buscador" type="text" placeholder="Buscar en biblioteca...">
                </div>
                <!--ORDENAR Y BUSCAR PARA WEB-->
                <div class="col-12 col-md-3 text-left text-left text-md-right align-baseline d-none d-lg-block">
                    <input class="form-control form-control-lg buscador" type="text" placeholder="Buscar en biblioteca...">
                </div>
                <div class="col-6 col-md-3 text-left text-md-right align-baseline d-none d-lg-block">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary text-muted px-2 py-2 dropdown-toggle" type="button" id="dropdownMenuButton_web" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sort-amount-down-alt"></i> Ordenar por...
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_web">
                            <a data-ordenar-por="coleccion" class="orden-item dropdown-item" href="#">Titulo...</a>
                            <a data-ordenar-por="orden-item-id" class="orden-item dropdown-item" href="#">Más recientes...</a>
                        </div>
                    </div>
                </div>
            </div>

            @if(empty($datosColeccionesGlobales['n_totalColecciones']))
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="alert alert-warning">No tienes ninguna colección añadida a tu biblioteca. Para empezar a añadirlas, busca la colección mediante el buscandor y añade los mangas que tengas.</div>
                    </div>
                </div>
            @else
                <div class="row px-2" id="colecciones">
                    @foreach ($colecciones as $coleccion)
                        @if(!empty($coleccion['usuario_comics']))
                            @include('partials.cards.coleccion_card', ['coleccion' => $coleccion])
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section("scripts")
    {{--<!-- Graficas colecciones -->--}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="{{ asset('js/graficas-colecciones.js') }}" type="text/javascript"></script>
    {{--<!-- Barras progreso colecciones -->--}}
   {{-- <script>
        $(document).ready(function(){
            $(".progress-new-bar").ProgressBar();
        });
    </script>--}}
    {{--<!-- Filtros -->--}}
    <script src="{{ asset('js/filtros-items.js') }}" type="text/javascript"></script>
    {{--<!-- Buscador en la colección -->--}}
    <script src="{{ asset('js/buscadores.js') }}" type="text/javascript"></script>
    {{--<!-- Gestionar colecciones -->--}}
    <script src="{{ asset('js/gestion-colecciones.js') }}" type="text/javascript"></script>
    {{--<!-- Ordenar coleccines -->--}}
    <script src="{{ asset('js/ordenar-colecciones.js') }}" type="text/javascript"></script>

@endsection


@section("modals")
    @include('colecciones.usuario.partials.modal_editar_coleccion')
    @include('colecciones.usuario.partials.modal_info_coleccion')
    @include('colecciones.usuario.partials.modal_novedades_coleccion')

@endsection




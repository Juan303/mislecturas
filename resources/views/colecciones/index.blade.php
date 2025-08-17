@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
@endsection

@section('zona-items')
    @include('partials.buscadores.buscador_principal')
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron bg-light text-dark accordion col-md-12 jumbotron-fluid pb-2 pt-3" id="accordionDatosColeccion">
                <div class="container">
                    @movile
                        <h4 class="text-uppercase text-gris">{{ $datosColeccion->datosColeccion['titulo'] }}</h4>
                    @else
                        <h1 class="text-uppercase text-gris">{{ $datosColeccion->datosColeccion['titulo'] }}</h1>
                    @endmovile
                        <button class="btn btn-link dropdown-toggle p-0 p-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Mostar Información</button>
                    <div id="collapseOne" class="collapse hide" data-parent="#accordionDatosColeccion">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Datos de la colección: </h4>
                                <table class="table table-striped table-sm" style="font-size: 0.8rem">
                                    @if(isset($datosColeccion->datosColeccion['tituloOriginal']))
                                        <tr>
                                            <td><strong>Titulo original:</strong></td>
                                            <td>{{ $datosColeccion->datosColeccion['tituloOriginal'] }}</td>
                                        </tr>
                                    @endif
                                    @if(isset($datosColeccion->datosColeccion['guion']))
                                        <tr>
                                            <td><strong>Guión:</strong></td>
                                            <td>{{ $datosColeccion->datosColeccion['guion'] }}</td>
                                        </tr>
                                    @endif
                                    @if(isset($datosColeccion->datosColeccion['dibujo']))
                                        <tr>
                                            <td><strong>Dibujo:</strong></td>
                                            <td>{{ $datosColeccion->datosColeccion['dibujo'] }}</td>
                                        </tr>
                                    @endif
                                    @if(isset($datosColeccion->datosColeccion['traduccion']))
                                        <tr>
                                            <td><strong>Traducción:</strong></td>
                                            <td>{{ $datosColeccion->datosColeccion['traduccion'] }}</td>
                                        </tr>
                                    @endif
                                    @if(isset($datosColeccion->datosColeccion['editorialJaponesa']))
                                        <tr>
                                            <td><strong>Editorial japonesa:</strong></td>
                                            <td>{{ $datosColeccion->datosColeccion['editorialJaponesa'] }}</td>
                                        </tr>
                                    @endif
                                    @if(isset($datosColeccion->datosColeccion['editorialEspanola']))
                                        <tr>
                                            <td><strong>Editorial española:</strong></td>
                                            <td>{{ $datosColeccion->datosColeccion['editorialEspanola'] }}</td>
                                        </tr>
                                    @endif
                                        @if(isset($datosColeccion->datosColeccion['tipo']))
                                            <tr>
                                                <td><strong>Tipo:</strong></td>
                                                <td>{{ $datosColeccion->datosColeccion['tipo'] }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($datosColeccion->datosColeccion['formato']))
                                            <tr>
                                                <td><strong>Formato:</strong></td>
                                                <td>{{ $datosColeccion->datosColeccion['formato'] }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($datosColeccion->datosColeccion['sentido']))
                                            <tr>
                                                <td><strong>Sentido de lectura:</strong></td>
                                                <td>{{ $datosColeccion->datosColeccion['sentido'] }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($datosColeccion->datosColeccion['numerosJapones']))
                                            <tr>
                                                <td><strong>Números en japonés:</strong></td>
                                                <td>{{ $datosColeccion->datosColeccion['numerosJapones'] }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($datosColeccion->datosColeccion['numerosEspanol']))
                                            <tr>
                                                <td><strong>Números en español:</strong></td>
                                                <td>{{ $datosColeccion->datosColeccion['numerosEspanol'] }}</td>
                                            </tr>
                                        @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4>Sinopsis: </h4>
                                {!!  $datosColeccion->sinopsis !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if (auth()->user())
            <div class="col-12 col-md-2 mb-4 filtros-comics">
                <button class="btn btn-link dropdown-toggle p-0 p-0" data-toggle="collapse" data-target="#collapseFiltros" aria-expanded="@movile false @else true @endmovile" aria-controls="collapseFiltros">
                    @movile
                        Mostrar filtros
                    @else
                        Ocultar filtros
                    @endmovile
                </button>
                @include('partials.filtros.filtros-comics', ['mostrar' => ['posesion', 'lectura', 'tipo']])
            </div>
        @endif
        <div class="@if(auth()->user()) col-md-10 @else col-md-12 @endif">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-1 text-uppercase text-muted"><a  href=""></a>Listado de mangas: </h4>
                </div>
                @if(auth()->user())
                    <div class="col-md-6 text-left text-md-right d-inline">
                        <a href="{{ route('scrapper', ['coleccion' => $datosColeccion->id]) }}" class="btn btn-success py-2"  type="submit">
                            <i class="fas md-18 fa-rotate-right"></i>
                        </a>
                        @include('partials.acciones-globales.acciones-globales')
                    </div>
                @endif
            </div>
            {{ $comics->links() }}
            <div class="row mt-3">
                @if(!empty( $comics))
                    @foreach ( $comics as $manga)
                        @include('partials.cards.comic_card', ['manga' => $manga, 'zona'=>'coleccion', 'elementosPorFila' => 4])
                    @endforeach
                @endif
            </div>
            {{ $comics->links() }}
        </div>
    </div>

@endsection

@section("scripts")
    {{--<!-- Mostrar ocultar información -->--}}
    <script>
        $(document).ready(function (){
            $("button[data-target='#collapseOne']").click(function(){
                $(this).text('mostrar información')
                if($(this).attr('aria-expanded') == 'false'){
                    $(this).text('ocultar información')
                }
            })
            //Cambiamos el texto del boton de filtros
            $("button[data-target='#collapseFiltros']").click(function() {
                $(this).text('Mostrar filtros')
                if ($(this).attr('aria-expanded') == 'false') {
                    $(this).text('Ocultar filtros')
                }
            });
        })
    </script>
    {{--<!-- Filtros -->--}}
    <script src="{{ asset('js/filtros-items_v2.js?v=2') }}" type="text/javascript"></script>
    <script>
        //Barras de progreso
        $(document).ready(function(){
            actualizarPaginasLeidas();
            confirmarActualizarPaginasLeidas();
        });
    </script>
@endsection


@section("modals")
    @include('partials.messages.modal_registro_lectura')
    @include('partials.messages.modal_detalles_item')
    @include('colecciones.usuario.partials.modal_agregar_todos_compra')
    @include('colecciones.usuario.partials.modal_agregar_todos_lectura')
    @include('colecciones.usuario.partials.modal_prestar')
@endsection




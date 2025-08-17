@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
        @if (auth()->user())
            <div class="col-12 col-md-2 mb-1">
                @include('partials.filtros.filtros-libros', ['mostrar' => ['posesion', 'lectura']])
                <button class="btn btn-link dropdown-toggle p-0 p-0" data-toggle="collapse" data-target="#collapseFiltros" aria-expanded="@movile false @else true @endmovile" aria-controls="collapseFiltros">
                    @movile Mostrar filtros @else Ocultar filtros @endmovile
                </button>
            </div>
        @endif
        <div class="@if(auth()->user()) col-md-10 @else col-md-12 @endif">
            <div class="row">
                <div class="col-8">
                    <h4 class="mb-1 text-uppercase text-muted"><a  href=""></a>Listado de libros: </h4>
                </div>
                @if(auth()->user())
                    <div class="col-4 text-right d-inline">
                        <a href="{{ route('usuario.libros.create') }} " class="btn btn-sm btn-sm btn-success">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                @endif
            </div>
            <div class="row mt-3">
                @forelse ( $libros as $libro)
                    @include('partials.cards.libro_card', ['manga' => $libro, 'elementosPorFila' => 4])
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            <p class="my-1">No se han encontrado libreos</p>
                        </div>
                    </div>
                @endforelse
            </div>
            {{ $libros->links() }}
        </div>
    </div>

@endsection

@section("scripts")
    {{--<!-- Gestion Mangas -->--}}
    <script src="{{ asset('js/gestion-mangas.js?v=123456') }}" type="text/javascript"></script>
    {{--<!-- Gestion Libros -->--}}
    <script src="{{ asset('js/gestion-libros.js?v=123456') }}" type="text/javascript"></script>
    {{--<!-- Filtros -->--}}
    <script src="{{ asset('js/filtros-items_v2.js?v=2') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function (){
            actualizarPaginasLeidas();
            confirmarActualizarPaginasLeidas();
            //Cambiamos el texto del boton de filtros
            $("button[data-target='#collapseFiltros']").text('Mostrar filtros');
            $("button[data-target='#collapseFiltros']").click(function() {
                $(this).text('Mostrar filtros')
                if ($(this).attr('aria-expanded') == 'false') {
                    $(this).text('Ocultar filtros')
                }
            });
        });
    </script>
@endsection


@section("modals")
    @include('partials.messages.modal_registro_lectura')
    @include('partials.messages.modal_detalles_item')
@endsection




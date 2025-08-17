@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
        <div class="col-md-12">
            <h3 class="text-uppercase text-muted">Mangas que busco</h3>
            <hr class="border-top text-muted">
        </div>
    </div>


        @if(count($comics)<1)
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="alert alert-warning">Aún no has añadido ningún cómic a tu lista de buscados. Marca los cómics que desees obtener en un futuro para que aparezcan en esta sección.</div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 col-md-2">
                    @include('partials.filtros.filtros-comics', ['mostrar' => []])
                </div>
                <div class="col-12 col-md-10 text-right">
                    @if(auth()->user())
                        <div class="row mb-2">
                            <div class="col-12 text-right">
                                @include('partials.acciones-globales.acciones-globales', ['mostrar' => ['buscados']])
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        @foreach($comics as $manga)
                            @include('partials.cards.comic_card', ['manga'=>$manga, 'zona'=>'buscados', 'elementosPorFila' => 6])
                        @endforeach
                    </div>
                    {{ $comics->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection

@section("scripts")
    {{--<!-- Gestion Mangas -->--}}
    <script src="{{ asset('js/gestion-mangas.js') }}" type="text/javascript"></script>
    {{--<!-- Filtros -->--}}
    <script src="{{ asset('js/filtros-items_v2.js?v=2') }}" type="text/javascript"></script>
    <script>
        //Barras de progreso
        $(document).ready(function(){
            $(".progress-new-bar").ProgressBar();
        });
    </script>
@endsection


@section("modals")
    @include('partials.messages.modal_detalles_item')
@endsection




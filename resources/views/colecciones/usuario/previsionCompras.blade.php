@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
@endsection

@section('zona-items')
    @include('partials.buscadores.buscador_principal')
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-uppercase text-muted mb-1">Compras pendientes</h3>
            <hr class="border-top text-muted m-0">
        </div>
    </div>
    {{ $comicsPendientes->links() }}
    <div class="row mt-2">
        @if(!empty( $comicsPendientes))
            @foreach ( $comicsPendientes as $manga)
                @include('partials.cards.comic_card_proximo_lanzamiento', ['manga' => $manga, 'colorCabecera' => ''])
            @endforeach
        @endif
    </div>
    {{ $comicsPendientes->links() }}
    <div class="row mt-5">
        <div class="col-md-12">
            <h3 class="text-uppercase text-muted mb-1">Mis próximos lanzamientos</h3>
            <hr class="border-top text-muted m-0">
        </div>
    </div>
    {{ $comics->links() }}
    <div class="row mt-2">
        @if(!empty( $comics))
            @foreach ( $comics as $manga)
                @include('partials.cards.comic_card_proximo_lanzamiento', ['manga' => $manga, 'colorCabecera' => 'bg-warning'])
            @endforeach
        @endif
    </div>
    {{ $comics->links() }}
@endsection
@section("scripts")
@endsection


@section("modals")
    @include('partials.messages.modal_detalles_item')
@endsection




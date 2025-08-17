@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
        <div class="col-md-12">
            <h3 class="text-uppercase text-muted">Estadísticas</h3>
            <hr class="border-top text-muted">
        </div>
    </div>
    <div class="row mb-3">

    </div>
    <div class="row mb-3">

    </div>
@endsection

@section("scripts")
    {{--<!-- Gestion Retos -->--}}
    <script src="{{ asset('js/gestion-estadisticas.js?v=123456') }}" type="text/javascript"></script>
@endsection


@section("modals")
@endsection




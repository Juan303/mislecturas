@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
        <div class="col-md-12">
            <h3 class="text-uppercase text-muted">Retos</h3>
            <hr class="border-top text-muted">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {{-- Boton para configurar el reto anual --}}
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalConfigurarReto">
                Configurar reto anual
            </button>
        </div>
    </div>
    <div class="row">
        @if($reto->count() <= 0)
            <div class="col-12">
                <div class="alert alert-info rounded" role="alert">
                    No tienes retos configurados.
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="card rounded">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-muted text-uppercase">Reto anual</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Progreso del reto</h6>
                                <div class="progress-new-bar mt-1 mb-1">
                                    <div id="progressBarProgresoAnual" class="progress-new text-center"
                                         data-percent="{{ $reto->CantidadAnual > 0 ? round((count($mangas) / $reto->CantidadAnual) * 100, 2) : 0 }}"
                                         data-color="green">
                                        <span>{{ $manga->paginas_totales > 0 ? round(($manga->paginas_leidas / $manga->paginas_totales) * 100, 2) : 0 }}%</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section("scripts")
    {{--<!-- Gestion Retos -->--}}
    <script src="{{ asset('js/gestion-retos.js?v=123456') }}" type="text/javascript"></script>
@endsection


@section("modals")
    @include('partials.messages.modal_configurar_reto')
@endsection




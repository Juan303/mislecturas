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
    <div class="row mb-3">
        <div class="col-12">
            {{-- Boton para configurar el reto anual --}}
            <button type="button" data-librosLeidosAnuales="0" class="btn btn-success" data-toggle="modal" data-target="#ModalConfigurarReto" id="BtnConfigurarReto">
                Configurar reto actual
            </button>
        </div>
    </div>
    <div class="row mb-3" id="bloqueRetoActual">

    </div>
    @if($retosAnyosAnteriores->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card rounded m-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-muted text-uppercase mb-1">Retos años anteriores</h4>
                            </div>
                            <div class="col-12 pt-1 pb-0 mb-2">
                                <hr class="m-0">
                            </div>
                            @foreach($retosAnyosAnteriores as $reto)
                               
                                <div class="col-12 mb-0">
                                    <h5 class="text-muted text-uppercase mb-1">{{ $reto->anyoReto }} <span id="fraccionLibrosLeidosReto">({{ $reto->nLecturas }} / {{ $reto->cantidadAnual }}) </span></h5>
                                </div>
                                <div class="col-10 mb-2">
                                    @include('partials.progress-bars.default-progress-bar', [
                                       'porcentaje' => round(($reto->nLecturas / $reto->cantidadAnual) * 100, 2)
                                   ])
                                </div>
                                <div class="col-2 mb-2 text-right">
                                    <!-- cara sonriente si se ha cumplido el reto -->
                                    @if($reto->nLecturas >= $reto->cantidadAnual)
                                        <i class="far fa-smile fa-2x text-success"></i>
                                    @elseif($reto->nLecturas < $reto->cantidadAnual && $reto->nLecturas > 0)
                                        <i class="far fa-meh fa-2x text-warning"></i>
                                    @else
                                        <i class="far fa-frown  fa-2x text-danger"></i>
                                    @endif
                                </div>
                                <div class="col-12 pt-1 pb-0 mb-2">
                                    <hr class="m-0">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section("scripts")
    {{--<!-- Gestion Retos -->--}}
    <script src="{{ asset('js/lecturas/retos.js?v=123456') }}" type="text/javascript"></script>
@endsection


@section("modals")
    @include('partials.messages.modal_configurar_reto')
@endsection




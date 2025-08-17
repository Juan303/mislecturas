@if($retoAnyoActual == null || $retoAnyoActual->anyoReto != date("Y"))
    <div class="col-12">
        <div class="alert alert-info rounded" role="alert">
            No tienes retos configurados para este año.
        </div>
    </div>
@else
    <div class="col-12">
        <!-- div de carga de los datos de interés -->
        <div class="loading-data text-center" hidden>
            <div class="spinner-border text-info" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <div class="card rounded m-0">
            <div class="card-body @movile px-2 @endmovile">
                <div class="row mb-2">
                    <!-- si estoy en la ruta de nombre "welcome" -->
                    @if(!empty($zona) && $zona == 'welcome')
                        <div class="col-10">
                            <div class="@movile h5 @else h4 @endmovile text-uppercase text-muted mb-0 @movile mt-0 @endmovile">
                                Reto actual {{ date("Y") }} <span id="fraccionLibrosLeidosReto">({{ $retoAnyoActual->nLecturas }} / {{ $retoAnyoActual->cantidadAnual }}) </span>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            @movile
                                <a href="{{ route('usuario.lectura.retos') }}" class="py-0 px-2 mb-0">
                                    <i class="text-info fas fa-book"></i>
                                </a>
                            @else
                                <a href="{{ route('usuario.lectura.retos') }}" class="btn btn-sm btn-outline-info float-right">Detalles</a>
                            @endmovile
                        </div>
                        <div class="col-12">
                            <hr class="border-top m-0">
                        </div>
                    @else
                        <div class="col-8">
                            <h4 class="text-muted text-uppercase mb-1">Actual <span id="fraccionLibrosLeidosReto">({{ $retoAnyoActual->nLecturas }} / {{ $retoAnyoActual->cantidadAnual }}) </span></h4>
                        </div>
                        <div class="col-4">
                            <h5 class="text-muted text-right text-muted mb-1">{{ date("Y") }}</h5>
                        </div>
                        <div class="col-12 pt-1 pb-0">
                            <hr class="m-0">
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        @include('partials.progress-bars.default-progress-bar', [
                            'porcentaje' => $retoAnyoActual->cantidadAnual > 0 ? round(($retoAnyoActual->nLecturas / $retoAnyoActual->cantidadAnual) * 100, 2) : 0,
                            'id' => 'progressBarProgresoAnual'
                        ])
                    </div>
                </div>
                <div class="row">
                    <!-- ritmo de lectura que debes llevar al mes para cumplir el reto -->
                    <div class="col-12">
                        <p class="text-muted mb-0">Para cumplir el reto debes leer:</p>
                        <ul class="list-unstyled m-1">
                            <li class="text-muted mb-1">
                                <i class="fas fa-book"></i>
                                <strong class="text-dark" id="librosAlMesParaCumplirReto">
                                    {{ $librosAlMesParaCompletarReto }}
                                </strong> libros al <strong class="text-dark">mes.</strong>
                            </li>
                            <li class="text-muted mb-1">
                                <i class="fas fa-book"></i>
                                <strong class="text-dark" id="librosAlMesParaCumplirReto">
                                    {{ $librosALaSemanaParaCompletarReto }}
                                </strong> libros cada <strong class="text-dark">semana.</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
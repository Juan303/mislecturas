@php
    $anchoimagen = ($esMovil) ? '25rem' : '65rem';
    $marginTop = ($esMovil) ? 'mt-2' : 'mt-4';
@endphp
<div class="accordion" id="accordionExample">
    @forelse ($comicsPorFecha as $anyo => $comicsPorAnyo)
        <div class="row px-3">
            @foreach($comicsPorAnyo as $mes => $comicsPorMes)
                <div id="headingOne_{{ $anyo }}_{{ $mes }}" class="col-md-12 border-1 rounded">
                    <div class="row mb-2 border-1 rounded" data-toggle="collapse" data-target="#collapseOne_{{ $anyo }}_{{ $mes }}" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="position-absolute @if($esMovil) h6 @else h4 @endif {{ $marginTop }} start-0 translate-middle badge rounded-pill bg-dark" style="z-index: 1000;">
                            {{ $meses[$mes] }} - {{ count($comicsPorMes) }}
                        </h5>
                        @foreach($comicsPorMes as $manga)
                            <div style="opacity: 0.5;">
                                <img class="carga-perezosa" width="{{$anchoimagen}}" src="{{ $manga->imagen }}" alt="{{ $manga->tituloColeccion }} - {{ $manga->id }}">
                            </div>
                        @endforeach
                    </div>
                    <div id="collapseOne_{{ $anyo }}_{{ $mes }}" class="collapse" aria-labelledby="headingOne_{{ $anyo }}_{{ $mes }}" data-parent="#accordionExample">
                        <div class="row mb-1">
                            @foreach($comicsPorMes as $manga)
                                @include('partials.cards.comic_card', ['manga'=>$manga, 'zona'=> 'resumen', 'elementosPorFila' => 6])
                            @endforeach
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @empty
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info rounded" role="alert">
                    No tienes lecturas registradas en el año seleccionado.
                </div>
            </div>
        </div>
    @endforelse
</div>


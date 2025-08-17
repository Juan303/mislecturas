<div class="mt-0 mb-3 col-6 col-md-2 p-2">
    <div class="d-flex position-relative flex-column pb-1" id="card_{{$manga->id}}" data-comic-id="{{ $manga->id }}" style="height: 95%">
        <span class="h5 p-1 pr-2 m-0 position-absolute rounded-end shadow shadow-dark font-weight-bold text-dark bg-crema-oscuro w-100 {{ $colorCabecera }}" style="z-index:10; left: -3px; top:-3px; box-shadow: #383838 3px 3px 3px; border-bottom-right-radius: 4px">{{ $manga->numero }} | <span class="text-muted font-italic small">{{ $manga->fecha_publicacion }}</span></span>
        <div class="row mb-0">
            <div class="col-12 text-center">
                <a class="btn-detalles-item" data-tipo-lectura="{{ $manga->tipoLectura }}" data-id-item="{{ $manga->id }}">
                    <img class="carga-perezosa img-fluid w-100" src="{{ $manga->imagen }}" alt="{{ $manga->tituloColeccion }} - {{ $manga->id }}">
                </a>
            </div>
        </div>

        <div class="row mt-auto">
            <div class="col-12">
                <p class="mb-1 mt-1 text-center">
                    <a class="btn btn-link m-0 p-1 small"
                        href="{{ route('coleccion.index', ['id' => $manga->coleccion_id]) }}">
                        <span class="text-uppercase">{{ $manga->tituloColeccion }}@if(!empty($manga->numero)) - @if($manga->numeroUnico)Tomo único @else#{{ $manga->numero }}@endif @endif</span>
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>




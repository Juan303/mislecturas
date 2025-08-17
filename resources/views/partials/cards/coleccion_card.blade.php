
<div data-coleccion="{{ $coleccion['coleccion']['titulo'] }}" data-orden-item-id="{{ $coleccion['id'] }}" class="col-md-3 col-6 mb-3 mx-0 px-1 coleccion-item @if(count($coleccion['usuario_comics']) === count($coleccion['coleccion']['comics_editados'])) @if($coleccion['coleccion']['completa']) coleccion-completa @else coleccion-al-dia @endif @else coleccion-incompleta @endif">
    <div class="card h-90 text-center pb-2">
        <div style="z-index:10; position: absolute; top:0; right: 0">
            <button data-url="{{ route('usuario.coleccion.destroy', ['id' => $coleccion['id']]) }}" data-item-id="{{ $coleccion['id'] }}" data-item-name="{{ $coleccion['coleccion']['titulo'] }}" title="¿Eliminar?" class="btn btn-sm btn-danger border-light border m-0 py-0 px-1 btn-eliminar-coleccion" ><i class="far fa-trash-alt"></i></button>
        </div>

        <a href="#" role="button" class="btn-info-coleccion cursor-pointer"
              data-item-id="{{ $coleccion['id'] }}"
              data-item-name="{{ $coleccion['coleccion']['titulo'] }}"
              data-datos-coleccion="{{ json_encode($coleccion) }}">
            <img src="{{ $coleccion['coleccion']['comics_editados'][0]['imagen'] }}" class="w-100" alt="">
        </a>
        <h4 class="mb-0 mt-auto"><a class="btn btn-link px-3 py-0 h6" href="{{ route('coleccion.index', ['id' => $coleccion['coleccion']['id']]) }}">{{ $coleccion['coleccion']['titulo'] }}</a></h4>
        <div class="mt-auto">

            @php $porcentajeComics = (count($coleccion['usuario_comics']) / count($coleccion['coleccion']['comics_editados']))*100 @endphp
            @php
                $comicsLeidos = 0;
                foreach($coleccion['usuario_comics'] as $comic){
                    if(!empty($comic['usuario_lectura']) && $comic['usuario_lectura']['estado_lectura'] == 2){
                        $comicsLeidos++;
                    }
                }
                $porcentajeLectura = ($comicsLeidos / count($coleccion['coleccion']['comics_editados']))*100;
            @endphp
            <div class="row px-4">
            <div class="col-1 mx-0 px-0 pt-1">
                <i class="fas fa-book"></i>
            </div>
            <div class="col-11 mx-0 px-1 pl-0">
                <div class="py-0">
                    <div class="progress-new-bar my-0 text-center">
                        <div class="progress-new"
                             data-percent="{{ $porcentajeComics }}"
                             data-color="@if($porcentajeComics < 100) orange @else green @endif">
                        </div>
                    </div>
                    <div class="progress-new-text px-1">
                        ({{(count($coleccion['usuario_comics']))}}/{{count($coleccion['coleccion']['comics_editados'])}}) {{ $porcentajeComics == 100 ? '¡COMPLETA!' : round($porcentajeComics, 2).'%' }}
                    </div>
                </div>
            </div>
            <div class="col-1 mx-0 px-0 pt-0">
                <i class="fas fa-book-open pr-1"></i>
            </div>
            <div class="col-11 mx-0 px-1 pl-0 ">
                <div class="py-0">
                    <div class="progress-new-bar my-0 text-center">
                        <div class="progress-new"
                             data-percent="{{ $porcentajeLectura }}"
                             data-color="@if($porcentajeLectura < 100) orange @else green @endif">
                        </div>
                    </div>
                    <div class="progress-new-text px-1">({{$comicsLeidos}}/{{count($coleccion['coleccion']['comics_editados'])}}) {{ $porcentajeLectura == 100 ? '¡LEÍDA!' : round($porcentajeLectura, 2).'%' }}</div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>



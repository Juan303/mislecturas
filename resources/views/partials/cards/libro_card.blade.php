<div class="mt-0 mb-4 col-6 col-md-3 col-lg-3 p-1 manga-item
    @if($libro->tengo == \App\Http\Helpers\UsuarioLibroHelper::TENGO)
        item-tengo
    @elseif ($libro->tengo == \App\Http\Helpers\UsuarioLibroHelper::QUIERO)
        item-quiero
    @endif
    ">
    <div class="d-flex flex-column p-2  h-95 mb-4 mt-0 border bg-light shadow-sm position-relative" id="card_{{$libro->id}}" data-libro-id="{{ $libro->id }}">
        <div class="row">
            <div class="col-12 text-center mt-auto">
{{--                <a data-toggle="modal" data-target="#modal_detalles_libro_{{ $libro->id }}">
                    <img class="carga-perezosa px-1 img-fluid w-100" src="{{ $libro->imagen }}" alt="{{ $libro->titulo }} - {{ $libro->id }}">
                </a>--}}
                <a class="btn-detalles-item" data-tipo-lectura="libro" data-id-item="{{ $libro->id }}">
                    <img class="carga-perezosa px-1 img-fluid w-100" src="{{ $libro->imagen }}" alt="{{ $libro->titulo }} - {{ $libro->id }}">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 position-relative">
                <p class="mb-1 mt-1 text-center" style="line-height: 1rem">
                    <span class="text-uppercase text-gris small">{{ $libro->titulo }}</span>
                </p>
            </div>
        </div>
        <div class="row mt-auto">
            <div class="col-md-12">
                @include('partials.progress-bars.default-progress-bar', [
                            'porcentaje' => $libro->paginas_totales > 0 ? round(($libro->paginas_leidas / $libro->paginas_totales) * 100, 2) : 0,
                            'id' => ''
                        ])
{{--                <div class="progress-new-bar mt-1 mb-1">
                    <div class="progress-new text-center"
                         data-percent="{{ $libro->paginas_totales > 0 ? round(($libro->paginas_leidas / $libro->paginas_totales) * 100, 2) : 0 }}"
                         data-color="green">
                        <span>{{ $libro->paginas_totales > 0 ? round(($libro->paginas_leidas / $libro->paginas_totales) * 100, 2) : 0 }}%</span>
                    </div>
                </div>--}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="dropdown">
                    @php
                        switch($libro->estado_lectura){
                          case \App\Http\Helpers\LecturaHelper::ESTADO_LEIDO:
                            $estiloBoton = 'btn-success';
                            $textoBoton = 'leido';
                            break;
                          case \App\Http\Helpers\LecturaHelper::ESTADO_LEYENDO:
                            $estiloBoton = 'btn-warning';
                            $textoBoton = 'leyendo';
                            break;
                          case \App\Http\Helpers\LecturaHelper::ESTADO_QUIERO_LEER:
                            $estiloBoton = 'btn-info';
                            $textoBoton = 'quiero leer';
                            break;
                          default:
                            $estiloBoton = 'btn-secondary';
                            $textoBoton = 'no leido';
                        }
                    @endphp
                    @if (!isset($zona) || ($zona !== 'buscados' && $zona !== 'resumen'))
                        <button class="btn-dropdown-lectura btn @if (!isset($zona) || $zona !== 'lectura') btn-sm py-0 @else py-1 @endif {{ $estiloBoton }} dropdown-toggle" type="button" id="dropdownMenuButton_lectura_{{ $libro->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $textoBoton }}</button>
                        <div class="dropdown-menu dropdown-lectura" aria-labelledby="dropdownMenuButton_lectura_{{ $libro->id }}">
                            <form action="{{ route("usuario.libros.cambiarEstado") }}" method="post" class="form-lectura mb-0">
                                @csrf
                                <button type="button" data-accion="no leido" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">No leido</button>
                                <button type="button" data-accion="leyendo" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">Leyendo...</button>
                                <button type="button" data-accion="leido" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">Leido</button>
                                <button type="button" data-accion="quiero leer" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">Quiero leer</button>
                                <input type="hidden" name="accion" value="no_leido">
                                <input type="hidden" name="IdLibro" value="{{ $libro->id }}">
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12 text-center">
                <div style="z-index:10">
                    <button data-url="{{ route('usuario.libros.destroy', ['id' => $libro->id]) }}" data-item-id="{{ $libro->id }}" data-item-name="{{ $libro->titulo }}" title="¿Eliminar?" class="btn btn-sm btn-danger m-0 py-0 px-1 btn-eliminar-libro" ><i class="far fa-trash-alt"></i></button>
                    <a href="{{ route('usuario.libros.edit', ['id' => $libro->id]) }}"  class="btn btn-sm btn-warning m-0 py-0 px-1 btn-editar-libro text-white" ><i class="far fa-pencil-square-o"></i></a>
                    <button data-action="{{ route('usuario.libros.cambiarPaginasLeidas') }}" data-tipo-lectura="libro" data-id-item="{{$libro->id}}" data-paginas-totales="{{$libro->paginas_totales}}" data-paginas-leidas="{{ $libro->paginas_leidas }}" data-item-name="{{ $libro->titulo }}" title="Registro de lectura" class="btn btn-sm btn-info m-0 py-0 px-1 btn-cambiar-paginas-leidas" ><i class="fas fa-book-reader"></i></button>
                </div>
            </div>
        </div>

    </div>
</div>

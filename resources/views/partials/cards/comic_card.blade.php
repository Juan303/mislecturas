@php
    $division = 'col-lg-3';
    if(isset($elementosPorFila)){
        $division = 'col-lg-'.(12 / $elementosPorFila);
    }
@endphp
<div class="mt-0 mb-3 col-6 p-2  @if($manga->estado_lectura == \App\Http\Helpers\LecturaHelper::ESTADO_LEYENDO && isset($zona) && $zona == 'lectura') col-lg-2 @else {{ $division }} @endif manga-item
    @if($manga->tengo == \App\Http\Helpers\UsuarioComicHelper::TENGO) item-tengo @elseif ($manga->tengo == \App\Http\Helpers\UsuarioComicHelper::QUIERO) item-quiero @endif
    @if ($manga->tipo == 'editado')
        @if($manga->estado_lectura == \App\Http\Helpers\LecturaHelper::ESTADO_LEIDO) item-leido @endif
    @endif @if ($manga->tipo == 'editado') item-editado @elseif ($manga->tipo == 'no_editado') item-no-editado @else item-en-preparacion @endif"
    data-tags="{{ $manga->tituloColeccion  }} @if(!empty($manga->numero))@if($manga->numeroUnico)Tomo único @else{{ $manga->numero}}@endif @endif">
    @php
        if ($manga->tipo == 'editado' || $manga->tipo == 'preparacion') {
             $border = $text = 'muted';
        }
        elseif($manga->tipo == 'no_editado'){
            $border = $text = 'light';
        }
    @endphp
    <div class="d-flex position-relative flex-column pb-1 @if ($manga->tipo == 'editado') comic-editado @endif mb-4 mt-0 bg-light text-{{ $text }}" id="card_{{$manga->id}}" data-comic-id="{{ $manga->id }}" style="height: 95%">
        @if(isset($zona) && $zona == 'coleccion')
            <span
                class="h4 p-1 pr-2 m-0 position-absolute rounded-end shadow shadow-dark font-weight-bold
                @if($manga->tipo == 'preparacion')
                    text-dark bg-warning
                @elseif($manga->tipo == 'no_editado')
                    text-light bg-dark
                @else
                    bg-crema-oscuro
                @endif"
                style="z-index:10; left: -3px; top:-3px; box-shadow: #383838 3px 3px 3px; border-bottom-right-radius: 4px">#{{ $manga->numero }}
                    @if($manga->tipo == 'preparacion')
                        [PREPARACIÓN]
                    @elseif($manga->tipo == 'no_editado')
                        [NO EDITADO]
                    @endif
            </span>
        @endif
        <div class="row mb-0">
            <div class="col-12 text-center">
                <a class="btn-detalles-item" data-tipo-lectura="{{ $manga->tipoLectura }}" data-id-item="{{ $manga->id }}">
                    <img class="carga-perezosa img-fluid w-100" src="{{ $manga->imagen }}" alt="{{ $manga->tituloColeccion }} - {{ $manga->id }}">
                </a>
            </div>
        </div>
        <div class="row mt-auto">
            <div class="col-12">
                @if(!isset($zona) || $zona !== 'coleccion')
                    @if($manga->coleccion_id !== null )
                        <p class="mb-1 mt-1 text-center">
                            <a class="btn btn-link m-0 p-1 small"
                               @if(isset($zona) && $zona !== 'coleccion')
                                   href="{{ route('coleccion.index', ['id' => $manga->coleccion_id]) }}"
                                @endif
                            >
                                <span class="text-uppercase @if ($manga->tipo == 'editado') text-gris @endif">{{ $manga->tituloColeccion }}@if(!empty($manga->numero)) - @if($manga->numeroUnico)Tomo único @else#{{ $manga->numero }}@endif @endif</span>
                            </a>
                        </p>
                    @else
                        <p class="mb-1 mt-1 text-center">
                            <a class="btn btn-link m-0 p-1 small" href="{{ route('usuario.libros.index') }}">
                                {{ $manga->tituloColeccion }}
                            </a>
                        </p>
                    @endif
                @endif
            </div>
        </div>
        @if (!isset($zona) || $zona !== 'resumen')
            <div class="row mt-auto">
                @if(auth()->user() && ($manga->tipo == 'editado' || $manga->tipo == 'preparacion' || $manga->tipo == 'no_editado'))
                    @if($manga->estado_lectura == \App\Http\Helpers\LecturaHelper::ESTADO_LEYENDO && $zona !== 'coleccion')
                        <div class="col-md-12">

                            <div class="px-1 py-0 position-relative">
                                @include('partials.progress-bars.default-progress-bar', [
                                   'porcentaje' =>  $manga->paginas_totales > 0 ? round(($manga->paginas_leidas / $manga->paginas_totales) * 100, 2) : 0 ,
                                   'id' => ''
                               ])
<!--                                <div class="progress-new-bar my-0 text-center">
                                    <div class="progress-new"
                                         data-percent="{{ $manga->paginas_totales > 0 ? round(($manga->paginas_leidas / $manga->paginas_totales) * 100, 2) : 0 }}"
                                         data-color="@if($manga->paginas_totales > 0 ? round(($manga->paginas_leidas / $manga->paginas_totales) * 100, 2) : 0 < 100) orange @else green @endif">
                                    </div>
                                </div>
                                <div class="progress-new-text px-3">{{ $manga->paginas_totales > 0 ? round(($manga->paginas_leidas / $manga->paginas_totales) * 100, 2) : 0 }}%</div>-->
                            </div>
                        </div>
                    @endif
                    @if (!isset($zona) || ($zona !== 'buscados' && $zona !== 'resumen'))
                        <div class="col-md-12 text-center">
                            <div class="dropdown">
                                @php
                                    switch($manga->estado_lectura){
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

                                <button class="btn-dropdown-lectura btn px-2 mx-0 btn-sm py-1 {{ $estiloBoton }} dropdown-toggle" type="button" id="dropdownMenuButton_lectura_{{ $manga->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $textoBoton }}</button>
                                <button data-action="{{ route('lectura.cambiarPaginasLeidas', ['tipoLectura' => $manga->tipoLectura]) }}" data-tipo-lectura="{{ $manga->tipoLectura }}" data-id-item="{{$manga->id}}" data-paginas-totales="{{$manga->paginas_totales}}" data-paginas-leidas="{{ $manga->paginas_leidas }}" data-item-name="{{ $manga->tituloColeccion.(isset($manga->numero) ? ' - #'.$manga->numero : '') }}" title="Registro de lectura" @if (isset($zona) && $zona == 'lectura') style="font-size: 0.7rem" @endif class="btn btn-sm btn-info m-0 py-1 px-2 btn-cambiar-paginas-leidas" ><i class="fas fa-book-reader"></i></button>
                                @if($zona == 'coleccion' && $manga->tipo == 'editado')
                                    <button
                                        data-tipo="comic"
                                        data-tengo="{{$manga->tengo}}"
                                        data-direccion="{{$manga->prestamo_direccion}}"
                                        data-persona="{{$manga->prestamo_persona}}"
                                        data-fecha-prestamo="{{$manga->prestamo_fecha}}"
                                        data-card-id="card_{{$manga->id}}"
                                        data-item-id="{{$manga->id}}"  title="Prestamo" class="btn btn-sm @if($manga->prestamo_direccion != '') btn-warning @else btn-outline-warning @endif m-0 py-1 px-2 btn-prestar" >
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </button>
                                @endif
                                <div class="dropdown-menu dropdown-lectura" aria-labelledby="dropdownMenuButton_lectura_{{ $manga->id }}">
                                    <form action="@if($manga->tipoLectura == 'manga') {{ route("lectura.store") }} @else {{ route("usuario.libros.cambiarEstado") }} @endif" method="post" class="form-lectura mb-0">
                                        @csrf
                                        <button type="button" data-accion="no leido" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">No leido</button>
                                        <button type="button" data-accion="leyendo" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">Leyendo...</button>
                                        <button type="button" data-accion="leido" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">Leido</button>
                                        <button type="button" data-accion="quiero leer" class="py-1 w-75 btn-lectura dropdown-item" role="button" href="">Quiero leer</button>
                                        <input type="hidden" name="accion" value="no_leido">
                                        @if($manga->tipoLectura == 'manga')
                                            <input type="hidden" name="IdComic" value="{{ $manga->id }}">
                                            <input type="hidden" name="IdColeccion" value="{{ $manga->coleccion_id }}">
                                        @else
                                            <input type="hidden" name="IdLibro" value="{{ $manga->id }}">
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!isset($zona) || ($zona !== 'lectura' &&  $zona !== 'resumen' && $zona !== 'welcome'))
                        <div class="col-md-12 text-center">
                            @if((!isset($zona) || $zona !== 'buscados') && $manga->tipo == 'editado')
                                <form class="comic-add-form d-inline form_add_{{$manga->id}}" data-clase="form_add_{{$manga->id}}" action="{{ route('comic.store') }}" method="post" data-manga-id="{{$manga->id}}">
                                    @csrf
                                    @if($manga->tengo == 1)
                                        <button class="btn-store btn btn-sm w-50  btn-success eliminar-comic-button"  type="submit">
                                                <i class="fas md-18 fa-check"></i>
                                        </button>
                                        <input class="accion" type="hidden" name="accion" value="eliminar">
                                    @else
                                        <button class="btn-store btn py-1 btn-sm btn-secondary agregar-comic-button"  type="submit">
                                            <i class="fas md-18 fa-plus"></i>
                                        </button>
                                        <input class="accion" type="hidden" name="accion" value="agregar">
                                    @endif
                                    <input type="hidden" name="IdColeccion" value="{{ $manga->coleccion_id }}">
                                    <input type="hidden" name="IdComic" value="{{ $manga->id }}">
                                </form>
                            @endif
                            <form data-clase="form_favorite_{{$manga->id}}" class="form_favorite_{{$manga->id}} comic-favorite-form @if($manga->tengo == 1) d-none @else d-inline @endif"  action="{{ route('comic.store') }}" method="post" data-manga-id="{{$manga->id}}" id="form_favorito_{{$manga->id}}">
                                @csrf
                                <button class="btn btn-sm btn-secondary py-1 px-2 favorite-comic-button" type="submit">
                                @if($manga->tengo == 2)
                                    <i class="text-success fas md-18 fa-star quiero-icon"></i>
                                    <input class="accion" type="hidden" name="accion" value="no_quiero">
                                @else
                                    <i class="text-success far md-18 fa-star quiero-icon"></i>
                                    <input class="accion" type="hidden" name="accion" value="quiero">
                                @endif
                                </button>
                                <input type="hidden" name="IdColeccion" value="{{ $manga->coleccion_id }}">
                                <input type="hidden" name="IdComic" value="{{ $manga->id }}">
                            </form>
                        </div>
                    @endif
                {{--@elseif($manga->tipo == 'preparacion')
                    <div class="col-md-12">
                        <p class="mb-0 text-center font-weight-bold py-1">[EN PREPARACION]</p>
                    </div>--}}
               {{-- @elseif($manga->tipo == 'no_editado')
                    <div class="col-md-12">
                        <p class="mb-0 text-center text-muted font-weight-bold py-1">[NO EDITADO]</p>
                    </div>--}}
               @endif
            </div>
        @endif
    </div>
</div>




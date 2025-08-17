@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
    <style>
        .nav-link.active{
            background-color: #3d923d !important;
        }
    </style>
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
        <div class="col-md-12">
            <h3 class="text-uppercase text-muted">Mis lecturas</h3>
            <hr class="border-top text-muted">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 col-md-6">
            <ul class="nav nav-pills nav-pills-icons px-0 mb-2">
                <li class="nav-item m-0">
                    <a class="nav-link @if(empty($estado) || $estado == 'leyendo') bg-warning text-dark @endif" href="{{ route('usuario.lectura.index', ['estado' => 'leyendo']) }}">
                        @movile
                            <strong>({{$numeroComics['nComicsLeyendo']}})</strong>Leyendo
                        @else
                            <i class="material-icons-outlined">auto_stories</i>
                            <strong>({{$numeroComics['nComicsLeyendo']}})</strong><br>Leyendo...
                        @endmovile
                    </a>
                </li>
                <li class="nav-item m-0">
                    <a class="nav-link @if(!empty($estado) && $estado == 'leidos') bg-success text-light @endif "  href="{{ route('usuario.lectura.index', ['estado' => 'leidos']) }}">
                        @movile
                            <strong>({{$numeroComics['nComicsLeidos']}})</strong>Leídos
                        @else
                            <i class="fas fa-book"></i>
                            <strong>({{$numeroComics['nComicsLeidos']}})</strong><br>Leídos...
                        @endmovile
                    </a>
                </li>
                <li class="nav-item m-0">
                    <a class="nav-link @if(!empty($estado) && $estado == 'quiero-leer') bg-info text-light @endif "  href="{{ route('usuario.lectura.index', ['estado' => 'quiero-leer']) }}">
                        @movile
                            <strong>({{$numeroComics['nComicsQuieroLeer']}})</strong>Quiero leer
                        @else
                            <i class="material-icons-outlined">bookmarks</i>
                            <strong>({{$numeroComics['nComicsQuieroLeer']}})</strong><br>Quiero leer...
                        @endmovile
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-12 col-md-3 text-left text-md-right align-content-end d-flex">
            <form action="{{ \Illuminate\Support\Facades\Request::url() }}" method="post" class="w-100 @movile mr-auto @else ml-auto @endmovile mt-auto mb-3">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                          <i class="material-icons">search</i>
                      </span>
                    </div>
                    <input class="form-control form-control-lg buscador" type="text" name="buscar" placeholder="Buscar mangas..." value="@if(!empty($request['buscar'])) {{ $request['buscar'] }} @endif">
                </div>
            </form>
        </div>
        <div class="col-12 col-md-3 text-left text-md-right align-content-end d-flex">
            <div class="mt-auto @movile mr-auto @else ml-auto @endmovile">
                @include('partials.acciones-globales.acciones-globales', ['mostrar' => ['lectura']])
            </div>
        </div>
        <div class="col-12 col-md-12 mt-4">
            <div class="row">
                @forelse($comics as $manga)
                    @include('partials.cards.comic_card', ['manga'=>$manga, 'zona'=> 'lectura', 'elementosPorFila' => 6])
                @empty
                    <div class="col-md-12">
                        @if(!empty($request['buscar']))
                            <div class="alert alert-info">No se ha encontrado ningún manga/libro con la búsqueda <i>"{{ $request['buscar'] }}"</i>.</div>
                        @elseif(isset($estado) && $estado == 'quiero-leer')
                            <div class="alert alert-warning">No has agregado ningún manga/libro a la lista de futuras lecturas. Para agregar alguno a esta lista tan solo debes marcar la opción "quiero leer" que aparece en cada manga editado.</div>
                        @elseif(isset($estado) && $estado == 'leidos')
                            <div class="alert alert-warning">No has agregado ningún manga/libro a la lista de leídos. Para agregar alguno a esta lista tan solo debes marcar la opción "leído" que aparece en cada manga editado.</div>
                        @else
                            <div class="alert alert-warning">No has agregado ningún manga/libro a la lista de mangas que estás leyendo actualmente. Para agregar alguno a esta lista tan solo debes marcar la opción "leyendo" que aparece en cada manga editado.</div>
                        @endif
                    </div>
                @endforelse
            </div>
            {{ $comics->links() }}
        </div>
    </div>

@endsection

@section("scripts")
    {{--<!-- Gestion Mangas -->--}}
    <script src="{{ asset('js/gestion-mangas.js') }}" type="text/javascript"></script>
    {{--<!-- Filtros -->--}}
    <script src="{{ asset('js/filtros-items_v2.js?v=2') }}" type="text/javascript"></script>
    {{--<!-- Carga perezosa de imagenes -->--}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
    <script>
        $(function() {
            $('.carga-perezosa').Lazy({
                effect: 'fadeIn',
                visibleOnly: true,
                onError: function(element) {
                    console.log('error loading ' + element.data('src'));
                }
            });
        });
    </script>
    <script>
        //Barras de progreso
        $(document).ready(function(){
            $(".progress-new-bar").ProgressBar();
            actualizarPaginasLeidas();
            confirmarActualizarPaginasLeidas();
        });
    </script>
@endsection


@section("modals")
    @include('partials.messages.modal_registro_lectura')
    @include('partials.messages.modal_detalles_item')
@endsection

<div class="dropdown mb-1 d-inline">
    <button class="btn btn-outline-secondary text-muted px-2 py-2 dropdown-toggle" type="button" id="dropdownMenuButton_web" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-sort-amount-down-alt"></i> Acciones todos...
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_web">
        @if(!isset($mostrar) || in_array('posesion', $mostrar))
            <form class="accion-seleccionados p-0 m-0" method="POST" action="{{ route("comic.store.seleccion") }}" id="agregar-seleccionados-form">
                @csrf
                <button type="submit" class="dropdown-item btn-agregar-grupo">Agregar todos a la colección...</button>
                <input type="hidden" name="IdColeccion" value="{{ $datosColeccion->id  }}">
                @foreach ($comics as $manga)
                    <input type="hidden" name='IdsComics[]' value="{{ $manga->id }}">
                @endforeach
            </form>
            <form class="accion-seleccionados p-0 m-0" method="POST" action="{{ route("comic.delete.seleccion") }}" id="eliminar-seleccionados-form">
                @csrf
                <button type="submit" class="dropdown-item btn-eliminar-grupo">Eliminar todos de la colección...</button>
                <input type="hidden" name="IdColeccion" value="{{ $datosColeccion->id }}">
                @foreach ($comics as $manga)
                    <input type="hidden" id="item-delete_{{ $manga->id }}" name='IdsComics[]' value="{{ $manga->id }}">
                @endforeach
            </form>
            <hr class="text-light my-0">
        @endif
        @if(!isset($mostrar) || in_array('buscados', $mostrar))
            <form class="accion-seleccionados p-0 m-0" method="POST" action="{{ route("comic.store.favoritos.seleccion") }}" id="agregar-favoritos-seleccionados-form">
                @csrf
                <button type="submit" class="dropdown-item btn-favorito-grupo">Agregar todos a "buscados"...</button>
                @if(isset($datosColeccion->id))
                    <input type="hidden" name="IdColeccion" value="{{ $datosColeccion->id  }}">
                @endif
                @foreach ($comics as $manga)
                    <input type="hidden" @if($manga->tengo == \App\Http\Helpers\UsuarioComicHelper::TENGO) disabled @endif class='item' id="item-favorito_agregar_{{ $manga->id }}" name='IdsComics[]' value="{{ $manga->id }}">
                @endforeach
            </form>
            <form class="accion-seleccionados p-0 m-0" method="POST" action="{{ route("comic.delete.favoritos.seleccion") }}" id="eliminar-favoritos-seleccionados-form">
                @csrf
                <button type="submit" class="dropdown-item btn-favorito-grupo">Eliminar todos de "buscados"...</button>
                @if(isset($datosColeccion->id))
                    <input type="hidden" name="IdColeccion" value="{{ $datosColeccion->id  }}">
                @endif
                @foreach ($comics as $manga)
                    <input type="hidden" @if($manga->tengo == \App\Http\Helpers\UsuarioComicHelper::TENGO) disabled @endif class='item' id="item-favorito_eliminar_{{ $manga->id }}" name='IdsComics[]' value="{{ $manga->id }}">
                @endforeach
            </form>
            <hr class="text-light my-0">
        @endif
        @if(!isset($mostrar) || in_array('lectura', $mostrar))
            <form class="accion-seleccionados p-0 m-0" method="POST" action="{{ route("lectura.store.seleccion") }}" id="form-lectura-todos-leidos">
                @csrf
                <button type="submit" class="dropdown-item btn-favorito-grupo">Marcar todos como leídos...</button>
                @if(isset($datosColeccion->id))
                    <input type="hidden" name="IdColeccion" value="{{ $datosColeccion->id  }}">
                @endif
                @if(isset($estado))
                    <input type="hidden" name="estadoActual" value="{{ $estado  }}">
                @endif
                <input type="hidden" name="estado" value="{{ \App\Http\Helpers\LecturaHelper::ESTADO_LEIDO }}">
                {{-- @foreach ($comics as $manga)
                     <input type="hidden" class='item' id="item-favorito_eliminar_{{ $manga->id }}" name='IdsComics[]' value="{{ $manga->id }}">
                 @endforeach--}}
             </form>
            <form class="accion-seleccionados p-0 m-0" method="POST" action="{{ route("lectura.store.seleccion") }}" id="form-lectura-todos-quiero-leer">
                @csrf
                <button type="submit" class="dropdown-item btn-favorito-grupo">Marcar todos como quiero leer...</button>
                @if(isset($datosColeccion->id))
                    <input type="hidden" name="IdColeccion" value="{{ $datosColeccion->id  }}">
                @endif
                @if(isset($estado))
                    <input type="hidden" name="estadoActual" value="{{ $estado  }}">
                @endif
                <input type="hidden" name="estado" value="{{ \App\Http\Helpers\LecturaHelper::ESTADO_QUIERO_LEER }}">
                {{-- @foreach ($comics as $manga)
                     <input type="hidden" class='item' id="item-favorito_eliminar_{{ $manga->id }}" name='IdsComics[]' value="{{ $manga->id }}">
                 @endforeach--}}
            </form>
             <form class="accion-seleccionados p-0 m-0" method="POST" action="{{ route("lectura.delete.seleccion") }}" id="form-lectura-todos-no-leidos">
                 @csrf
                 @method('DELETE')
                 <button type="submit" class="dropdown-item btn-favorito-grupo">Marcar todos como no leídos...</button>
                 @if(isset($datosColeccion->id))
                     <input type="hidden" name="IdColeccion" value="{{ $datosColeccion->id  }}">
                 @endif
                 @if(isset($estado))
                     <input type="hidden" name="estadoActual" value="{{ $estado  }}">
                 @endif
                 {{--@foreach ($comics as $manga)
                     <input type="hidden" class='item' id="item-favorito_eliminar_{{ $manga->id }}" name='IdsComics[]' value="{{ $manga->id }}">
                 @endforeach--}}
            </form>
        @endif
    </div>
</div>


<div class="col-md-12 px-0 collapse @movile @else show  @endmovile" id="collapseFiltros">
    <form action="{{ \Illuminate\Support\Facades\Request::url() }}" method="post">
    <h4 class="mb-1 text-uppercase text-muted">Filtros
        <!--  boton con icono para aplicar filtros -->
        <button type="submit"  class="btn btn-link p-0">
            <i class="fas pb-2 fa-filter"></i>
        </button>
    </h4>
    <input class="hip-search-input form-control form-control-lg buscador mb-4" type="text" name="buscar" placeholder="Buscar mangas..." value="@if(!empty($request['buscar'])) {{ $request['buscar'] }} @endif">
        @csrf
    <div class="btn-group-toggle">
        @if(in_array('posesion', $mostrar))
            <div class="form-check @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-posesion item-filtro form-check-input @if(isset($request['posesion']) && $request['posesion']=="item-tengo") active @endif" id="btn-filtro-tengo" data-grupo="item-grupo-posesion"  name="posesion" @if(isset($request['posesion']) && $request['posesion']=="item-tengo") checked @endif type="radio" value="item-tengo">
                    Tengo
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-posesion item-filtro form-check-input @if(isset($request['posesion']) && $request['posesion']=="item-no-tengo") active @endif" id="btn-filtro-no-tengo" data-grupo="item-grupo-posesion"  name="posesion" @if(isset($request['posesion']) && $request['posesion']=="item-no-tengo") checked @endif type="radio" value="item-no-tengo">
                    No tengo
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-posesion item-filtro form-check-input" @if(isset($request['posesion']) && $request['posesion']=="item-quiero") active @endif id="btn-filtro-quiero" data-grupo="item-grupo-posesion"  name="posesion" @if(isset($request['posesion']) && $request['posesion']=="item-quiero") checked @endif  type="radio" value="item-quiero">
                    Quiero
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                </label>
            </div>
            <hr class="text-light">
        @endif
        @if(in_array('lectura', $mostrar))
            <div class="form-check @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-leido") active @endif id="btn-filtro-leido" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-leido") checked @endif type="radio" value="item-leido">
                    Leídos
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check  @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-leyendo") active @endif id="btn-filtro-leyendo" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-leyendo") checked @endif type="radio" value="item-leyendo">
                    Leyendo
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check  @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-no-leido") active @endif id="btn-filtro-no-leido" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-no-leido") checked @endif type="radio" value="item-no-leido">
                    No leidos
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check  @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-quiero-leer") active @endif id="btn-filtro-quiero-leer" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-quiero-leer") checked @endif type="radio" value="item-quiero-leer">
                    Quiero leer
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                </label>
            </div>
            <hr class="text-light">
        @endif
        @if(in_array('tipo', $mostrar))
            <div class="form-check  @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-tipo item-filtro form-check-input" @if(isset($request['tipo']) && $request['tipo']=="item-editado") active @endif id="btn-filtro-editado" data-grupo="item-grupo-tipo" name="tipo" @if(isset($request['tipo']) && $request['tipo']=="item-editado") checked @endif type="radio" value="item-editado">
                    Editados
                    <span class="form-check-sign">
              <span class="check"></span>
            </span>
                </label>
            </div>
            <div class="form-check  @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-tipo item-filtro form-check-input" @if(isset($request['tipo']) && $request['tipo']=="item-en-preparacion") active @endif id="btn-filtro-en-preparacion" data-grupo="item-grupo-tipo" name="tipo" @if(isset($request['tipo']) && $request['tipo']=="item-en-preparacion") checked @endif type="radio" value="item-en-preparacion">
                    En preparación
                    <span class="form-check-sign">
              <span class="check"></span>
            </span>
                </label>
            </div>
            <div class="form-check  @movile form-check-inline @endmovile">
                <label class="form-check-label">
                    <input class="item-grupo-tipo item-filtro form-check-input" @if(isset($request['tipo']) && $request['tipo']=="item-no-editado") active @endif id="btn-filtro-no-editado" data-grupo="item-grupo-tipo" name="tipo" @if(isset($request['tipo']) && $request['tipo']=="item-no-editado") checked @endif type="radio" value="item-no-editado">
                    No editados
                    <span class="form-check-sign">
              <span class="check"></span>
            </span>
                </label>
            </div>
        @endif
    </div>
    </form>
</div>

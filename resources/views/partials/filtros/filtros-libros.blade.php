<div class="col-md-12 px-0 collapse @movile @else show  @endmovile" id="collapseFiltros" >
    <form action="{{ \Illuminate\Support\Facades\Request::url() }}" method="post">
        <h4 class="mb-1 text-uppercase text-muted">Filtros
            <button type="submit"  class="btn btn-link p-0">
                <i class="fas pb-2 fa-filter"></i>
            </button>
            <!-- Borrar filtros -->
<!--            <a href="{{ route('usuario.libros.index') }}" class="ml-1 btn btn-outline-light text-light p-0 px-2 small" title="Borrar filtros">
                <i class="fas fa-times"></i>
            </a>-->
        </h4>

        <input class="hip-search-input form-control form-control-lg buscador mb-4" type="text" name="buscar" placeholder="Buscar libros..." value="@if(!empty($request['buscar'])) {{ $request['buscar'] }} @endif">

            @csrf
        <div class="btn-group-toggle">
            @if(in_array('lectura', $mostrar))
                <div class="form-check @movile form-check-inline @endmovile">
                    <label class="form-check-label @movile small @endmovile ">
                        <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-leido") active @endif id="btn-filtro-leido" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-leido") checked @endif type="radio" value="item-leido">
                        Leídos
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check  @movile form-check-inline @endmovile">
                    <label class="form-check-label @movile small @endmovile ">
                        <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-leyendo") active @endif id="btn-filtro-leyendo" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-leyendo") checked @endif type="radio" value="item-leyendo">
                        Leyendo
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check  @movile form-check-inline @endmovile">
                    <label class="form-check-label @movile small @endmovile ">
                        <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-no-leido") active @endif id="btn-filtro-no-leido" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-no-leido") checked @endif type="radio" value="item-no-leido">
                        No leidos
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check  @movile form-check-inline @endmovile">
                    <label class="form-check-label @movile small @endmovile ">
                        <input class="item-grupo-lectura item-filtro form-check-input"  @if(isset($request['lectura']) && $request['lectura']=="item-quiero-leer") active @endif id="btn-filtro-quiero-leer" data-grupo="item-grupo-lectura" name="lectura" @if(isset($request['lectura']) && $request['lectura']=="item-quiero-leer") checked @endif type="radio" value="item-quiero-leer">
                        Quiero leer
                        <span class="form-check-sign">
                          <span class="check"></span>
                        </span>
                    </label>
                </div>
                <hr class="text-light">
            @endif
        </div>
    </form>
</div>

@movile
    <div class="form-group m-0 p-0">
        <input id="buscar" data-url-resultado="{{ route('coleccion.autocomplete.datosColeccion') }}" data-url-listado="{{ route('coleccion.autocomplete.listado') }}" type="text" style="z-index: 100000" class="bg-light form-control @error('buscar') is-invalid @enderror" placeholder="Buscar colección..." name="buscar" value="" required autocomplete="buscar">
        @if ($errors->has('buscar'))
            <span class="ml-5 invalid-feedback text-right" style="top:3px;right: 3px" role="alert">
                <strong>({{ $errors->first('buscar') }})</strong>
            </span>
        @endif
    </div>
@endmovile


@movile
@else
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <input id="buscar" data-url-resultado="{{ route('coleccion.autocomplete.datosColeccion') }}" data-url-listado="{{ route('coleccion.autocomplete.listado') }}" type="text" class="form-control @error('buscar') is-invalid @enderror" placeholder="Buscar colección manga online..." name="buscar" value="" required autocomplete="buscar">
            @if ($errors->has('buscar'))
                <span class="ml-5 invalid-feedback text-right position-absolute" style="top:3px;right: 3px" role="alert">
                    <strong>({{ $errors->first('buscar') }})</strong>
                </span>
            @endif
        </div>
    </div>
</div>
@endmovile


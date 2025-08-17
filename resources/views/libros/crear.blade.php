@extends('items_comun.index')

@section('zona-items')
    <div class="row mt-5">
        <div class="col-md-12 mt-2">
            <h2>Agregar un nuevo libro</h2>
        </div>
    </div>
    <form action="{{ route('usuario.libros.store') }}" method="POST" enctype="multipart/form-data" id="formLibro">
        <div class="row mt-2">
            @csrf
            <div class="col-md-6">
                <label for="titulo" class="col-form-label">Título</label>
                <div class="input-group pt-0">
                <!-- Título -->
                    <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="" required autocomplete="titulo" autofocus>
                    @error('titulo')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <!-- Título original -->
            <div class="col-md-6">
                <label for="isbn" class="col-form-label">ISBN</label>
                <div class="input-group pt-0">
                    <input id="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" value="" autocomplete="isbn" autofocus>
                    @error('imdb')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <!-- Autor -->
            <div class="col-md-6">
                <label for="autor" class="col-form-label">Autor</label>
                <div class="input-group pt-0">
                    <input id="autor" type="text" class="form-control @error('autor') is-invalid @enderror" name="autor" value="" autocomplete="autor" autofocus>
                    @error('autor')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <!-- Editorial -->
            <div class="col-md-6">
                <label for="editorial" class="col-form-label">Editorial</label>
                <div class="input-group pt-0">
                    <input id="editorial" type="text" class="form-control @error('editorial') is-invalid @enderror" name="editorial" value="" autocomplete="editorial" autofocus>
                    @error('editorial')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <!-- Inicio de lectura -->
                <label for="fecha_inicio_lectura" class="col-form-label">Inicio de lectura</label>
                <div class="input-group pt-0">
                    <input id="fecha_inicio_lectura" type="date" class="form-control @error('fecha_inicio_lectura') is-invalid @enderror" name="fecha_inicio_lectura" value="" autocomplete="fecha_inicio_lectura" autofocus>
                    @error('fecha_inicio_lectura')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <!-- Fin de lectura -->
            <div class="col-md-3">
                <label for="fecha_fin_lectura" class="col-form-label">Fin de lectura</label>
                <div class="input-group pt-0">
                    <input id="fecha_fin_lectura" type="date" class="form-control @error('fecha_fin_lectura') is-invalid @enderror" name="fecha_fin_lectura" value="" autocomplete="fecha_fin_lectura" autofocus>
                    @error('fecha_fin_lectura')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <!-- Paginas totales -->
            <div class="col-md-3">
                <label for="paginas_totales" class="col-form-label">Páginas totales</label>
                <div class="input-group pt-0">
                    <input id="paginas_totales" type="number" class="form-control @error('paginas_totales') is-invalid @enderror" name="paginas_totales" value="" autocomplete="paginas_totales" autofocus>
                    @error('paginas_totales')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <!-- Paginas leídas -->
            <div class="col-md-3">
                <label for="paginas_leidas" class="col-form-label">Páginas leídas</label>
                <div class="input-group pt-0">
                    <input id="paginas_leidas" type="number" class="form-control @error('paginas_leidas') is-invalid @enderror" name="paginas_leidas" value="" autocomplete="paginas_leidas" autofocus>
                    @error('paginas_leidas')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <!-- Sinopsis -->
            <div class="col-md-6">
                <label for="sinopsis" class="col-form-label">Sinopsis</label>
                <div class="input-group pt-0">
                    <textarea id="sinopsis" type="text"
                              class="form-control @error('sinopsis') is-invalid @enderror" style="height: auto;"
                              name="sinopsis" value="" autocomplete="sinopsis" autofocus></textarea>
                    @error('sinopsis')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label for="fecha_compra" class="col-form-label">Fecha de compra</label>
                        <div class="input-group pt-0">
                            <input id="fecha_compra" type="date" class="form-control @error('fecha_compra') is-invalid @enderror" name="fecha_compra" value="" autocomplete="fecha_compra" autofocus>
                            @error('fecha_compra')
                            <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="precio_compra" class="col-form-label">Precio compra</label>
                        <div class="input-group pt-0">
                            <input id="precio_compra" type="number" step="0.01" class="form-control @error('precio_compra') is-invalid @enderror" name="precio_compra" value="" autocomplete="precio_compra" autofocus>
                            @error('precio_compra')
                            <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="imagen" class="col-form-label">Imagen</label><br>
                        <input id="imagen" type="file" class="@error('imagen') is-invalid @enderror w-100 p-1 text-muted btn text-white bg-light" name="imagen">
                    </div>
                    <div class="col-md-12">
                        <img src="" class="img-fluid" alt="Imagen" hidden id="imagenTemporal">
                        <input type="hidden" id="urlImagenTemporal" name="urlImagenTemporal">
                        <!-- checkbox quiero leer -->
                        <!-- checkbox finalizado -->
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-2">
            <!-- Boton de guardar o resetear -->
            <div class="input-group mb-0">
                <div class="col-md-12">
                    <a href="{{ route('usuario.libros.index') }}" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    <script src="{{ asset('js/gestion-libros.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            autocompletarLibros("{{ route('usuario.libros.autocomplete') }}", "{{ route('usuario.libros.datosLibro') }}")
        });
    </script>
@endsection

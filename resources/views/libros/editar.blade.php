@extends('items_comun.index')

@section('zona-items')
    <div class="row justify-content-center">
        <div class="col-md-10 mt-2">
            <div class="row mt-5">
                <div class="col-md-12 mt-2">
                    <h2>Editar libro: {{ $libro->titulo }}</h2>
                </div>
            </div>
            <form action="{{ route('usuario.libros.update', ['libro' => $libro->id])}}" method="POST" enctype="multipart/form-data">
                <div class="row mt-2">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Título</label>
                        <div class="input-group">
                            <!-- Título -->
                            <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" required autocomplete="titulo" autofocus value="{{ old('titulo', $libro->titulo) }}">
                            @error('titulo')
                            <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Título original -->
                    <div class="col-md-6">
                        <label for="isbn" class="form-label">ISBN</label>
                        <div class="input-group ">
                            <input id="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" autocomplete="isbn" autofocus value="{{ old('isbn', $libro->isbn13) }}">
                            @error('isbn')
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
                        <label for="autor" class="form-label">Autor</label>
                        <div class="input-group">
                            <input id="autor" type="text" class="form-control @error('autor') is-invalid @enderror" name="autor" autocomplete="autor" autofocus value="{{ old('autor', $libro->autor) }}">
                            @error('autor')
                            <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Editorial -->
                    <div class="col-md-6">
                        <label for="editorial" class="form-label">Editorial</label>
                        <div class="input-group">
                            <input id="editorial" type="text" class="form-control @error('editorial') is-invalid @enderror" name="editorial" autocomplete="editorial" autofocus value="{{ old('editorial', $libro->editorial) }}">
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
                        <label for="fecha_inicio_lectura" class="form-label">Inicio de lectura</label>
                        <div class="input-group">
                            <input id="fecha_inicio_lectura" type="date" class="form-control @error('fecha_inicio_lectura') is-invalid @enderror" name="fecha_inicio_lectura" autocomplete="fecha_inicio_lectura" autofocus value="{{ old('fecha_inicio_lectura', ($libro->fecha_inicio_lectura) ? $libro->fecha_inicio_lectura->format('Y-m-d') : null) }}">
                            @error('fecha_inicio_lectura')
                            <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Fin de lectura -->
                    <div class="col-md-3">
                        <label for="fecha_fin_lectura" class="form-label">Fin de lectura</label>
                        <div class="input-group">
                            <input id="fecha_fin_lectura" type="date" class="form-control @error('fecha_fin_lectura') is-invalid @enderror" name="fecha_fin_lectura" autocomplete="fecha_fin_lectura" autofocus value="{{ old('fecha_fin_lectura', ($libro->fecha_fin_lectura) ? $libro->fecha_fin_lectura->format('Y-m-d') : null) }}">
                            @error('fecha_fin_lectura')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Paginas totales -->
                    <div class="col-md-3">
                        <label for="paginas_totales" class="form-label">Páginas totales</label>
                        <div class="input-group ">
                            <input id="paginas_totales" type="number" class="form-control @error('paginas_totales') is-invalid @enderror" name="paginas_totales" autocomplete="paginas_totales" autofocus value="{{ old('paginas_totales', $libro->paginas_totales) }}">
                            @error('paginas_totales')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Paginas leídas -->
                    <div class="col-md-3">
                        <label class="form-label">Páginas leídas</label>
                        <div class="input-group">
                            <input id="paginas_leidas" type="number" class="form-control" name="paginas_leidas" value="{{ old('paginas_leidas', $libro->paginas_leidas) }}">
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
                    <div class="col-md-6 ">
                        <label class="form-label">Sinopsis</label>
                        <div class="input-group">
                            <textarea id="sinopsis" rows="20" class="form-control form-text @error('sinopsis') is-invalid @enderror" name="sinopsis" autocomplete="sinopsis" autofocus>{{ old('sinopsis', $libro->sinopsis) }}</textarea>
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
                                    <input id="fecha_compra" type="date" class="form-control @error('fecha_compra') is-invalid @enderror" name="fecha_compra"  autocomplete="fecha_compra" value="{{ old('fecha_compra', ($libro->fecha_compra) ? $libro->fecha_compra->format('Y-m-d') : null) }}" autofocus>
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
                                    <input id="precio_compra" type="number" step="0.01"  class="form-control @error('precio_compra') is-invalid @enderror" name="precio_compra" value="{{old('precio_compra', $libro->precio_compra)}}" autocomplete="precio_compra" autofocus>
                                    @error('precio_compra')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Imagen -->
                            <div class="col-md-12">
                                <label for="imagen" class="col-form-label">Imagen</label><br>
                                <input id="imagen" type="file" class="@error('imagen') is-invalid @enderror w-100 p-1 text-muted btn text-white bg-light" name="imagen">
                            </div>
                            <!-- Imagen actual -->
                            <div class="col-md-12">
                                <label for="imagen_actual" class="col-form-label">Imagen actual</label><br>
                                <img src="{{ asset($libro->imagen) }}" alt="{{ $libro->titulo }}" class="text-right ml-auto" id="imagenTemporal">
                                <input type="hidden" id="urlImagenTemporal" name="urlImagenTemporal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <!-- checkbox quiero leer -->
                        <!-- checkbox finalizado -->
                    </div>
                </div>
                <div class="row mt-2">
                    <!-- Boton de guardar o resetear -->
                    <div class="form-group mb-0">
                        <div class="col-md-12">
                            <a href="{{ route('usuario.libros.index') }}" class="btn btn-primary text-decoration-none">Volver</a>
                            <button type="submit" class="btn btn-success">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/gestion-libros.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            autocompletarLibros("{{ route('usuario.libros.autocomplete') }}", "{{ route('usuario.libros.datosLibro') }}")
        });
    </script>
@endsection

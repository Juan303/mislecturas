<div class="modal fade" id="modal_agregar_todos_lectura" tabindex="-1" role="dialog" aria-labelledby="modal_agregar_todos_lectura" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-muted text-uppercase" id="modal_agregar_todos_lectura_titulo">Datos de adicionales</h4>
                <h5 class="modal-title text-muted" id="modal_editar_coleccion_subtitulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Fecha de compra -->
                        <div class="form-group">
                            <label for="fecha_compra" class="text-left">Fecha fin lectura</label>
                            <input id="modal_agregar_todos_lectura_fecha_fin_lectura" type="date" class="form-control" name="fecha_compra" value="" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Rango de numeros a agregar -->
                        <div class="form-group">
                            <label for="modal_agregar_todos_lectura_numero_inicial" class="text-left">Nº Inicial</label>
                            <input id="modal_agregar_todos_lectura_numero_inicial" type="number" step="1" class="form-control" name="modal_agregar_todos_lectura_numero_inicial" value="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Rango de numeros a agregar -->
                        <div class="form-group">
                            <label for="modal_agregar_todos_lectura_numero_final" class="text-left">Nº Final</label>
                            <input id="modal_agregar_todos_lectura_numero_final" type="number" step="1" class="form-control" name="modal_agregar_todos_lectura_numero_final" value="{{ $comics_publicados }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center justify-content-center">
                    <button type="button" id="modal_agregar_todos_lectura_btn_guardar" class="btn btn-success mx-1">Guardar</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
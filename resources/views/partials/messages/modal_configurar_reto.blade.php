<div class="modal fade manga-item manga-item-detalles" style="z-index: 10000" id="ModalConfigurarReto" tabindex="-1" role="dialog" aria-labelledby="ModalConfigurarRetoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="mb-0" action="" id="formRegistroConfigurarReto">
                @csrf
                <div class="modal-header">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="modal-title text-muted text-uppercase d-block p-0 w-100" id="detallesTitulo">Configurar número de libros anual:</h4>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="paginas_leidas" class="col-form-label text-md-right">Libros a leer durante el año actual</label>
                                <input id="CantidadAnual" type="number" class="form-control d-inline" name="CantidadAnual" value="" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center justify-content-start">
                    <button type="submit" class="btn btn-success mr-2">Guardar</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

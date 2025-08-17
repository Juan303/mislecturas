<div class="modal fade manga-item manga-item-detalles" id="modalRegistroLectura" tabindex="-1" role="dialog" aria-labelledby="modalRegistroLectura" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="mb-0" action="" method="post" id="formRegistroLectura">
                @csrf
                <div class="modal-header">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="modal-title text-muted text-uppercase d-block p-0 w-100" id="detallesTitulo">Registro de lectura de:</h4>
                        </div>
                        <div class="col-12">
                            <span id="tituloLibro"></span>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <div class="row mb-2">
                        <div class="col-12">
                            <!--bootstrap table-->
                            <div class="table-responsive">
                                <table class="table table-condensed table-sm p-0" id="tablaRegistrosLectura">
                                    <thead>
                                        <tr>
                                            <th class="text-left" data-formatter="fechaHoraFormatter" data-field="created_at">Fecha / Hora</th>
                                            <th class="text-right" data-field="PaginasLeidas">Páginas leídas</th>
                                            @movile
                                            @else
                                                <th class="text-right" data-formatter="porcentajePaginasFormatter">Porcentaje</th>
                                            @endmovile
                                            <th class="text-right" data-formatter="incrementoPaginasFormatter">Incremento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Barra de progreso -->
                    <div class="row">
                        <div class="col-12">
                            Progreso de lectura:
                        </div>
                        <div class="col-md-12">
                            <div class="progress-new-bar my-0 text-center">
                                <div class="progress-new"
                                     data-percent=""
                                     data-color="">
                                </div>
                            </div>
                            <div class="progress-new-text px-3">

                            </div>

<!--                            <div class="progress-new-bar mt-1 mb-1">
                                <div class="progress-new text-center"
                                     data-percent=""
                                     data-color="green">
                                    <span></span>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="row mt-0">
                        <div class="col-4">
                            <input type="hidden" name="idItem" id="idItem" value="">
                            <div class="form-group">
                                <label for="paginas_leidas" class="col-form-label text-md-right">Páginas leídas</label>
                                <input id="paginasLeidas" type="number" class="form-control d-inline" name="paginasLeidas" value="" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="paginas_totales" class="col-form-label text-md-right">% leído</label>
                                <input id="porcentajePaginas"
                                       type="number" min="0" max="100" step="0.01" class="form-control d-inline" name="porcentajePaginas" value="">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="paginas_totales" class="col-form-label text-md-right">Páginas totales</label>
                                <input disabled id="paginasTotales" type="number" class="form-control d-inline" name="paginasTotales" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-0">
                        <div class="col-12">
                            <input type="range" class="form-control-range" id="porcentajePaginasRange" min="0" max="100" step="1" value="0">
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

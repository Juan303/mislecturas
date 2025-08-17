<div class="modal fade" id="modalDetalleEstadisticas" tabindex="-1" role="dialog" aria-labelledby="modalDetalleEstadisticas" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="d-inline modal-title text-muted text-uppercase" id="modalDetalleEstadisticasTitulo">
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap table -->
                <div class="table-responsive">
                    <table class="table table-sm table-bordered small" id="modalDetalleEstadisticasTabla">
                        <thead>
                            <tr>
                                <th data-field="fecha_fin_lectura" data-formatter="fechaFormatter" data-sortable="true">Fecha</th>
                                <th data-field="nombre" data-formatter="nombreFormatter" data-sortable="true">Nombre</th>
                                <th data-field="tipo" data-formatter="tipoFormatter" data-sortable="true">Tipo</th>
                                <th data-field="precio" class="text-right" data-sortable="true" data-formatter="monedaFormatterWith2Decimals" data-footer-formatter="sumaMonedaFooterFormatterWith2Decimals">Precio</th>
                                <th data-field="precioD" class="text-right" data-sortable="true" data-formatter="monedaFormatterWith2Decimals" data-footer-formatter="sumaMonedaFooterFormatterWith2Decimals">Precio d.</th>
                                <th data-field="paginas_totales" class="text-right" data-footer-formatter="sumaNumberFooterFormatterWith0Decimals">Nº páginas</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="modal-footer text-center justify-content-center">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

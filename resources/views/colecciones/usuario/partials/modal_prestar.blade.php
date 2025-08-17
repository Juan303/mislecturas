<div class="modal fade" id="modal_prestar" tabindex="-1" role="dialog" aria-labelledby="modal_prestar" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-muted text-uppercase" id="modal_prestar_titulo">Gestion prestámos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <!-- tabs -->
                        <div class="modal_prestar_bloque" id="modal_prestar_a">
                            <!-- Formulario para prestar en linea -->
                            <div class="input-group" id="modal_prestar_a_form">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-group"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="persona_a_la_que_prestas" placeholder="Persona a la que prestas">
                            </div>
                           
                        </div>
                        <div class="modal_prestar_bloque" id="modal_prestado_por">
                            <div class="input-group" id="modal_prestado_por_form">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-group"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="persona_que_te_lo_presta" placeholder="Persona que te presta">
                            </div>
                            
                        </div>
                        <div id="datos_prestamo">
                            <div class="row">
                                <div class="col-7">
                                    <p id="datos_prestamo_texto" class="text-muted py-2"></p>
                                </div>
                                <div class="col-5 text-right">
                                    <button type="button" class="btn btn-info btn-sm py-2" id="devolver_prestamo_btn">
                                        <i class="fa fa-undo"></i>
                                        Devolver
                                    </button>
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-info" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Cerrar
                </button>
                <button type="button" class="btn btn-success" id="modal_prestar_btn_guardar">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>

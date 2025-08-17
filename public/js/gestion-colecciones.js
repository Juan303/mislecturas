$(document).ready(function (){
    $(".btn-eliminar-coleccion").click(function(e){
        $("#confirm_delete .modal-body p").text('Se va a eliminar la coleccion "'+ $(this).data("item-name") +'" de su biblioteca. ¿Desea continuar?');
        $("#confirm_delete form").attr('action', ($(this).data('url')));
        $("#confirm_delete #item_id").val($(this).data("item-id"));
        $("#confirm_delete #item_nombre").val($(this).data("item-name"));
        $("#confirm_delete").modal("show");
    });

    $(".btn-info-coleccion").click(function(e){
        e.preventDefault();
        $("#modal_info_coleccion").data('id', $(this).data("item-id"));
        var datosColeccion = $(this).data("datos-coleccion");
        $("#modal_info_coleccion_titulo").text($(this).data("item-name"));
        $("#modal_info_coleccion_tituloOriginal").text(datosColeccion.coleccion.tituloOriginal);
        $("#modal_info_coleccion_guion").text(datosColeccion.coleccion.datosColeccion.guion);
        $("#modal_info_coleccion_dibujo").text(datosColeccion.coleccion.datosColeccion.dibujo);
        $("#modal_info_coleccion_traduccion").text(datosColeccion.coleccion.datosColeccion.traduccion);
        $("#modal_info_coleccion_editorialJaponesa").text(datosColeccion.coleccion.datosColeccion.editorialJaponesa);
        $("#modal_info_coleccion_editorialEspanola").text(datosColeccion.coleccion.datosColeccion.editorialEspanola);
        $("#modal_info_coleccion_tipo").text(datosColeccion.coleccion.datosColeccion.tipo);
        $("#modal_info_coleccion_formato").text(datosColeccion.coleccion.datosColeccion.formato);
        $("#modal_info_coleccion_sentido").text(datosColeccion.coleccion.datosColeccion.sentido);
        $("#modal_info_coleccion_numerosJapones").text(datosColeccion.coleccion.datosColeccion.numerosJapones);
        $("#modal_info_coleccion_numerosEspanol").text(datosColeccion.coleccion.datosColeccion.numerosEspanol);
        $("#modal_info_coleccion_sinopsis").html(datosColeccion.coleccion.sinopsis);
        $("#modal_info_coleccion #modal_editar_coleccion_subtitulo").val($(this).data("item-name"));
        $("#modal_info_coleccion").modal("show");
    });

    $("#novedadesColeccionesBtn").click(function(e){
        e.preventDefault();
        $("#novedadesColecciones").modal("show");
    });

});

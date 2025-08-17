$(document).ready(function() {
    //marcar como leidos/leyendo/quieroLeer de manera individual
    $(".btn-lectura").click(function () {
        $(this).closest(".form-lectura").find("input[name='accion']").val($(this).data("accion"));
        $(this).closest(".form-lectura").submit();
    })
    $(".form-lectura").submit(function (e) {

        e.preventDefault();
        var item = $(this).closest('.manga-item');
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function (data) {
                $(".dropdown-lectura").removeClass('show');
                var botonDropdownLectura = $("#dropdownMenuButton_lectura_" + data.idLibro);
                botonDropdownLectura.text(data.accion);
                botonDropdownLectura.removeClass('btn-success btn-warning btn-info btn-outline-secondary');
                item.removeClass('item-leido item-leyendo item-no-leido item-quiero-leer')
                if (data.accion == 'leyendo') {
                    botonDropdownLectura.addClass('btn-warning');
                    item.addClass('item-leyendo');
                } else if (data.accion == 'leido') {
                    botonDropdownLectura.addClass('btn-success');
                    item.addClass('item-leido');
                } else if (data.accion == 'quiero leer') {
                    botonDropdownLectura.addClass('btn-info');
                    item.addClass('item-quiero-leer');
                } else {
                    botonDropdownLectura.addClass('btn-outline-secondary');
                    item.addClass('item-no-leido');
                }
                actualizarDatosLecturaModal("#modal_detalles_libro_" + data.idComic, data.datosLectura);
                actualizarDatosLecturaModal("#modal_detalles_comic_" + data.idComic, data.datosLectura);
                actualizarDatosLecturaCard("#card_" + data.idComic, data.datosLectura);
            }
        });
    });
});

function actualizarDatosLecturaModal(selector, datosLectura = null){
    var detallesComic = $(selector);
    detallesComic.find('.detalle-libro-quiero-leer, .detalle-libro-no-leido, .detalles-lectura-libro').addClass('d-none');
    switch(parseInt(datosLectura.estado_lectura)){
        case 1: //leyendo
        case 2: //leido
            detallesComic.find('.detalles-lectura-libro').removeClass('d-none')
            detallesComic.find('.detallesPaginasLeidas').text(datosLectura.paginas_leidas);
            detallesComic.find('.detallesInicioLectura').text((datosLectura.fecha_inicio_lectura !== null)?datosLectura.fecha_inicio_lectura:"-");
            detallesComic.find('.detallesFinLectura').text((datosLectura.fecha_fin_lectura !== null)?datosLectura.fecha_fin_lectura:"-");
            break;
        case 3: //quiero leer
            detallesComic.find('.detalle-libro-quiero-leer').removeClass('d-none');
            break;
        default: //no leido
            detallesComic.find('.detalle-libro-no-leido').removeClass('d-none');

    }
}

function actualizarDatosLecturaCard(selector, datosLectura = null){
    var detallesLibro = $(selector);
    detallesLibro.find('.btn-cambiar-paginas-leidas').attr('data-paginas-leidas', datosLectura.paginas_leidas);
    switch (parseInt(datosLectura.estado_lectura)) {
        case 1: //leyendo
            detallesLibro.find('.btn-dropdown-lectura').removeClass('btn-outline-secondary btn-info btn-success').addClass('btn-warning');
            detallesLibro.find('.btn-dropdown-lectura').text('Leyendo');
            break;
        case 2: //leido
            detallesLibro.find('.btn-dropdown-lectura').removeClass('btn-outline-secondary btn-warning btn-info').addClass('btn-success');
            detallesLibro.find('.btn-dropdown-lectura').text('Leído');
            break;
        case 3: //quiero leer
            detallesLibro.find('.btn-dropdown-lectura').removeClass('btn-outline-secondary btn-warning btn-success').addClass('btn-info');
            detallesLibro.find('.btn-dropdown-lectura').text('Quiero leer');
            break;
        default: //no leido
            detallesLibro.find('.btn-dropdown-lectura').removeClass('btn-info btn-warning btn-success').addClass('btn-outline-secondary');
            detallesLibro.find('.btn-dropdown-lectura').text('No leído');
    }
    var porcentaje = (parseInt(datosLectura.paginas_leidas)/parseInt(datosLectura.paginas_totales))*100;
    detallesLibro.find(".progress-new-bar div").attr("data-percent", porcentaje.toFixed(2));
    detallesLibro.find(".progress-new span").text(porcentaje.toFixed(2)+"%");
    $(".progress-new-bar").ProgressBar();

}



$(document).ready(function(){
    $("#porcentajePaginasRange").on('input', function(){
        var porcentaje = parseFloat($(this).val()).toFixed(2);
        $("#paginasLeidas").val(Math.round($("#paginasTotales").val() * porcentaje / 100));
        $("#porcentajePaginas").val(porcentaje);
    });
    $("#paginasLeidas").on('input', function(){
        var porcentaje = parseFloat($(this).val() * 100 / $("#paginasTotales").val()).toFixed(2);
        $("#porcentajePaginasRange").val(porcentaje);
        $("#porcentajePaginas").val(porcentaje);
    });
    $("#porcentajePaginas").on('input', function(){
        var porcentaje = parseFloat($(this).val()).toFixed(2);
        $("#porcentajePaginasRange").val(porcentaje);
        $("#paginasLeidas").val(Math.round($("#paginasTotales").val() * porcentaje / 100));
    });
});
function accionesLectura(){
    //marcar como leidos/leyendo/quieroLeer de manera individual
    $(".btn-lectura").click(function (){
        $(this).closest(".form-lectura").find("input[name='accion']").val($(this).data("accion"));
        $(this).closest(".form-lectura").submit();
    })
    $(".form-lectura").submit(function(e){
        e.preventDefault();
        var item = $(this).closest('.manga-item');
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function(data) {
                $(".dropdown-lectura").removeClass('show');
                var botonDropdownLectura = $("#dropdownMenuButton_lectura_" + data.idComic);
                botonDropdownLectura.text(data.accion);
                botonDropdownLectura.removeClass('btn-success btn-warning btn-info btn-outline-secondary');
                item.removeClass('item-leido item-leyendo item-no-leido item-quiero-leer')
                if (data.accion == 'leyendo'){
                    botonDropdownLectura.addClass('btn-warning');
                    item.addClass('item-leyendo');
                }
                else if(data.accion == 'leido'){
                    botonDropdownLectura.addClass('btn-success');
                    item.addClass('item-leido');
                }
                else if(data.accion == 'quiero leer'){
                    botonDropdownLectura.addClass('btn-info');
                    item.addClass('item-quiero-leer');
                }
                else{
                    botonDropdownLectura.addClass('btn-outline-secondary');
                    item.addClass('item-no-leido');
                }
                actualizarDatosLecturaCard("#card_" + data.idComic, data.datosLectura);
                alertSuccessTopEnd('Estado de lectura actualizado')
            }
        });
    });
    //marcar todos como leidos / quiero leer
    $("#form-lectura-todos-leidos, #form-lectura-todos-quiero-leer").submit(function(e){
        e.preventDefault();
        //Abrimos el modal "modal_agregar_todos_compra" para poder seleccionar una fecha de compra
        $("#modal_agregar_todos_lectura").modal('show');
        $("#modal_agregar_todos_lectura").data('datos-serializados', $(this).serialize());
        $("#modal_agregar_todos_lectura").data('action', $(this).attr("action"));
        //fecha actual en formato DD/MM/YYYY usando moment.js
        var fecha_actual = moment().format('YYYY-MM-DD');
        $("#modal_agregar_todos_lectura_fecha_fin_lectura").val(fecha_actual);
        $("#modal_agregar_todos_lectura").data('method', $(this).attr("method"));
    });

    $("#modal_agregar_todos_lectura_btn_guardar").click(function(){
        var items = $('.manga-item');
        $.ajax({
            url: $("#modal_agregar_todos_lectura").data('action'),
            data: $("#modal_agregar_todos_lectura").data('datos-serializados') + "&fecha_fin_lectura=" + $("#modal_agregar_todos_lectura_fecha_fin_lectura").val() + "&numero_inicial=" + $("#modal_agregar_todos_lectura_numero_inicial").val() + "&numero_final=" + $("#modal_agregar_todos_lectura_numero_final").val(),
            method: $("#modal_agregar_todos_lectura").data('method'),
            error: function(data){
                alertErrorTopEnd('Error al actualizar los estados de lectura');
            },
            success: function(data) {
                $(".dropdown-lectura").removeClass('show');
                if(data.idsCambiados){
                    data.idsCambiados.forEach(function(id){
                        var botonDropdownLectura = $("#dropdownMenuButton_lectura_" + id);
                        var item = $("#item_" + id);
                        botonDropdownLectura.text(data.estado);
                        botonDropdownLectura.removeClass('btn-success btn-warning btn-outline-secondary');
                        item.removeClass('item-leido item-leyendo item-no-leido item-quiero-leer');
                        if(data.estado == 'leido') {
                            botonDropdownLectura.addClass('btn-success');
                            item.addClass('item-leido');
                        }
                        else if(data.estado == 'quiero leer'){
                            botonDropdownLectura.addClass('btn-info');
                            item.addClass('item-quiero-leer');
                        }
                        else{
                            botonDropdownLectura.addClass('btn-outline-secondary');
                            item.addClass('item-no-leido');
                        }
                    });
                }
                // var botonesDropdownLectura = $(".btn-dropdown-lectura");
                // botonesDropdownLectura.text(data.estado);
                // botonesDropdownLectura.removeClass('btn-success btn-warning btn-outline-secondary');
                // items.removeClass('item-leido item-leyendo item-no-leido quiero-leer')
                // if(data.estado == 'leido') {
                //     botonesDropdownLectura.addClass('btn-success');
                //     items.addClass('item-leido');
                // }
                // else if(data.estado == 'quiero leer'){
                //     botonesDropdownLectura.addClass('btn-info');
                //     items.addClass('item-quiero-leer');
                // }
                alertSuccessTopEnd('Estados de lectura actualizados');

            },
            complete: function(){
                $("#modal_agregar_todos_lectura").modal('hide');
            }

        });
    });
    //marcar todos como NO leidos
    $("#form-lectura-todos-no-leidos").submit(function(e){
        e.preventDefault();
        var items = $('.manga-item');
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function(data) {
                console.log(data);
                $(".dropdown-lectura").removeClass('show');
                var botonesDropdownLectura = $(".btn-dropdown-lectura");
                botonesDropdownLectura.text('no leido');
                botonesDropdownLectura.removeClass('btn-success btn-warning btn-outline-secondary');
                items.removeClass('item-leido item-leyendo item-no-leido')
                botonesDropdownLectura.addClass('btn-outline-secondary');
                items.addClass('item-no-leido');
                alertSuccessTopEnd('Estados de lectura actualizados')
            }
        });
    });
    //Mostrar modal de detalles de un item
    $(".btn-detalles-item").click(function(){
        loadDatosItem($(this).data("id-item"), $(this).data("tipo-lectura"));
    });
}

function actualizarPaginasLeidas(){
    $(".btn-cambiar-paginas-leidas").click(function(){
        //Reseteamos el formulario
        $("#formRegistroLectura")[0].reset();
        loadDatosHistoricos($(this).data("id-item"), $(this).data("tipo-lectura"));
        var idItem = $(this).data("id-item");
        var paginasTotales = $(this).data("paginas-totales");
        var nombre = $(this).data("item-name");
        var modal = $("#modalRegistroLectura");
        modal.find("#idItem").val(idItem);
        modal.find("#paginasTotales").val(paginasTotales);
        modal.find("#tituloLibro").html(nombre);
        modal.find("form").attr("action", $(this).data("action"));
        modal.modal('show');
    })
}
function confirmarActualizarPaginasLeidas(){
    $("#formRegistroLectura").on('submit', function(e){
        e.preventDefault();
        //El numero de paginas leidas no puede ser mayor al total de paginas
        var paginasLeidas = parseInt($("#paginasLeidas").val());
        var paginasTotales = parseInt($("#paginasTotales").val());
        if(paginasLeidas > paginasTotales){
            alert("El número de páginas leídas no puede ser mayor al total de páginas");
            return;
        }
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function(data) {
                if(data.type == 'alert-warning'){
                    alertWarningTopEnd(data.message);
                }
                else if (data.type == 'alert-danger'){
                    alertErrorTopEnd(data.message);
                }
                else{
                    alertSuccessTopEnd(data.message);
                    loadDatosHistoricos(data.idItem, data.tipoLectura);
                    actualizarDatosLecturaCard("#card_" + data.idItem, data.datosLectura);
                    var item = $("#item_" + data.idItem);
                    item.find('.paginasLeidas').text(data.datosLectura.paginas_leidas);
                    //Si encontramos la funcion loadDatosInteres la llamamos
                    if(typeof loadDatosInteres === 'function'){
                        loadDatosInteres();
                    }
                }
            }
        });
    });
}


function loadDatosHistoricos(itemId, tipoLectura){
    $.ajax({
        //url base
        url: window.location.origin + '/lecturas/historico-lecturas/'+itemId+'/'+tipoLectura,
        method: 'GET',
        beforeSend: function(){
            $("#tablaRegistrosLectura").bootstrapTable('showLoading');
            $("#modalRegistroLectura").find("#porcentajePaginasRange").attr("disabled", true);
        },
        success: function(data) {
            //recorremos el historico de lecturas
            var modal = $("#modalRegistroLectura");
            $("#tablaRegistrosLectura").bootstrapTable('load', data.historico);
            var porcentaje = (parseInt(data.item.paginas_leidas)/parseInt(data.item.paginas_totales))*100;
            $("#modalRegistroLectura .progress-new-bar div").attr("data-percent", porcentaje.toFixed(2));
            $("#modalRegistroLectura .progress-new-bar div").attr("data-color", (porcentaje < 100) ? "orange" : "green");
            modal.find(".progress-new-text").text(porcentaje.toFixed(2)+"%");
            //recargamos la barra de progreso
            $(".progress-new-bar").ProgressBar();
            $("#modalRegistroLectura").find("#paginasLeidas").val(data.item.paginas_leidas).attr("disabled", false);
            $("#modalRegistroLectura").find("#porcentajePaginas").val(porcentaje.toFixed(2));
            $("#modalRegistroLectura").find("#paginasTotales").val(data.item.paginas_totales);
            $("#modalRegistroLectura").find("#porcentajePaginasRange").attr("disabled", false).val(porcentaje.toFixed(2));
            $("#modalRegistroLectura").find("#porcentajePaginas").text(porcentaje.toFixed(2)+"%");
            console.log(data);
        },
        error: function(data){
            alertErrorTopEnd('Error al cargar los datos');
            $("#tablaRegistrosLectura").bootstrapTable('hideLoading');
        },
        complete: function(){
            loadHeightTableFixedHeader("#modalRegistroLectura .table-responsive .fixed-table-body");
            $("#tablaRegistrosLectura").bootstrapTable('hideLoading');
        }
    });
}

function loadDatosItem(itemId, tipoLectura){
    $.ajax({
        //url base
        url: window.location.origin + '/lecturas/datos-lectura/'+itemId+'/'+tipoLectura,
        method: 'GET',
        success: function(data) {
            var modal = $("#modal_detalles_item");
            //Titulo
            modal.find("#detallesTitulo").text(data.datosLectura.tituloColeccion+(data.datosLectura.numero !== null ? " #"+data.datosLectura.numero : ""));
            //Imagen
            modal.find("#detallesImagen").attr("src", data.datosLectura.imagen);
            modal.find("#detallesImagen").attr("alt", data.datosLectura.tituloColeccion+"_imagen");
            var tablaDetallesLibro = modal.find("#tablaDetallesItem");
            tablaDetallesLibro.empty();
            //Datos del item
            var datosColeccion = null;
            if(data.datosLectura.datosColeccion !== null){
                datosColeccion = JSON.parse(data.datosLectura.datosColeccion);
            }
            addDatoTablaDetallesLibro(tablaDetallesLibro, "Autor", data.datosLectura.autor || 'No disponible');
            if(datosColeccion !== null){
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Editorial", datosColeccion.editorialEspanola || data.datosLectura.editorial || 'No disponible');
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Dibujo", datosColeccion.dibujo || 'No disponible');
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Guión", datosColeccion.guion || 'No disponible');
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Tipo", datosColeccion.tipo || 'No disponible');
            }
            if(data.datosLectura.editorial != null) {
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Editorial", data.datosLectura.editorial);
            }
            if(data.datosLectura.numero != null) {
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Número", data.datosLectura.numero);
            }
            if(data.datosLectura.precio !== null) {
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Precio", data.datosLectura.precio+" "+data.datosLectura.moneda);
            }
            if(data.datosLectura.fecha != null) {
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Fecha publicación", data.datosLectura.tipo == 'no_editado' ? '-' : data.datosLectura.fecha);
            }
            if(data.datosLectura.numeroPaginasBN != null || data.datosLectura.paginas_totales != null) {
                addDatoTablaDetallesLibro(tablaDetallesLibro, "Número de páginas", data.datosLectura.numeroPaginasBN || data.datosLectura.paginas_totales);
            }
            modal.modal('show');
        },
        error: function(data){
            alertErrorTopEnd('Error al cargar los datos');
        }
    });
}
function addDatoTablaDetallesLibro(tabla, dato, valor){
    if(valor === null) return;
    var fila = "<tr>";
    fila += "<td><strong>"+dato+":</strong></td>";
    fila += "<td>"+valor+"</td>";
    fila += "</tr>";
    tabla.append(fila);
}

function actualizarDatosLecturaCard(selector, datosLectura = null){
    var detallesLibro = $(selector);
    detallesLibro.find('.btn-cambiar-paginas-leidas').attr('data-paginas-leidas', datosLectura.paginas_leidas);
    detallesLibro.find('.btn-dropdown-lectura').removeClass('btn-outline-secondary btn-warning btn-info btn-warning btn-success');
    switch (parseInt(datosLectura.estado_lectura)) {
        case 1: //leyendo
            detallesLibro.find('.btn-dropdown-lectura').addClass('btn-warning');
            detallesLibro.find('.btn-dropdown-lectura').text('Leyendo');
            break;
        case 2: //leido
            detallesLibro.find('.btn-dropdown-lectura').addClass('btn-success');
            detallesLibro.find('.btn-dropdown-lectura').text('Leído');
            break;
        case 3: //quiero leer
            detallesLibro.find('.btn-dropdown-lectura').addClass('btn-info');
            detallesLibro.find('.btn-dropdown-lectura').text('Quiero leer');
            break;
        default: //no leido
            detallesLibro.find('.btn-dropdown-lectura').addClass('btn-outline-secondary');
            detallesLibro.find('.btn-dropdown-lectura').text('No leído');
    }
    var porcentaje = (parseInt(datosLectura.paginas_leidas)/parseInt(datosLectura.paginas_totales))*100;
    detallesLibro.find(".progress-new-bar div").attr("data-percent", porcentaje.toFixed(2));
    detallesLibro.find(".progress-new-text").text(porcentaje.toFixed(2)+"%");
    $(".progress-new-bar").ProgressBar();
}


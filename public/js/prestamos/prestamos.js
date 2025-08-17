$(document).ready(function() {
//Inicializacion de las tablas
    $("#tablaPrestamosHechos, #tablaPrestamosRecibidos").bootstrapTable({
        locale: 'es-ES',
        classes: 'table-no-bordered',
        pagination: false,
        height: '100vh',
        fixedHeader: true,
        sortName: 'fecha',
        onPostHeader: function() {
            $('.fixed-table-container').css('padding-bottom', '0');
        }
    });
    listarPrestamos(1);
    listarPrestamos(0);
});

function listarPrestamos(direccion){
    return $.ajax({
        url: '/prestamos/listarPrestamos/' + direccion,
        type: 'GET',
        success: function(data){
            if(data.status == 'success'){
                if(direccion == 1){
                    $('#tablaPrestamosHechos').bootstrapTable('load', data.datos);
                }
                else{
                    $('#tablaPrestamosRecibidos').bootstrapTable('load', data.datos);
                }
            }
            else{
                alertErrorTopEnd("No se ha podido realizar la operación");
            }
        },
        error: function(data){
            alertErrorTopEnd("No se ha podido realizar la operación");
        }
    });
}

function devolverPrestamo(item_id, direccion, tipo){
    var datos = {
        tipo : tipo,
        item_id: item_id,
        '_token': $('input[name=_token]').val()
    };
    return $.ajax({
        url: '/prestamos/devolverPrestamo',
        data: datos,
        method: 'POST',
        success: function(data){
            if(data.status == 'success'){
                alertSuccessTopEnd("Operación realizada con éxito");
                listarPrestamos(direccion);
            }
            else{
                alertErrorTopEnd("No se ha podido realizar la operación");
            }
        },
        error: function(data){
            alertErrorTopEnd("No se ha podido realizar la operación");
        }
    });
}
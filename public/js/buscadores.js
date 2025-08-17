$(document).ready(function(){
    //============================Buscador en coleccion propia / comics
    $(".buscador").keyup(function (){
        var cadenaBuscar = $(this).val();
        if(cadenaBuscar.length > 1){
            $(".coleccion-item").addClass('d-none');
            $(".coleccion-item").each(function(){
                if($(this).data('coleccion').toLowerCase().indexOf(cadenaBuscar.toLowerCase()) > -1){
                    $(this).removeClass('d-none');
                }
            });
        }
        else{
            $(".coleccion-item").removeClass('d-none');
        }
    });

    //============================Buscador colecciones internet
    $("#buscar").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: $("#buscar").data('url-listado'),
                dataType: "json",
                data: {
                    buscar: request.term
                },
                success: function (data) {
                    var array = [];
                    console.log(data);
                    array = $.map(data.colecciones, function (row1) {
                        return {
                            value: row1.nombre,
                            label: row1.nombre,
                            url: 'https://www.listadomanga.es/autor.php?id=' + row1.id,
                            id: row1.id
                        }
                    });
                    console.log(array);
                    response($.ui.autocomplete.filter(array, request.term).slice(0, 10));
                },
                complete: function (data) {
                    $("#ui-id-1").css("z-index", "10000");
                    $("#ui-id-1").css("font-size", "0.6rem");
                    $("#ui-id-1").css("width", "50%");
                }

            });
        },
        minLength: 3,
        classes: {
            "ui-autocomplete-input": "pl-2"
        },
        delay: 500,
        autoFocus: true,
        select: function (event, ui) {
            $.ajax({
                url: $("#buscar").data('url-resultado'),
                dataType: "json",
                data: {
                    id: ui.item.id
                }
            }).done(function (data) {
                document.location.href = data.result;
            }).fail(function (data) {

            });
        },
    })
})

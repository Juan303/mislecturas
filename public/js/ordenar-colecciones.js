$(document).ready(function (){
    $(".orden-item").click(function (e){
        e.preventDefault();
        var orden = $(this).data('ordenar-por');
        var colecciones = $("#colecciones .coleccion-item");
        if(orden == 'orden-item-id'){
            colecciones.sort(function (a, b){
                return parseInt($(a).data('orden-item-id')) < parseInt($(b).data('orden-item-id'));
            }).appendTo($("#colecciones"));
        }
        else{
            colecciones.sort(function (a, b){
                return $(a).data(orden).toUpperCase().localeCompare($(b).data(orden).toUpperCase());
            }).appendTo($("#colecciones"));
        }
    });
});

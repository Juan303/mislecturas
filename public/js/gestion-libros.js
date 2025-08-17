$(document).ready(function(){
    //==============================================Eliminar libro
    $(".btn-eliminar-libro").click(function(e){
        $("#confirm_delete .modal-body p").text('Se va a eliminar el libro "'+ $(this).data("item-name") +'" de su biblioteca. ¿Desea continuar?');
        $("#confirm_delete form").attr('action', ($(this).data('url')));
        $("#confirm_delete #item_id").val($(this).data("item-id"));
        $("#confirm_delete #item_nombre").val($(this).data("item-name"));
        $("#confirm_delete").modal("show");
    });
});

//==============================================Autocompletar datos de libro
function autocompletarLibros(ruta_listado_libros, ruta_datos_libro){
    $("#titulo").autocomplete({
        source: function(request, response){
            $.ajax({
                url: ruta_listado_libros,
                dataType: "json",
                data: {
                    buscar : request.term
                },
                success: function( data ){
                    console.log(data);
                    array = [];
                    array = $.map(data.items,function(row){
                        return {
                            //Mostrar una imagen en el autocompletado
                            value:row.volumeInfo.title,
                            label:row.volumeInfo.title + " - " + (row.volumeInfo.publisher ? row.volumeInfo.publisher : ""),
                            url: row.selfLink,
                            icon: row.volumeInfo.imageLinks ? row.volumeInfo.imageLinks.smallThumbnail : "",
                        }
                    });
                    response(array);
                }
            });
        },
        //minLength: 3,
        delay:500,
        autoFocus: true,
        select: function(event, ui){
            $.ajax({
                url: ruta_datos_libro,
                data: {
                    url: ui.item.url,
                },
                success: function (data) {
                    var json = JSON.parse(data);
                    console.log(json);
                    $("#titulo").val(json.volumeInfo.title ?? "");
                    $("#autor").val(json.volumeInfo.authors ? json.volumeInfo.authors.join(", ") : "");
                    $("#editorial").val(json.volumeInfo.publisher ?? "");
                    $("#paginas_totales").val(json.volumeInfo.pageCount ?? "");
                    $("#isbn").val(json.volumeInfo.industryIdentifiers ? json.volumeInfo.industryIdentifiers[0].identifier : "");
                    var imagen_temporal = json.volumeInfo.imageLinks.thumbnail;
                   /* if(json.volumeInfo.imageLinks.medium != undefined){
                        imagen_temporal = json.volumeInfo.imageLinks.medium;
                    }*/
                    $("#imagenTemporal").attr('src', imagen_temporal).prop('hidden', false);
                    $("#urlImagenTemporal").val(imagen_temporal);
                    $("#sinopsis").val(json.volumeInfo.description ? json.volumeInfo.description.replace(/<br>/g, "\r\n").replace(/<[^>]*>?/g, '').trim() : "");
                    //Ajustar el tamaño del textarea de la sinopsis al tamaño del texto
                    var altura = $("#sinopsis")[0].scrollHeight;
                    $("#sinopsis").css('height', altura+'px !important');
                }
            });
        }
    });
    $("#titulo").data("ui-autocomplete")._renderItem = function (ul, item) {
        return $('<li/>', {class: "ui-autocomplete-item"}).append('<div class="row"><div style="width:80px" class="col-2"><img src="'+item.icon+'" class="img-fluid"></div><div class="col-10">'+item.label+'</div></div>').appendTo(ul);
    };
}

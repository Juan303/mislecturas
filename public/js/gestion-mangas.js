$(document).ready(function(){
    //=============================================agregar todos
    $("#agregar-seleccionados-form").submit(function(e){
        e.preventDefault();
        //Abrimos el modal "modal_agregar_todos_compra" para poder seleccionar una fecha de compra
        $("#modal_agregar_todos_compra").modal('show');
        $("#modal_agregar_todos_compra").data('datos-serializados', $(this).serialize());
        $("#modal_agregar_todos_compra").data('action', $(this).attr("action"));
        //fecha actual en formato DD/MM/YYYY usando moment.js
        var fecha_actual = moment().format('YYYY-MM-DD');    
        $("#modal_agregar_todos_compra #fecha_compra").val(fecha_actual);
        $("#modal_agregar_todos_compra").data('method', $(this).attr("method"));

    });

    $("#modal_agregar_todos_compra_btn_guardar").click(function(){
        //comprobamos que los campos de fecha, numero inicial y numero final no esten vacios
        if($("#fecha_compra").val() == '' || $("#numero_inicial").val() == '' || $("#numero_final").val() == ''){
            alertErrorTopEnd("Debes completar todos los campos");
            return;
        }
        //comprobamos que el numero inicial sea menor o igual al numero final ni cero
        if(parseInt($("#numero_inicial").val()) > parseInt($("#numero_final").val()) || parseInt($("#numero_inicial").val()) == 0){
            alertErrorTopEnd("El número inicial no puede ser mayor al número final ni cero");
            return;
        }
        $.ajax({
            url: $("#modal_agregar_todos_compra").data('action'),
            data: $("#modal_agregar_todos_compra").data('datos-serializados') + "&fecha_compra=" + $("#fecha_compra").val() + "&numero_inicial=" + $("#numero_inicial").val() + "&numero_final=" + $("#numero_final").val(),
            method: $("#modal_agregar_todos_compra").data('method'),
            error: function(data){
                alertErrorTopEnd("Se ha producido un error");
            },
            success: function(data){
                $.each(data.idsComicsAgregados, function(index, value){
                    var formularioAgregar = $("#card_"+value).find(".comic-add-form");
                    $("#card_"+value).closest('.manga-item').addClass('item-tengo');
                    $("#card_"+value).closest('.manga-item').removeClass('item-quiero');
                    $("#form_favorito_"+value).addClass('d-none').removeClass('d-inline');
                    formularioAgregar.find(".accion").val("eliminar");
                    formularioAgregar.find('.btn-store').removeClass('agregar-comic-button btn-secondary');
                    formularioAgregar.find(".btn-store").addClass('btn-store btn btn-sm w-50 btn-success eliminar-comic-button');
                    formularioAgregar.find(".btn-store i").removeClass('fa-plus').addClass('fa-check');
                    formularioAgregar.find("#agregar-favoritos-seleccionados-form .item").attr("disabled", true);
                    formularioAgregar.find("#eliminar-favoritos-seleccionados-form .item").attr("disabled", true);
                });
                // var formularioAgregar = $(".comic-add-form");
                // $('.manga-item').addClass('item-tengo');
                // $('.manga-item').removeClass('item-quiero');
                // $(".comic-favorite-form").addClass('d-none').removeClass('d-inline');
                // formularioAgregar.find(".accion").val("eliminar");
                // formularioAgregar.find('.btn-store').removeClass('agregar-comic-button btn-secondary');
                // formularioAgregar.find(".btn-store").addClass('w-75 mx-auto eliminar-comic-button btn-success btn-block');
                // formularioAgregar.find(".btn-store i").removeClass('fa-plus').addClass('fa-check');
                // $("#agregar-favoritos-seleccionados-form .item").attr("disabled", true);
                // $("#eliminar-favoritos-seleccionados-form .item").attr("disabled", true);
                alertSuccessTopEnd("Mangas agregados a tu colección");
                
            },
            complete: function(){
                $("#modal_agregar_todos_compra").modal('hide');
            }
        });
    });
    
    //=============================================agregar todos a favoritos (solo los que no estan marcados como agregados
    $("#agregar-favoritos-seleccionados-form").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function(data){
                $(".manga-item:not(.item-tengo) .comic-favorite-form").each(function(){
                    $(this).find('.quiero-icon').removeClass('far');
                    $(this).find('.quiero-icon').addClass('fas');
                    $(this).find(".accion").val('no_quiero');
                    $(this).closest('.manga-item').addClass('item-quiero');
                });
                $(".campo-idColeccionPersonal").val(data.idColeccionPersonal);
                alertSuccessTopEnd("Mangas agregados a tus favoritos");
            }
        });
    });
    //=============================================eliminar todos de favoritos (solo los que no estan marcados como agregados)
    $("#eliminar-favoritos-seleccionados-form").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function(data){
                $(".manga-item:not(.item-tengo) .comic-favorite-form").each(function(){
                    $(this).find('.quiero-icon').removeClass('fas');
                    $(this).find('.quiero-icon').addClass('far');
                    $(this).find(".accion").val('quiero');
                    $(this).removeClass('item-quiero');
                });
                alertSuccessTopEnd("Mangas eliminados de tus favoritos");
            }
        });
    });
    //=============================================eliminar todos
    $("#eliminar-seleccionados-form").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function(data){
                var formularioAgregar = $(".comic-add-form");
                var formularioQuiero = $(".comic-favorite-form");
                formularioAgregar.find(".accion").val('agregar');
                formularioAgregar.find('.btn-store').addClass('agregar-comic-button btn-secondary');
                formularioAgregar.find(".btn-store").removeClass('w-75 mx-auto eliminar-comic-button btn-success btn-block');
                formularioAgregar.find(".btn-store i").addClass('fa-plus').removeClass('fa-check');
                $('.manga-item').removeClass('item-quiero item-tengo');
                $("#agregar-favoritos-seleccionados-form .item").attr("disabled", false);
                $("#eliminar-favoritos-seleccionados-form .item").attr("disabled", false);
                formularioQuiero.removeClass('d-none').addClass('d-inline');
                formularioQuiero.find('.quiero-icon').removeClass('fas');
                formularioQuiero.find('.quiero-icon').addClass('far');
                alertSuccessTopEnd("Mangas eliminados de tu colección");
            }
        });
    });

    //==============================================agregar / eliminar / quiero (individual)
    $(".comic-add-form, .comic-favorite-form").submit(function(e){
        e.preventDefault();
        var formulario = $("."+$(this).data("clase"));
        var manga_id = $(this).data("manga-id");
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: $(this).attr("method"),
            success: function(data){
                if(data.accion == 'agregar'){
                    $(formulario).find('.btn-store').removeClass('agregar-comic-button btn-secondary');
                    $(formulario).find(".btn-store").addClass('w-75 mx-auto eliminar-comic-button btn-success btn-block');
                    $(formulario).find(".btn-store i").removeClass('fa-plus').addClass('fa-check');
                    $(formulario).find(".accion").val('eliminar');
                    $(".form_favorite_"+manga_id).addClass('d-none');
                    $(".form_favorite_"+manga_id).removeClass('d-inline');
                    $(formulario).closest('.manga-item').addClass('item-tengo');
                    $(formulario).closest('.manga-item').removeClass('item-quiero');
                    $("#item-favorito_agregar_"+manga_id).attr('disabled', true);
                    $("#item-favorito_eliminar_"+manga_id).attr('disabled', true);
                    alertSuccessTopEnd("Manga agregado a tu colección");
                }
                else if(data.accion == 'quiero'){
                    $(formulario).find('.quiero-icon').removeClass('far');
                    $(formulario).find('.quiero-icon').addClass('fas');
                    $(formulario).find(".accion").val('no_quiero');
                    $(formulario).closest('.manga-item').addClass('item-quiero');
                    alertSuccessTopEnd("Manga agregado a tus favoritos");
                }
                else if(data.accion == 'no_quiero'){
                    $(formulario).find('.quiero-icon').removeClass('fas');
                    $(formulario).find('.quiero-icon').addClass('far');
                    $(formulario).find(".accion").val('quiero');
                    $(formulario).closest('.manga-item').removeClass('item-quiero');
                    alertSuccessTopEnd("Manga eliminado de tus favoritos");
                }
                else{
                    $(formulario).find('.btn-store').addClass('agregar-comic-button btn-secondary');
                    $(formulario).find(".btn-store").removeClass('w-75 mx-auto eliminar-comic-button btn-success btn-block');
                    $(formulario).find(".btn-store i").addClass('fa-plus').removeClass('fa-check');
                    $(formulario).find(".accion").val('agregar');
                    $(".form_favorite_"+manga_id).removeClass('d-none');
                    $(".form_favorite_"+manga_id).addClass('d-inline');
                    $(".form_favorite_"+manga_id).find('.quiero-icon').removeClass('fas');
                    $(".form_favorite_"+manga_id).find('.quiero-icon').addClass('far');
                    $(".form_favorite_"+manga_id).find(".accion").val('quiero');
                    $(formulario).closest('.manga-item').removeClass('item-quiero');
                    $(formulario).closest('.manga-item').removeClass('item-tengo');
                    $("#item-favorito_agregar_"+manga_id).attr('disabled', false);
                    $("#item-favorito_eliminar_"+manga_id).attr('disabled', false);
                    alertSuccessTopEnd("Manga eliminado de tu colección");
                }

            },
            error: function(data){
                alertErrorTopEnd("Se ha producido un error");
            }
        });
    });
    //==============================================PRESTAMOS
    //==============================================prestar / devolver (individual)
    $(".btn-prestar").click(function(){
        visibilidadBloquesPrestar($(this).data('tengo'), $(this).data('persona'), $(this).data('direccion'), $(this).data('fecha-prestamo'));
        $("#modal_prestar input").val('');
        $("#modal_prestar").data('item-id', $(this).data('item-id'));
        $("#modal_prestar").data('card-id', $(this).data('card-id'));
        $("#modal_prestar").data('tipo', $(this).data('tipo'));
        $("#modal_prestar").data('tengo', $(this).data('tengo'));
        $("#modal_prestar").modal('show');
    });

    $("#modal_prestar_btn_guardar").click(function(){
        var direccion = $("#persona_a_la_que_prestas").val() != '' ? 1 : 0;
        var datos = {
            tipo : $("#modal_prestar").data('tipo'),
            item_id: $("#modal_prestar").data('item-id'),
            persona: $("#persona_a_la_que_prestas").val() != '' ? $("#persona_a_la_que_prestas").val() : $("#persona_que_te_lo_presta").val(),
            direccion: direccion,
            '_token': $('input[name=_token]').val()
        };
        return $.ajax({
            url: '/prestamos/asignarPrestamo',
            data: datos,
            method: 'POST',
            success: function(data){
                $("#modal_prestar").modal('hide');
                if(data.status == 'success') {
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').data('direccion', data.datos.direccion);
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').data('persona', data.datos.persona);
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').data('fecha-prestamo', data.datos.created_at);
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').removeClass('btn-outline-warning').addClass('btn-warning');
                    alertSuccessTopEnd("Operación realizada correctamente");
                }
                else{
                    alertErrorTopEnd("Se ha producido un error");
                }
            },
            error: function(data){
                alertErrorTopEnd("Se ha producido un error");
            }
        });
    });

    $("#devolver_prestamo_btn").click(function(){
        var datos = {
            tipo : $("#modal_prestar").data('tipo'),
            item_id: $("#modal_prestar").data('item-id'),
            '_token': $('input[name=_token]').val()
        };
        return $.ajax({
            url: '/prestamos/devolverPrestamo',
            data: datos,
            method: 'POST',
            success: function(data){
                $("#modal_devolver").modal('hide');
                if(data.status == 'success') {
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').data('direccion', '');
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').data('persona', '');
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').data('fecha-prestamo', '');
                    $("#"+ $("#modal_prestar").data('card-id')).find('.btn-prestar').removeClass('btn-warning').addClass('btn-outline-warning');
                    visibilidadBloquesPrestar($("#modal_prestar").data('tengo'), '', '', '');
                    alertSuccessTopEnd("Operación realizada correctamente");
                }
                else{
                    alertErrorTopEnd("Se ha producido un error");
                }
            },
            error: function(data){
                alertErrorTopEnd("Se ha producido un error");
            }
        });
    });

    $(".dropdown-item").click(function(){
        $(this).closest('.dropdown-menu').removeClass('show');
    })
});

function visibilidadBloquesPrestar(tengo, persona, direccion, fecha){
    $("#datos_prestamo_texto").html('');
    $("#datos_prestamo").attr('hidden', true);
    $("#modal_prestar_btn_guardar").attr('hidden', false);
    if(persona != ''){
        $("#modal_prestar_btn_guardar").attr('hidden', true);
        $("#modal_prestar_a").attr('hidden', true);
        $("#modal_prestado_por").attr('hidden', true);
        $("#datos_prestamo").attr('hidden', false);
        if(direccion == 1){
            $("#datos_prestamo_texto").html('Prestado a <strong>'+persona+'</strong> el día <strong>'+fecha.split(' ')[0].split('-').reverse().join('/')+'</strong>');
        }
        else{
            $("#datos_prestamo_texto").html('Prestado por <strong>'+persona+'</strong> el día <strong>'+fecha.split(' ')[0].split('-').reverse().join('/')+'</strong>');
        }
    }
    else if(tengo == 0){
        $("#modal_prestar_a").attr('hidden', true);
        $("#modal_prestado_por").attr('hidden', false);
    }
    else{
        $("#modal_prestar_a").attr('hidden', false);
        $("#modal_prestado_por").attr('hidden', true);
    }
}

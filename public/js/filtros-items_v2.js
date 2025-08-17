$(document).ready(function (){
    $(".item-filtro").click(function(){
        var grupo = $(this).data('grupo');
        if($(this).hasClass('active')){
            $("."+grupo).prop("checked", false);
            $(this).removeClass('active')
        }
        else{
            $("."+grupo).removeClass('active');
            $(this).addClass('active');
        }
       /* $(".manga-item").addClass('d-none');
        var ningunoCkecked = true;
        var claseMostrar = "";
        $(".item-filtro").each(function (){

            if($(this).is(':checked')){
                claseMostrar += "."+$(this).val();
                ningunoCkecked = false;
            }
        })
        $(claseMostrar).removeClass('d-none');
        if(ningunoCkecked){
            $(".manga-item").removeClass('d-none');
        }
        actualizarPaginacion($('.buscador').val(),null);*/
    });
})

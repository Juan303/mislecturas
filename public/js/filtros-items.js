$(document).ready(function (){
    //================COMICS
    //Filtrar mangas que tengo
    $(".btn-filtro-tengo").click(function (){
        $('.manga-item').addClass('d-none');
        $('.manga-item.item-tengo').removeClass('d-none');
        actualizarPaginacion("", 'tengo');
        $('.hip-search-input').val("");

    });
    //Filtrar mangas que quiero
    $(".btn-filtro-quiero").click(function (){
        $('.manga-item').addClass('d-none');
        $('.manga-item.item-quiero').removeClass('d-none');
        actualizarPaginacion("","quiero");
        $('.hip-search-input').val("");
    });
    //Filtrar mangas que leyendo
    $(".btn-filtro-leyendo").click(function (){
        $('.manga-item').addClass('d-none');
        $('.manga-item.item-leyendo').removeClass('d-none');
        actualizarPaginacion("", 'leyendo');
        $('.hip-search-input').val("");
    });
    //Filtrar mangas leidos
    $(".btn-filtro-leidos").click(function (){
        $('.manga-item').addClass('d-none');
        $('.manga-item.item-leido').removeClass('d-none');
        actualizarPaginacion("", 'leidos');
        $('.hip-search-input').val("");
    });
    //Filtrar mangas no leidos
    $(".btn-filtro-no-leidos").click(function (){
        $('.manga-item').addClass('d-none');
        $('.manga-item.item-no-leido').removeClass('d-none');
        actualizarPaginacion("", 'no-leidos');
        $('.hip-search-input').val("");
    });
    //Mostrar todos los mangas
    $(".btn-filtro-todos").click(function (){
        $('.manga-item').removeClass('d-none');
        actualizarPaginacion("", 'todos');
        $('.hip-search-input').val("");
    });
    //==================COLECCIONES
    //Filtrar colecciones al dia
    $(".btn-filtro-al-dia").click(function (){
        $('.coleccion-item').addClass('d-none');
        $('.coleccion-item.coleccion-al-dia').removeClass('d-none');
        actualizarPaginacion("", 'al-dia');
        $('.hip-search-input').val("");
    });
    //Filtrar colecciones completas
    $(".btn-filtro-completas").click(function (){
        $('.coleccion-item').addClass('d-none');
        $('.coleccion-item.coleccion-completa').removeClass('d-none');
        actualizarPaginacion("", 'completas');
        $('.hip-search-input').val("");
    });
    //Filtrar colecciones incompletas
    $(".btn-filtro-incompletas").click(function (){
        $('.coleccion-item').addClass('d-none');
        $('.coleccion-item.coleccion-incompleta').removeClass('d-none');
        actualizarPaginacion("", 'incompletas');
        $('.hip-search-input').val("");
    });
    //Mostrar todas las colecciones
    $(".btn-filtro-todas").click(function (){
        $('.coleccion-item').removeClass('d-none');
        actualizarPaginacion("", 'todas');
        $('.hip-search-input').val("");
    });
});

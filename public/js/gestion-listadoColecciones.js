myChart = null;
$(document).ready(function() {
    $.fn.bootstrapTable.locales['es-ES'].formatShowingRows = function (pageFrom, pageTo, totalRows) {
        return `<span class="small">${totalRows} registros</span>`;
    };
    $.fn.bootstrapTable.locales['es-ES'].formatRecordsPerPage = function (pageNumber) {
        return `<span class="small">${pageNumber}</span>`;
    };
    //Inicializamos la tabla
    $('#tablaListadoColecciones').bootstrapTable({
        locale: 'es-ES',
        classes: 'table-no-bordered',
        pagination: true,
        search: true,
        pageSize: 100,
        height: '100vh',
        fixedHeader: true,
        fixedScroll: true,
        sortName: 'nombre',
        trimOnSearch : false,
        toolbar: '#toolbarColecciones',
        //Carga rapida de datos (carga peresosa)
        onPostHeader: function() {
            $('.fixed-table-container').css('padding-bottom', '0');
        },
        //lineas verdes si coleccionando = 1
        rowStyle: function(row, index) {
            switch (row.estado) {
                case 'completa':
                    return {classes: 'table-success'};
                case 'incompleta':
                    return {classes: 'table-warning'};
                default:
                    return {};
            }
        }
    });
    $('#tablaListadoAutores').bootstrapTable({
        locale: 'es-ES',
        classes: 'table-no-bordered',
        pagination: true,
        search: true,
        pageSize: 100,
        height: '100vh',
        fixedHeader: true,
        fixedScroll: true,
        sortName: 'autor',
        trimOnSearch : false,
        toolbar: '#toolbarAutores',
        //Carga rapida de datos (carga peresosa)
        onPostHeader: function() {
            $('.fixed-table-container').css('padding-bottom', '0');
        },
        rowStyle: function(row, index) {
            switch (row.estado) {
                case 'completa':
                    return {classes: 'table-success'};
                case 'incompleta':
                    return {classes: 'table-warning'};
                default:
                    return {};
            }
        }
    });

   
    $('#tablaListadoObrasAutor').bootstrapTable({
        locale: 'es-ES',
        classes: 'table-no-bordered',
        pagination: true,
        search: true,
        //Si estamos en un movil mostramos menos registros
        pageSize: (isMobile() ? 15 : 30),
        height: '100vh',
        fixedHeader: true,
        fixedScroll: true,
        trimOnSearch : false,
        sortName: 'nombre',
        //customizar texto de la informacion de la paginacion


        //Carga rapida de datos (carga peresosa)
        onPostHeader: function() {
            $('.fixed-table-container').css('padding-bottom', '0');
        },
         //lineas verdes si coleccionando = 1
         rowStyle: function(row, index) {
            switch (row.estado) {
                case 'completa':
                    return {classes: 'table-success'};
                case 'incompleta':
                    return {classes: 'table-warning'};
                default:
                    return {};
            }
        }
    });

    $(".btnCambiarTabla").on('click', function(){
        if($('#tablaListadoColeccionesBloque').hasClass('d-none')){
            $('#tablaListadoColeccionesBloque').removeClass('d-none');
            $('#tablaListadoAutoresBloque').addClass('d-none');
        }else{
            $('#tablaListadoColeccionesBloque').addClass('d-none');
            $('#tablaListadoAutoresBloque').removeClass('d-none');
        }
    });
    $("#selectAnyo, #selectTipo").on('change', function(){
        mostrarFiltrados();
    });
    $(".checkSoloColeccionando").on('change', function(){
        //si esta marcado
        if(!$(this).is(':checked')){
            filtrarColecionando(false);
            $(".checkSoloColeccionando").prop('checked', false);
        }
        else{
            filtrarColecionando(true);
            $(".checkSoloColeccionando").prop('checked', true);
        }
        
    });
    loadListadoColecciones();
});

//Listamos todas las lecturas y compras y las guardamos en el bloque
function loadListadoColecciones(){
    return $.ajax({
        url: '/colecciones/loadListadoColecciones',
        type: 'GET',
        beforeSend: function() {
            //loading de las tablas
            $('#tablaListadoColecciones').bootstrapTable('showLoading');
        },
        success: function(data) {
            $('#tablaListadoColecciones').data('rawData', data);
            var listadoPorAutor = agruparPorAutor(data);
            $('#tablaListadoColecciones').bootstrapTable('load', data);
            $('#tablaListadoAutores').bootstrapTable('load', listadoPorAutor);
        },
        error: function(data) {
            alertErrorTopEnd('Ha ocurrido un error al cargar la lista de colecciones');
        },
        complete: function() {
            $('#tablaListadoColecciones').bootstrapTable('hideLoading');
        }
    });
}

function agruparPorAutor(datos){
    var listadoPorAutor = [];
    datos.forEach(coleccion => {
        var coleccionEncontrada = listadoPorAutor.find(coleccionAutor => coleccionAutor.autor == coleccion.autor);
        if(listadoPorAutor.find(coleccionAutor => coleccionAutor.autor == coleccion.autor)){
            coleccionEncontrada.colecciones.push(coleccion);
            coleccionEncontrada.obras++;
            //Recorremos todas las obras de este autor para ver si alguna esta incompleta. 
            //Si todas las obras estan completas, el autor esta completo. 
            // Si hay completas y nulas el autor esta incompleto. 
            // Si hay completas e incompletas el autor esta incompleto y si todas son null el autor estara a null
            var estado = null;
            var hayNulo = false;
            var hayCompletas = false;
            var hayIncompletas = false;
            coleccionEncontrada.colecciones.forEach(coleccionItem => {
                if(coleccionItem.estado == 'completa'){
                    hayCompletas = true;
                }
                if(coleccionItem.estado == 'incompleta'){
                    hayIncompletas = true;
                }
                if(coleccionItem.estado == null){
                    hayNulo = true;
                }
            });
            //Si solo hay completas el autor esta completo
            if(hayCompletas && !hayIncompletas && !hayNulo){
                estado = 'completa';
            }
            //Si hay completas e incompletas o nulas el autor esta incompleto
            if((hayCompletas && hayIncompletas) || (hayCompletas && hayNulo)){
                estado = 'incompleta';
            }
            coleccionEncontrada.estado = estado;
           
        }else{
            listadoPorAutor.push({
                autor: coleccion.autor, 
                obras: 1, 
                colecciones: [coleccion],
                estado: coleccion.estado
            });

        }
    });
    console.log(listadoPorAutor);
    return listadoPorAutor;
}

function detallesObrasAutor(index){

    var autor = $('#tablaListadoAutores').bootstrapTable('getData')[index];
    $('#modal_obras_autor_titulo').text(autor.autor);
    $('#modal_obras_autor table').bootstrapTable('load', autor.colecciones);
    //mostramos la ventana modal en la parte de arriba de la pantalla
    $('#modal_obras_autor').modal('show');
    $('#modal_obras_autor').on('shown.bs.modal', function (e) {
        loadHeightTableFixedHeader('#modal_obras_autor table');
    });

}

function filtrarColecionando(filtrar){
    var data = $('#tablaListadoColecciones').data('rawData');
    if(filtrar){
        data = data.filter(coleccion => coleccion.estado != null);
    }
    var listadoPorAutor = agruparPorAutor(data);
    $('#tablaListadoColecciones').bootstrapTable('load', data);
    $('#tablaListadoAutores').bootstrapTable('load', listadoPorAutor);
}

function isMobile(){
    return window.innerWidth <= 768;
}

myChart = null;
$(document).ready(function() {
    //Inicializamos la tabla
    $('#modalDetalleEstadisticas table, #tablaEstadisticasLecturas, #tablaEstadisticasCompras').bootstrapTable({
        locale: 'es-ES',
        classes: 'table-no-bordered',
        pagination: false,
        showFooter: true,
        height: '100vh',
        fixedHeader: true,
        sortName: 'mes',
        onPostHeader: function() {
            $('.fixed-table-container').css('padding-bottom', '0');
        }
    });
    $("#selectAnyo, #selectTipo").on('change', function(){
        mostrarFiltrados();
    });
    loadEstadisticasAnualesLectura().then(function(){
        mostrarFiltrados();
    });
    //Si es movil ocultamos ciertas columnas en la tabla de detalles
    if(window.innerWidth < 768){
        $('#modalDetalleEstadisticasTabla').bootstrapTable('hideColumn', 'fecha_fin_lectura');
        $('#modalDetalleEstadisticasTabla').bootstrapTable('hideColumn', 'tipo');
    }
});

//Listamos todas las lecturas y compras y las guardamos en el bloque
function loadEstadisticasAnualesLectura(){
    return $.ajax({
        url: '/estadisticas/loadEstadisticasAnualesLectura',
        data: {
            _token: $('input[name=_token]').val()
        },
        type: 'POST',
        beforeSend: function() {
            //loading de las tablas
            $('#tablaEstadisticasLecturas').bootstrapTable('showLoading');
            $('#tablaEstadisticasCompras').bootstrapTable('showLoading');
        },
        success: function(data) {
            $('#bloqueEstadisticasAnualesLectura').data('lecturasAnuales', data.data.lecturas);
            $('#bloqueEstadisticasAnualesLectura').data('comprasAnuales', data.data.compras);
        },
        error: function(data) {
            alertErrorTopEnd('Ha ocurrido un error al cargar las estadisticas anuales de lectura');
        },
        complete: function() {
            $('#tablaEstadisticasLecturas').bootstrapTable('hideLoading');
            $('#tablaEstadisticasCompras').bootstrapTable('hideLoading');
        }
    });
}

//Mostramos las estadisticas filtradas
function mostrarFiltrados(){
    var anyo = $("#selectAnyo").val();
    var tipo = $("#selectTipo").val();
    var lecturasAnuales = $('#bloqueEstadisticasAnualesLectura').data('lecturasAnuales');
    var comprasAnuales = $('#bloqueEstadisticasAnualesLectura').data('comprasAnuales');
    var lecturasFiltradas = lecturasAnuales.filter(function(lectura){
        return (lectura.YEAR == anyo) && (tipo == '' || lectura.tipoLectura == tipo);
    });
    var comprasFiltradas = comprasAnuales.filter(function(compra){
        return (compra.YEAR == anyo) && (tipo == '' || compra.tipoCompra == tipo);
    });
    graficoLecturasAnuales(lecturasFiltradas, comprasFiltradas);
    var lecturasAgrupadas = [];
    lecturasFiltradas.forEach(function(lectura){

        var lecturaAgrupada = lecturasAgrupadas.find(function(lecturaAgrupada){
            return lecturaAgrupada.mes == lectura.MONTH;
        });
        if(lecturaAgrupada){
            lecturaAgrupada.paginas += parseInt(lectura.paginas_leidas);
            lecturaAgrupada.cantidad += 1;
            lecturaAgrupada.precio += parseFloat(lectura.precio || 0);
            lecturaAgrupada.precioD += parseFloat(lectura.precioD || 0);
            lecturaAgrupada.lecturas.push(lectura);
        }else{
            lecturasAgrupadas.push({
                mes: lectura.MONTH,
                paginas: parseInt(lectura.paginas_leidas),
                cantidad: 1,
                precio: parseFloat(lectura.precio || 0),
                precioD: parseFloat(lectura.precioD || 0),
                lecturas: [lectura]
            });
        }
    });
    $('#tablaEstadisticasLecturas').bootstrapTable('load', lecturasAgrupadas);


    var comprasAgrupadas = [];
    comprasFiltradas.forEach(function(compra){
        var compraAgrupada = comprasAgrupadas.find(function(compraAgrupada){
            return compraAgrupada.mes == compra.MONTH;
        });
        if(compraAgrupada){
            compraAgrupada.cantidad += 1;
            compraAgrupada.precio += parseFloat(compra.precio || 0);
            compraAgrupada.precioD += parseFloat(compra.precioD || 0);
            compraAgrupada.compras.push(compra);
        }else{
            comprasAgrupadas.push({
                mes: compra.MONTH,
                cantidad: 1,
                precio: parseFloat(compra.precio || 0),
                precioD: parseFloat(compra.precioD || 0),
                compras: [compra]
            });
        }
    });
    $('#tablaEstadisticasCompras').bootstrapTable('load', comprasAgrupadas);
}

function mostrarDetallesCompraMes(id, mes){
    var detalles = $('#tablaEstadisticasCompras').bootstrapTable('getData')[id].compras;
    $("#modalDetalleEstadisticasTitulo").text('Detalles de compras: ' + fechaFormatterNombreMes(mes));
    $("#modalDetalleEstadisticasTabla").bootstrapTable('load', detalles);
    if(window.innerWidth < 768){
        $('#modalDetalleEstadisticasTabla').bootstrapTable('showColumn', 'precio');
        $('#modalDetalleEstadisticasTabla').bootstrapTable('hideColumn', 'paginas_totales');
    }
    $("#modalDetalleEstadisticas").modal('show');
}

function mostrarDetallesLecturaMes(id, mes){
    var detalles = $('#tablaEstadisticasLecturas').bootstrapTable('getData')[id].lecturas;
    $("#modalDetalleEstadisticasTitulo").text('Detalles de lectura: ' + fechaFormatterNombreMes(mes));
    $("#modalDetalleEstadisticasTabla").bootstrapTable('load', detalles);
    if(window.innerWidth < 768){
        $('#modalDetalleEstadisticasTabla').bootstrapTable('showColumn', 'paginas_totales');
        $('#modalDetalleEstadisticasTabla').bootstrapTable('hideColumn', 'precio');
    }
    $("#modalDetalleEstadisticas").modal('show');


}




//=================================================Functiones de graficos=================================================
function graficoLecturasAnuales(lecturas, compras){
    var datosCompras = new Array(12).fill(0); // Array de 12 meses con valores inicializados en 0
    var datosLecturas = new Array(12).fill(0); // Array de 12 meses con valores inicializados en 0
    var datosItemsCompras = Array.from({ length: 12 }, () => []);
    var datosItemsLecturas = Array.from({ length: 12 }, () => []);
    var labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    lecturas.forEach(function (lectura) {
        var mes = lectura.MONTH - 1; // Los índices de meses deben empezar desde 0
        datosLecturas[mes] += 1; // Incrementamos el número de lecturas para el mes correspondiente
        datosItemsLecturas[mes].push(lectura);
    });
    compras.forEach(function (compra) {
        var mes = compra.MONTH - 1; // Los índices de meses deben empezar desde 0
        datosCompras[mes] += 1; // Incrementamos el número de compras para el mes correspondiente
        datosItemsCompras[mes].push(compra);
    });
    if (myChart) { myChart.destroy(); }
    var ctx = document.getElementById('chartEstadisticasAnualesLectura').getContext('2d');
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Lecturas',
                    data: datosLecturas,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgb(81,155,81)',
                    tension: 0.1,
                },
                {

                    label: 'Compras',
                    data: datosCompras,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgb(255,99,132)',
                    tension: 0.1,
                }
            ]
        },
        options: {
            animation: {
                onProgress: function(animation) {
                    if($("#graficoEstadisticasAnualesLectura").data('cargaCompleta')) return;
                    $("#graficoEstadisticasAnualesLectura").hide();
                    $("#initialProgress").val(animation.currentStep / animation.numSteps);
                },
                onComplete: function(animation) {
                    $("#graficoEstadisticasAnualesLectura").data('cargaCompleta', true);
                    $("#graficoEstadisticasAnualesLectura").show();
                    $("#initialProgress").hide();
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            elements: {
                point: {
                    radius: 5
                },
            },
        }
    });
}

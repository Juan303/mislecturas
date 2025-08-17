$(document).ready(function(){
    loadUltimasLecturas();
    loadRetoActual();
    loadDatosInteres();
});

function loadUltimasLecturas(){
    return $.ajax({
        url: '/lecturas/ultimas-lecturas',
        type: 'GET',
        beforeSend: function(){
            showLoadingPanelWidget('#bloqueUltimasLecturas');
        },
        success: function(data) {
            $('#bloqueUltimasLecturas').html(data.html);
            accionesLectura();
            actualizarPaginasLeidas();
            confirmarActualizarPaginasLeidas();
        },
        error: function(data) {
            alertErrorTopEnd('Ha ocurrido un error al cargar los datos delas últimas lecturas');
        },
        complete: function(data){
            showLoadingPanelWidget('#bloqueUltimasLecturas');
            $(".progress-new-bar").ProgressBar();
        }
    });
}

function loadRetoActual(){
    return $.ajax({
        url: '/lecturas/retos/loadRetoActual/welcome',
        type: 'GET',
        beforeSend: function(){
            showLoadingPanelWidget('#bloqueRetoActual');
        },
        success: function(data) {
            $('#bloqueRetoActual').html(data.html);
        },
        error: function(data) {
            alertErrorTopEnd('Ha ocurrido un error al cargar los datos del reto actual');
        },
        complete: function(data){
            showLoadingPanelWidget('#bloqueRetoActual');
            $(".progress-new-bar").ProgressBar();
        }
    });
}

function loadDatosInteres(){
    return $.ajax({
        url: '/estadisticas/loadDatosInteres',
        type: 'GET',
        beforeSend: function(){
            showLoadingPanelWidget('#bloqueDatosInteres');
        },
        success: function(data) {
            $('#bloqueDatosInteres').html(data.html);
        },
        error: function(data) {
            alertErrorTopEnd('Ha ocurrido un error al cargar los datos estadísticos');
        },
        complete: function(data){
            showLoadingPanelWidget('#bloqueDatosInteres');
            $(".progress-new-bar").ProgressBar();
        }
    });
}

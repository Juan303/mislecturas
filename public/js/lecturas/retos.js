$(document).ready(function() {
    loadRetoActual();
    $("#formRegistroConfigurarReto").on('submit', function(e){
        e.preventDefault();
        registrarRetoActual($(this).serialize());
    });
});

//Le pasamos el año actual por defecto
function loadRetoActual(){
    return $.ajax({
        url: '/lecturas/retos/loadRetoActual',
        type: 'GET',
        success: function(data) {
            $('#bloqueRetoActual').html(data.html);
        },
        error: function(data) {
            alertErrorTopEnd('Ha ocurrido un error al cargar los datos del reto actual');
        },
        complete: function(data){
            $(".progress-new-bar").ProgressBar();
        }
    });
}

function registrarRetoActual(datos){
    $.ajax({
        type: 'PUT',
        url: '/lecturas/retos/storeReto',
        data: datos,
        success: function(data){
            loadRetoActual();
            $('#ModalConfigurarReto').modal('hide');
        }
    });
}
$(document).ready(function() {
    var anyoActual = new Date().getFullYear();
    loadResumen(anyoActual).then(function(){
        accionesLectura();
    });

    $("#selectAnyo, #selectTipo").on('change', function(){
        var anyo = $(this).val();
        loadResumen().then(function(){
            accionesLectura();
        });
    });
    loadResumen(anyoActual).then(function(){
        accionesLectura();
    });
});

//Le pasamos el año actual por defecto
function loadResumen(){
    return $.ajax({
        url: '/lecturas/loadResumen',
        data: {
            _token: $('input[name=_token]').val(),
            anyo: $("#selectAnyo").val(),
            tipo: $("#selectTipo").val()
        },
        type: 'POST',
        success: function(data) {
            $('#bloqueResumen').html(data.html);
            $('#lecturasTotales').html(data.totales);
        },
        error: function(data) {
            alertErrorTopEnd('Ha ocurrido un error al cargar el resumen');
        }
    });
}
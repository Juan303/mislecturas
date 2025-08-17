$(document).ready(function(){

   //Inicializamos las tablas
   $('#tablaRegistrosLectura').bootstrapTable({
      locale: 'es-ES',
      classes: 'table-no-bordered',
      pagination: false,
      showFooter: false,
      height: '100vh',
      fixedHeader: true,
      onPostHeader: function() {
         $('.fixed-table-container').css('padding-bottom', '0');
      }
   });
});

function loadHeightTableFixedHeader(content) {
      var height = 25;
      $(content).css('max-height', 'calc('+height+'vh)');
      //centramos la ventana modal teniendo en cuenta su altura
}

function showLoadingPanelWidget(elem){
    $(elem+' .widgetLoaderPanel').removeAttr('hidden');
}
function hideLoadingPanelWidget(elem){
    $(elem+' .widgetLoaderPanel').attr('hidden', true);
}

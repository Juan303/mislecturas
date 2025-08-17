function incrementoPaginasFormatter(value, row, index) {
    if(index === $('#tablaRegistrosLectura').bootstrapTable('getData').length - 1) return row.PaginasLeidas;
    var registroAnterior = $('#tablaRegistrosLectura').bootstrapTable('getData')[index + 1];
    return row.PaginasLeidas - registroAnterior.PaginasLeidas
}

function porcentajePaginasFormatter(value, row, index) {
    var paginasTotales = $("#paginasTotales").val();
    return (row.PaginasLeidas * 100 / paginasTotales).toFixed(2) + '%';
}

//==================================== Fechas
function fechaHoraFormatter(value, row, index) {
    return moment(value).format('DD/MM/YYYY HH:mm:ss');
}
function fechaFormatter(value, row, index) {
    return moment(value).format('DD/MM/YYYY');
}
function horaFormatter(value, row, index) {
    return moment(value).format('HH:mm:ss');
}

function fechaFormatterNombreMes(value, row, index) {
    var labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    if(Number.isInteger(value)){
        return labels[value - 1];
    }
    return labels[moment(value).month()];
}

function numberFormatterWith0Decimals(value, row, index) {
    return new Intl.NumberFormat('de-DE', { maximumFractionDigits: 0 }).format(parseFloat(row[this.field] || 0));
}
function numberFormatterWith1Decimals(value, row, index) {
    return new Intl.NumberFormat('de-DE', { maximumFractionDigits: 1 }).format(parseFloat(row[this.field] || 0));
}
function numberFormatterWith2Decimals(value, row, index) {
    return new Intl.NumberFormat('de-DE', { maximumFractionDigits: 2 }).format(parseFloat(row[this.field] || 0));
}
function monedaFormatterWith0Decimals(value, row, index) {
    return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(parseFloat(row[this.field] || 0));
}
function monedaFormatterWith1Decimals(value, row, index) {
    return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR', maximumFractionDigits: 1 }).format(parseFloat(row[this.field] || 0));
}
function monedaFormatterWith2Decimals(value, row, index) {
    return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR', maximumFractionDigits: 2 }).format(parseFloat(row[this.field] || 0));
}
function porcentajeFormatter(value, row, index) {
    return (value) ? value.toFixed(2) + '%' : '';
}
function sumaNumberFooterFormatterWith0Decimals(data) {
    return new Intl.NumberFormat('de-DE', { maximumFractionDigits: 0 }).format(data.reduce((sum, row) => sum + parseFloat(row[this.field] || 0), 0));
}
function sumaNumberFooterFormatterWith1Decimals(data) {
    return new Intl.NumberFormat('de-DE', { maximumFractionDigits: 1 }).format(data.reduce((sum, row) => sum + parseFloat(row[this.field] || 0), 0));
}
function sumaNumberFooterFormatterWith2Decimals(data) {
    console.log(data);
    //hay que tener en cuenta que pueden haber valores nulos. Hay que evitar que el resultado sea NaN
    return new Intl.NumberFormat('de-DE', { maximumFractionDigits: 2 }).format(data.reduce((sum, row) => sum + parseFloat(row[this.field] || 0), 0));
}
function sumaMonedaFooterFormatterWith0Decimals(data) {
    return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(data.reduce((sum, row) => sum + parseFloat(row[this.field] || 0), 0));
}
function sumaMonedaFooterFormatterWith1Decimals(data) {
    return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR', maximumFractionDigits: 1 }).format(data.reduce((sum, row) => sum + parseFloat(row[this.field] || 0), 0));
}
function sumaMonedaFooterFormatterWith2Decimals(data) {
    return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR', maximumFractionDigits: 2 }).format(data.reduce((sum, row) => sum + parseFloat(row[this.field] || 0), 0));
}
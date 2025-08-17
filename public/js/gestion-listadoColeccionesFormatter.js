function tablaListadoColeccionesFormatterActionsRow(value, row, index) {
    botones = [];
    botones.push(`<a role="button" class="fas fa-eye" title="Ver" href="/colecciones/coleccion/${row.id}"></a>`);
    return botones.join(' ');
}
function tablaListadoAutoresFormatterActionsRow(value, row, index) {
    botones = [];
    botones.push(`<a role="button" class="fas fa-eye" title="Ver" onclick="detallesObrasAutor(${index})"></a>`);
    return botones.join(' ');
}
function coleccionandoFormatter(value, row, index) {
    return row.coleccionando ? '<span class="fas fa-check"></span>' : '';
}

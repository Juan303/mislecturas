function nombreFormatter(value, row, index) {
    console.log(row);
    let nombre = row.tituloColeccion + ' ' + (row.numero ? '#' + row.numero : '') + ' '
    //Si es movil se trunca a 15 caracteres
    var url = row.tipoLectura == 'manga' ? 'colecciones/coleccion/'+row.coleccion_id : 'libros/edit/'+row.id;
    if(window.innerWidth < 768){
        if(nombre && nombre.length > 25) return `<a href="${url}">${nombre.substring(0, 25) + '...'}</a>`;
    }
    return `<a href="${url}">${nombre}</a>`;
}

function precioFormatter(value, row, index) {
    return  parseFloat(row.precio || 0).toFixed(2) + ' €';
}

function sumatorioFooterFormatter(data) {
    return data.reduce((sum, row) => sum + parseFloat(row.precio || 0), 0).toFixed(2)+ ' €';
}

function totalTextFooterFormatter(data) {
    return 'Total';
}

function tipoFormatter(value, row, index) {
    return row.tipoCompra || row.tipoLectura;
}

function tablaEstadisticasComprasFormatterActionsRow(value, row, index) {
    botones = [];
    botones.push(`<span role="button" class="fas fa-eye cursor-pointer" title="Ver" onclick="mostrarDetallesCompraMes(${index}, ${row.mes})"></span>`);
    return botones.join(' ');
}

function tablaEstadisticasLecturasFormatterActionsRow(value, row, index) {
    botones = [];
    botones.push(`<span role="button" class="fas fa-eye cursor-pointer" title="Ver" onclick="mostrarDetallesLecturaMes(${index}, ${row.mes})"></span>`);
    return botones.join(' ');
}


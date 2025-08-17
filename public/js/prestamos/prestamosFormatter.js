function tablaPrestamosHechosFormatterActionsRow(value, row, index) {
    var botones = [];
    //Devolver prestamo
    botones.push(
        `<i class="fas fa-undo cursor-pointer" title="Devolver" onclick="devolverPrestamo('${row.item_id}', '1', '${row.tipo}')"></i>`
    );

    return botones.join(' ');
}

function tablaPrestamosRecibidosFormatterActionsRow(value, row, index) {
   //Devolver prestamo
    var botones = [];
    botones.push(
        `<i class="fas fa-undo cursor-pointer" title="Devolver" onclick="devolverPrestamo('${row.item_id}', '0', '${row.tipo}')"></i>`
    );
    return botones.join(' ');
}
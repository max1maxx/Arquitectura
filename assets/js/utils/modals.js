/*
 * ----------------------------------------------------------------------------
 * Propiedad de <Armando Josue Velasquez Delgado> <<https://armandovelasquez.com>>
 * Todos los derechos reservados. Ninguna parte de este software puede ser 
 * reproducida, distribuida o transmitida de ninguna forma o por ningún medio, 
 * electrónico o mecánico, incluyendo fotocopias, grabaciones o cualquier otro 
 * sistema de almacenamiento y recuperación de información, sin el permiso 
 * previo por escrito del autor.
 * ----------------------------------------------------------------------------
 */

/**
 * Abrir pop
 * @param {*} pop 
 */
function open_modal(pop) {
    // Mostrar popup
    $('#overlay').show(); // Mostrar fondo oscuro
    $(pop).show(); // Mostrar modal

    // Estilos de entrada
    $('#overlay').addClass('show'); // Añadir clase para mostrar fondo oscuro
    $(pop).addClass('show'); // Añadir clase para mostrar modal


    // Transicion de entrada de overlay
    $(pop).css({
        'opacity': '0'
    }).animate({
        'opacity': '1'
    }, 300);

    // Transicion de entrada de overlay
    $('#overlay').css({
        'opacity': '0'
    }).animate({
        'opacity': '1'
    }, 300);
}



/**
 * Cerrar pop
 * @param {*} pop 
 */
function closed_modal(pop) {
    // Opacidad de overlay con transicion
    $(pop).css({
        'opacity': '1'
    }).animate({
        'opacity': '0'
    }, 300);

    // Opacidad de overlay con transicion
    $('#overlay').css({
        'opacity': '1'
    }).animate({
        'opacity': '0'
    }, 300);

    // Ocultar overlide despues de .3s
    $(pop)
        .delay(300) // Agrega un retraso de 300 ms
        .queue(function (next) {
            $(this).removeClass('show'); // Elimina la clase 'show'
            $(this).hide(); // Elimina la clase 'show'
            next();
        });

    // Ocultar overlide despues de .3s
    $('#overlay')
        .delay(300) // Agrega un retraso de 300 ms
        .queue(function (next) {
            $(this).removeClass('show'); // Elimina la clase 'show'
            $(this).hide(); // Elimina la clase 'show'
            next();
        });
}
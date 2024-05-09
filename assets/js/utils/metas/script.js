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

$(document).ready(function () {
    var lastWindowWidth = $(window).width();
    var resizeThreshold = 50; // Umbral de cambio de tamaño

    function cargarDatosEnTablaConFiltro() {
        var filtro = $('#filtro_metas').val().toLowerCase();
        if (checkbox1.is(':checked')) {
            cargarDatosInactivosEnTabla(paginaActual, filtro);
        } else {
            cargarDatosEnTabla(paginaActual, filtro);
        }
    }

    function toggleTableHeaders() {
        var windowWidth = $(window).width();
        var $responsiveStack = $(".table-responsive-stack");

        $responsiveStack.each(function () {
            var $table = $(this);
            var $thead = $table.find("thead");
            var $stackThead = $table.find(".table-responsive-stack-thead");

            cargarDatosEnTablaConFiltro();

            if (windowWidth <= 1325) {
                $stackThead.show();
                $thead.hide();
            } else {
                $stackThead.hide();
                $thead.show();
            }
        });

        lastWindowWidth = windowWidth; // Actualiza el último ancho de ventana
    }

    toggleTableHeaders();



// Funciona para actualizar los datos con la redimencion de la pagina
    $(window).on("resize", function () {
        var windowWidth = $(window).width();
        // Comprueba si el cambio de tamaño supera el umbral antes de volver a llamar a toggleTableHeaders()
        if (Math.abs(windowWidth - lastWindowWidth) > resizeThreshold) {
            toggleTableHeaders();
        }
    });
});
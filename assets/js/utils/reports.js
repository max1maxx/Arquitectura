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

// Botones de reporte en tabla
$(document).ready(function () {
    var id_usuario_accion = G_id_usuario;
    var id_rol_accion = G_id_rol;
    var relPath = definirNivel();
    var urlAjax;
    var estado;
    var checkbox = $('#switch-desactivados1');


    // Tabla de usuarios
    if (urlActual.includes(ruta_registro_usuario)) {
        var copy_table = '#copy_table_usuario';
        var excel_table = '#excel_table_usuario';
        var csv_table = '#csv_table_usuario';
        var idFiltro = '#filtro_usuario';
        var nombre_documento = 'usuarios';
        urlAjax = relPath + "controllers/Utils/user.php?arqui=copy_portapapeles_activo";
        estado = 'activo';

        checkbox.change(function () {
            if (checkbox.is(':checked')) {
                urlAjax = relPath + "controllers/Utils/user.php?arqui=copy_portapapeles_inactivo";
                estado = 'inactivo';
            } else {
                urlAjax = relPath + "controllers/Utils/user.php?arqui=copy_portapapeles_activo";
                estado = 'activo';
            }
        });
    }



    /**
     * Copiar datos en formato JSON al portapapeles
     */
    $(copy_table).click(function () {
        var filtro = $(idFiltro).val().toLowerCase();
        var extencion_archivo = "";

        $.post(urlAjax, { filtro: filtro, id_usuario_accion: id_usuario_accion, id_rol_accion: id_rol_accion, nombre_documento: nombre_documento, estado_documento: estado, extencion_archivo: extencion_archivo }, function (data) {
            try {
                // Convierte los datos a formato JSON
                var jsonData = JSON.stringify(data.output, null, 2);

                // Copia al portapapeles
                var $tempTextarea = $('<textarea>').val(jsonData).appendTo('body').select();
                document.execCommand('copy');
                $tempTextarea.remove();

                Swal.fire({
                    icon: 'success',
                    title: '¡Copiado!',
                    text: 'Se a copiado los datos al portapapeles en formato JSON.',
                    confirmButtonText: 'Aceptar'
                });
            } catch (error) {
                console.error('Error al copiar al portapapeles:', error);
            }
        });
    });



    /**
     * Descargar tabla en excel
     */
    $(excel_table).click(function () {
        var filtro = $(idFiltro).val().toLowerCase();
        var extencion_archivo = ".xlsx";

        $.post(urlAjax, { filtro: filtro, id_usuario_accion: id_usuario_accion, id_rol_accion: id_rol_accion, nombre_documento: nombre_documento, estado_documento: estado, extencion_archivo: extencion_archivo }, function (data) {
            try {
                // Convierte los datos a formato JSON
                var jsonData = data.output;

                // Crear el archivo Excel
                var tablaContenido = XLSX.utils.json_to_sheet(jsonData);
                var workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, tablaContenido, nombre_documento);

                // Crear blob y descargar
                var blob = new Blob([s2ab(XLSX.write(workbook, { bookType: 'xlsx', type: 'binary' }))], { type: 'application/octet-stream' });
                saveAs(blob, nombre_documento + (filtro !== '' ? '_' + filtro : '') + '_' + estado + extencion_archivo);
            } catch (error) {
                console.error('Error al crear el archivo Excel:', error);
            }
        });
    });

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    }



    /**
     * Descargar tabla en CSV
     */
    $(csv_table).click(function () {
        var filtro = $(idFiltro).val().toLowerCase();
        var extencion_archivo = ".csv";

        $.post(urlAjax, { filtro: filtro, id_usuario_accion: id_usuario_accion, id_rol_accion: id_rol_accion, nombre_documento: nombre_documento, estado_documento: estado, extencion_archivo: extencion_archivo }, function (data) {
            try {
                // Convierte los datos a formato JSON
                var jsonData = data.output;

                // Convertir a formato CSV
                var csvData = convertToCSV(jsonData);

                // Crear blob y descargar
                var blob = new Blob([csvData], { type: 'text/csv;charset=utf-8;' });
                saveAs(blob, nombre_documento + (filtro !== '' ? '_' + filtro : '') + '_' + estado + extencion_archivo);
            } catch (error) {
                console.error('Error al crear el archivo CSV:', error);
            }
        });
    });

    function convertToCSV(data) {
        var csvContent = "data:text/csv;charset=utf-8,";

        // Encabezados
        var headers = Object.keys(data[0]);
        csvContent += headers.join(",") + "\n";

        // Filas de datos
        data.forEach(function (row) {
            var values = headers.map(function (header) {
                return row[header];
            });
            csvContent += values.join(",") + "\n";
        });

        return encodeURI(csvContent);
    }
})
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

// Variable con la id
var G_id_usuario = $('#user_id_x').val();

/**
 * Cargar la informacion
 */
function cargar_informacion() {
    $.post("controllers/Utils/user.php?arqui=mostrar_informacion_usuario", { id_usuario: G_id_usuario })
        .then(function (data) {
            data = JSON.parse(data);
            $('#nombre_usuario').val(data.nombre_usuario);
            $('#apellido_usuario').val(data.apellido_usuario);
            $('#dni_usuario').val(data.dni_usuario);
            $('#correo_usuario').val(data.correo_usuario);

            // Mostrar la imagen en base64 si está presente en los datos
            if (data.foto_usuario) {
                $('#imagenPrevisualizacion').attr('src', 'data:image/jpeg;base64,' + data.foto_usuario);
            }

            // Agregar un pequeño retraso antes de establecer el valor del país y del telefono
            setTimeout(function () {
                $('#telefono_usuario').val(data.telefono_usuario);
            }, 75); // Espera 100 milisegundos 
            setTimeout(function () {
                $('#id_pais').val(data.id_pais).trigger("change");
            }, 50); // Espera 100 milisegundos

        })
        .fail(function (xhr, status, error) {
            console.error('Error al obtener los datos del usuario:', error);
        });
}



/**
 * Sincronizar la carga de datos para obtener los paises y los datos del usuario
 */
function sincronizar_carga() {
    var obtenerPaisesPromise = obtenerPaises();

    // Crear una Promesa para obtener los datos del usuario
    var obtenerDatosUsuarioPromise = cargar_informacion();

    // Esperar a que ambas Promesas se completen
    $.when(obtenerPaisesPromise, obtenerDatosUsuarioPromise)
        .then(function () {
            // Una vez que ambas Promesas se completen, puedes realizar cualquier otra acción necesaria aquí
            // console.log('Todas las solicitudes se completaron con éxito.');
        })
        .fail(function (error) {
            // console.error('Error en una o ambas solicitudes:', error);
        });
}



/**
 * Obtener los datos del usuario
 */
$(document).ready(function () {
    // Crear una Promesa para obtener los países
    validacionPaisCampos();

    // Obtener la informacion en los campos
    sincronizar_carga();
});



/**
 * Actualizar usuario
 */
$(document).on("click", "#btnactualizar", function () {

    // Verificar si se está insertando un nuevo usuario o actualizando uno existente
    var cedula = $('#dni_usuario').val();
    var correo = $('#correo_usuario').val();

    var imageInput = $('#file-input')[0];
    var imageFile = imageInput.files[0];

    // Obtener los datos del usuario para la funcion
    $.post("controllers/Utils/user.php?arqui=mostrar_informacion_usuario", { id_usuario: G_id_usuario }, function (data) {
        data = JSON.parse(data);

        // Validar campos antes de enviar el formulario
        if (!validarCampos()) {
            return; // No enviar el formulario si hay campos vacíos
        }

        // Realizar la validación de la cédula
        validarCedula(cedula, function (resultado) {

            // Permitir actualizar el usuario con una cedula diferente o con la que ya tenia
            if (resultado === 'existe' && cedula != data.dni_usuario) {

                // Si la cedula ya existe, mostrar un mensaje de advertencia
                var message_exist = 'La cédula ya está registrada.';
                alert_exist(message_exist);

            } else {
                // Realizar la validación de la cédula
                validarCorreo(correo, function (resultado) {

                    // Permitir actualizar el usuario con una cedula diferente o con la que ya tenia
                    if (resultado === 'existe' && correo != data.correo_usuario) {

                        // Si el correo ya existe, mostrar un mensaje de advertencia
                        var message_exist = 'El correo ya está registrado.';
                        alert_exist(message_exist);

                    } else {
                        // Agrega la funcion para verificar la contraseña
                        var agregar_funcion = function () { seleccionar_actualizacion(imageFile) };
                        validar_contraseña_alert(G_id_usuario, agregar_funcion);
                    }
                })
            }
        })
    })
});

// Actualizar datos del perfil
function actualizar_datos(dataObject) {
    $.post("controllers/Utils/user.php?arqui=actualizar_perfil", dataObject)
        .done(function (data) {
            data = JSON.parse(data);

            if (data.status === "success") {
                alert_success(data);
            } else {
                alert_error(data);
            }

        }).fail(function (error) {
            // Mostrar alerta en caso de error en la llamada AJAX
            alert_ajax();
        });
}

// Selecciona si se actualiza con imagen
function seleccionar_actualizacion(imageFile) {
    var dataObject = {
        id_usuario: G_id_usuario,
        nombre_usuario: $('#nombre_usuario').val(),
        apellido_usuario: $('#apellido_usuario').val(),
        id_pais: $('#id_pais').val(),
        dni_usuario: $('#dni_usuario').val(),
        telefono_usuario: $('#telefono_usuario').val(),
    };

    // Si existe una imagen subida
    if (imageFile) {
        // Verificar el tamaño de la imagen (por ejemplo, si es mayor de 1.5 MB)
        if (imageFile.size > 1.5 * 1024 * 1024) {

            // Alerta si el tamaño de la imagen es demaciado grande
            var icon = "warning";
            var title = "Error al cargar la foto";
            var message = "La foto es demasiado grande. Por favor, seleccione una foto menor a 1.5 MB.";
            alert_validar_exist(icon, title, message);
            return; // No continuar con la operación si la imagen es demasiado grande
        }

        var reader = new FileReader();
        reader.onload = function (event) {
            var imageData = event.target.result;
            dataObject.foto_usuario = imageData.split(',')[1];

            actualizar_datos(dataObject);
        };
        reader.readAsDataURL(imageFile);

    } else {
        // Si no existe una imagen subida
        dataObject.foto_usuario = null;
        actualizar_datos(dataObject);
    }
}




/**
 * Cambiar contraseña
 */
$(document).on("click", "#cambio_contrasenia", function () {
    cambiar_contraseña();
});




/**
 * Eliminar foto
 */
function eliminar_foto(dataObject) {
    $.post("controllers/Utils/user.php?arqui=eliminar_foto", dataObject, function (data) {
        data = JSON.parse(data);
        if (data.status === "success") {

            // Alerta de exito
            alert_success(data);
            $('#imagenPrevisualizacion').attr('src', 'assets/img/default/Default-User.svg');
        } else {

            // Alerta de error
            alert_error(data);
        }
    })

}

// verificacion para eliminar la foto de perfil
function verificacion_eliminar_foto() {

    var image = document.getElementById('imagenPrevisualizacion');

    if (image.src.indexOf('Default-User.svg') === -1) {

        var dataObject = {
            id_usuario: G_id_usuario
        }
        // Agrega la funcion para verificar la contraseña
        var agregar_funcion = function () { eliminar_foto(dataObject) };

        eliminar_foto_alert(G_id_usuario, agregar_funcion);
    } else {

        var data = {
            message: "No existe una foto para eliminar..."
        };
        alert_error(data)
    }
}
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

var G_id_usuario = $('#user_id_x').val();
var G_id_rol = $('#rol_id_x').val();

/**
 * Alerts Staticos
 * @param {*} data 
 */
// Alerta cuando no se puede eliminar un registro en concreto
function alert_oops() {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'No puedes eliminar este registro!',
    })
}

// Alerta cuando ocurre un error en la solicitud ajax
function alert_ajax() {
    Swal.fire({
        title: 'Error!',
        text: 'Hubo un error en la solicitud AJAX.',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

// Alerta cuando hay campos vacios
function alert_vacios() {
    Swal.fire({
        title: 'Error!',
        text: 'Por favor, complete todos los campos.',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

// Alert cuando los hay algun error de carga
function alert_error_load() {
    Swal.fire({
        icon: 'error',
        title: 'Verifique si los datos ingresados son correctos!',
        text: 'Si aún presenta problemas, contacte a un administrador.',
        confirmButtonText: 'Aceptar'
    });
}




/**
 * Alerts una variable
 * @param {*} data 
 */
// Alerta cuando un mensaje es enviado con exito
function alert_success(data) {
    Swal.fire({
        title: 'Correcto!',
        text: data.message,
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
}

// Alerta cuando hay un error en el envio
function alert_error(data) {
    Swal.fire({
        title: 'error!',
        text: data.message,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

// Alerta cuando ya existe lo q se esta registrando
function alert_exist(message_exist) {
    Swal.fire({
        title: 'Ya registrado!',
        text: message_exist,
        icon: 'warning',
        confirmButtonText: 'Aceptar'
    });
}



/**
 * Alerts dos variables
 * @param {*} title 
 * @param {*} message 
 */
function alert_validar(title, message) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}



/**
 * Alerts tres variables
 * @param {*} icon 
 * @param {*} title 
 * @param {*} message 
 */
function alert_validar_exist(icon, title, message) {
    Swal.fire({
        icon: icon,
        title: title,
        text: message,
        confirmButtonText: 'Aceptar'
    });
}



/**
 * Cambiar contraseña
 */
function cambiar_contraseña() {
    Swal.fire({
        icon: 'warning',
        title: 'Cambiar contraseña',
        html: `
                <input id="currentPassword" name="currentPassword" type="password" class="input input_passw" placeholder="Contraseña actual" autocomplete="off">
                <span class="sub_nueva_contraseña">Nueva contraseña</span>
                <input id="newPassword" type="password" class="input input_passw" placeholder="Nueva contraseña" autocomplete="off">
                <input id="repeatPassword" type="password" class="input input_passw" placeholder="Repetir contraseña" autocomplete="off">
            `,
        showCancelButton: true,
        confirmButtonColor: '#009c8c',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const repeatPassword = document.getElementById('repeatPassword').value;

            // Realiza tu lógica de validación aquí
            if (currentPassword === "" || newPassword === "") {

                Swal.showValidationMessage('Hay campos vacíos!');
                return false;
            } else if (newPassword !== repeatPassword) {

                Swal.showValidationMessage('Las contraseñas no coinciden!');
                return false;
            } else {
                return { currentPassword, newPassword };
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            const { currentPassword, newPassword } = result.value;

            // Ahora, puedes enviar la contraseña actual y la nueva contraseña al servidor
            $.post("controllers/Utils/user.php?arqui=actualizar_contrasenia", {
                id_usuario: G_id_usuario,
                currentPassword: currentPassword,
                newPassword: newPassword
            }).done(function (data) {
                data = JSON.parse(data);

                if (data.status === "success") {
                    alert_success(data);
                } else {
                    alert_validar(data.title, data.message);
                }

            }).fail(function (error) {
                alert_ajax();
            });
        }
    });
}



/**
 * Validar contraseña
 * @param {*} id_usuario 
 * @param {*} agregar_funcion 
 */
function validar_contraseña_alert(id_usuario, agregar_funcion) {
    Swal.fire({
        icon: 'warning',
        title: 'Ingrese su contraseña',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        cancelButtonText: 'Cancelar',
        showCancelButton: true,
        confirmButtonColor: '#009c8c',
        confirmButtonText: 'Confirmar',
        showLoaderOnConfirm: true,

        preConfirm: (passwd) => {

            // Realiza tu lógica de validación aquí
            if (passwd === "") {
                Swal.showValidationMessage('Hay campos vacíos!');
            } else {
                return passwd;
            }

        }, allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            const passwd = result.value;

            var verify_pass = {
                id_usuario: id_usuario,
                passwd: passwd
            }

            $.post("controllers/Utils/user.php?arqui=verificar_contraseña", verify_pass)
                .done(function (data) {
                    data = JSON.parse(data);

                    if (data.status === "success") {
                        // Funciona a ejecutar cuando se realize la acción
                        agregar_funcion();
                    } else {
                        alert_validar(data.title, data.message);
                    }
                })
        }
    });
}



/**
 * Funcion para ejecutar la alerta de eliminar
 * @param {*} id
 * @param {*} id_tabla
 * @param {*} texto 
 * @param {*} buttonColor 
 * @param {*} buttonText 
 * @param {*} eliminar 
 * @param {*} estado 
 * @param {*} url_ajax 
 * @param {*} cargarDatos 
 */
function eliminarAlerta(id, id_tabla, texto, buttonColor, buttonText, eliminar, estado, url_ajax, cargarDatos) {

    var dataObject = {};
    dataObject[id_tabla] = id;
    dataObject['id_usuario_accion'] = G_id_usuario;
    dataObject['id_rol_accion'] = G_id_rol;

    swal.fire({
        title: "Eliminar registro?",
        text: "Puede eliminarlo o solo " + texto + ".",
        icon: "error",
        confirmButtonColor: "#E74C3C",
        confirmButtonText: "Eliminar",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        showDenyButton: true,
        denyButtonColor: buttonColor,
        denyButtonText: buttonText,
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(url_ajax + eliminar, dataObject, function (data) {
                data = JSON.parse(data);
                if (data.status === "success") {

                    // Alerta de exito
                    alert_success(data);
                    cargarDatos();
                } else {

                    // Alerta de error
                    alert_error(data);
                }
            });
        } else if (result.isDenied) {
            $.post(url_ajax + estado, dataObject, function (data) {
                data = JSON.parse(data);
                if (data.status === "success") {

                    // Alerta de exito
                    alert_success(data);
                    cargarDatos();
                } else {

                    // Alerta de error
                    alert_error(data);
                }
            });
        }
    });
}


/**
 * Eliminar foto de usuario
 * @param {*} id_usuario 
 * @param {*} agregar_funcion 
 */
function eliminar_foto_alert(id_usuario, agregar_funcion) {
    Swal.fire({
        title: '¿Eliminar foto?',
        text: "Se eliminara la foto actual.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#27AE60',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            validar_contraseña_alert(id_usuario, agregar_funcion);
        }
    })
}



/**
 * Cambiar contraseña
 * @param {*} id_usuario 
 */
function cambiar_contraseña_alert(id_usuario) {
    Swal.fire({
        title: "Cambiar la contraseña",
        input: "password",
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Actualizar",
        showLoaderOnConfirm: true,
        preConfirm: async (password_usuario) => {
            if (password_usuario === "") {
                Swal.showValidationMessage('Hay campos vacíos!');
            } else {
                return password_usuario;
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            const password_usuario = result.value;

            var send_data = {
                id_usuario: id_usuario,
                password_usuario: password_usuario
            }

            $.post("../controllers/Utils/user.php?arqui=cambiar_contraseña", send_data)
            .done(function (data) {
                data = JSON.parse(data);

                if (data.status === "success") {
                    alert_success(data)
                } else {
                    alert_error(data);
                }
            })
     
        }
    });
}
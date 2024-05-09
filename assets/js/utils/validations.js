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
 * Obtener datos en list cuando se tiene activos o inactivos
 * Paises
 */

// Obtener todos los paises de la base de datos
function obtenerPaises() {
  var relPath = definirNivel();
  // Designar la URL Ajax dependiendo del directorio actual
  var urlAjax = relPath + "controllers/Utils/user.php?arqui=obtener_paises";

  todosPais(urlAjax);
}

// Obtener todos los paises activos de la base de datos
function obtenerPaises_activos() {
  var relPath = definirNivel();
  // Designar la URL Ajax dependiendo del directorio actual
  var urlAjax =
    relPath + "controllers/Utils/user.php?arqui=obtener_paises_activos";

  todosPais(urlAjax);
}

// Elementos comunes de obtener pais
function todosPais(urlAjax) {
  // Realizar una solicitud AJAX para obtener los países
  $.post(
    urlAjax,
    function (data) {
      var select = $("#id_pais");

      // Limpiar el select antes de agregar nuevas opciones
      select.empty();

      // Agregar la opción predeterminada "Seleccione"
      select.append(
        $("<option>", {
          value: "", // Valor vacío
          text: "Seleccione", // Texto que se mostrará
        })
      );

      // Agregar las opciones de países desde los datos JSON obtenidos
      $.each(data, function (key, value) {
        var option = $("<option>", {
          value: value.id_pais,
          text: value.nombre_pais,
        });

        // Asignar el valor del prefijo como atributo personalizado
        option.attr("data-prefijo-codigo-pais", value.prefijo_pais);

        select.append(option);
      });
    },
    "json"
  ).fail(function (xhr, status, error) {
    console.error("Error al obtener los países:", error);
  });
}

/**
 * Obtener datos en list
 * Roles
 */
// Obtener la lista de los roles existentes
function obtenerRoles() {
  var relPath = definirNivel();
  // Designar la URL Ajax dependiendo del directorio actual
  var urlAjax = relPath + "controllers/Utils/user.php?arqui=obtener_roles";

  todosRoles(urlAjax);
}

function todosRoles(urlAjax) {
  // Realizar una solicitud AJAX para obtener los roles
  $.post(
    urlAjax,
    function (data) {
      var select = $("#id_rol");

      // Limpiar el select antes de agregar nuevas opciones
      select.empty();

      // Agregar la opción predeterminada "Seleccione"
      select.append(
        $("<option>", {
          value: "", // Valor vacío
          text: "Seleccione", // Texto que se mostrará
        })
      );

      // Agrega las opciones de roles desde los datos JSON obtenidos
      $.each(data, function (key, value) {
        select.append(
          $("<option>", {
            value: value.id_rol,
            text: value.nombre_rol,
          })
        );
      });
    },
    "json"
  ).fail(function (xhr, status, error) {
    console.error("Error al obtener los roles:", error);
  });
}
/**
 * Obtener datos en list
 * Objetivos
 */
// Obtener la lista de los objetivos existentes

function obtenerObjetivos() {
  var relPath = definirNivel();
  // Designar la URL Ajax dependiendo del directorio actual
  var urlAjax =
    relPath + "controllers/Utils/indicadores.php?arqui=obtener_objetivos_activos";

  todosObjetivos(urlAjax);
}

function todosObjetivos(urlAjax) {
  // Realizar una solicitud AJAX para obtener los roles
  $.post(
    urlAjax,
    function (data) {
      var select = $("#id_obj");

      // Limpiar el select antes de agregar nuevas opciones
      select.empty();

      // Agregar la opción predeterminada "Seleccione"
      select.append(
        $("<option>", {
          value: "", // Valor vacío
          text: "Seleccione", // Texto que se mostrará
        })
      );

      // Agrega las opciones de roles desde los datos JSON obtenidos
      $.each(data, function (key, value) {
        select.append(
          $("<option>", {
            value: value.id_obj,
            text: value.nombre_obj,
          })
        );
      });
    },
    "json"
  ).fail(function (xhr, status, error) {
    console.error("Error al obtener los objetivos:", error);
  });
}

/**
 * Obtener datos en list
 * Indicadores
 */
// Obtener la lista de los Indicadores existentes

function obtenerIndicadores() {
    var relPath = definirNivel();
    // Designar la URL Ajax dependiendo del directorio actual
    var urlAjax =
      relPath + "controllers/Utils/metas.php?arqui=obtener_indicadores_activos";
  
      todosIndicadores(urlAjax);
  }
  
  function todosIndicadores(urlAjax) {
    // Realizar una solicitud AJAX para obtener los roles
    $.post(
      urlAjax,
      function (data) {
        var select = $("#id_ind");
  
        // Limpiar el select antes de agregar nuevas opciones
        select.empty();
  
        // Agregar la opción predeterminada "Seleccione"
        select.append(
          $("<option>", {
            value: "", // Valor vacío
            text: "Seleccione", // Texto que se mostrará
          })
        );
  
        // Agrega las opciones de roles desde los datos JSON obtenidos
        $.each(data, function (key, value) {
          select.append(
            $("<option>", {
              value: value.id_ind,
              text: value.nombre_ind,
            })
          );
        });
      },
      "json"
    ).fail(function (xhr, status, error) {
      console.error("Error al obtener los indicadores:", error);
    });
  }

  /**
 * Obtener datos en list
 * Metas
 */
// Obtener la lista de los Metas existentes

function obtenerMetas() {
  var relPath = definirNivel();
  // Designar la URL Ajax dependiendo del directorio actual
  var urlAjax =
    relPath + "controllers/Utils/asignaciones.php?arqui=obtener_metas_activos";

    todosMetas(urlAjax);
}

function todosMetas(urlAjax) {
  // Realizar una solicitud AJAX para obtener los roles
  $.post(
    urlAjax,
    function (data) {
      var select = $("#id_met");

      // Limpiar el select antes de agregar nuevas opciones
      select.empty();

      // Agregar la opción predeterminada "Seleccione"
      select.append(
        $("<option>", {
          value: "", // Valor vacío
          text: "Seleccione", // Texto que se mostrará
        })
      );

      // Agrega las opciones de roles desde los datos JSON obtenidos
      $.each(data, function (key, value) {
        select.append(
          $("<option>", {
            value: value.id_met,
            text: "I-MET-00" + value.id_met,
          })
        );
      });
    },
    "json"
  ).fail(function (xhr, status, error) {
    console.error("Error al obtener las metas:", error);
  });
}

/**
 * Validaciones de campos con el país correspondiente
 */
function validacionPaisCampos() {
  // Variables para almacenar el valor inicial y el prefijo
  var prefijoInicial = "";
  var valorInicial = "";

  // Cuando cambia la selección en el campo id_pais
  $("#id_pais").change(function () {
    var selectedOption = $(this).val(); // Obtiene el valor de la opción seleccionada

    if (
      urlActual.includes(ruta_registro_usuario) ||
      urlActual.includes(ruta_perfil) ||
      urlActual.includes(ruta_login)
    ) {
      // Verifica si se ha seleccionado una opción válida (no vacía)
      if (selectedOption !== "") {
        // Obtén el valor del prefijoCodigoPais de la opción seleccionada
        prefijoInicial = $("option:selected", this).attr(
          "data-prefijo-codigo-pais"
        );

        // Asigna el valor de prefijoCodigoPais al campo telefono_usuario
        $("#telefono_usuario").val(prefijoInicial);

        // Habilita el campo telefono_usuario
        $("#telefono_usuario").prop("disabled", false);
        $("#dni_usuario").attr("placeholder", "Ingrese su número celular");
        $("#telefono_usuario").removeClass("inactive");

        // Habilita el campo dni_usuario
        $("#dni_usuario").prop("disabled", false);
        $("#dni_usuario").attr("placeholder", "Ingrese su identificación");
        $("#dni_usuario").removeClass("inactive");
      } else {
        // Si no se selecciona una opción, deshabilita el campo telefono_usuario
        $("#telefono_usuario").prop("disabled", true);
        $("#telefono_usuario").val("");
        $("#telefono_usuario").attr("placeholder", "Seleccione su país");
        $("#telefono_usuario").addClass("inactive");

        // Si no se selecciona una opción, deshabilita el campo dni_usuario
        $("#dni_usuario").prop("disabled", true);
        $("#dni_usuario").val("");
        $("#dni_usuario").attr("placeholder", "Seleccione su país");
        $("#dni_usuario").addClass("inactive");
      }
    }
  });

  // Definir las id de los campos de los telefonos

  if (
    urlActual.includes(ruta_registro_usuario) ||
    urlActual.includes(ruta_perfil)
  ) {
    var telefonoX = "#telefono_usuario";
  }

  // Agrega un evento keydown para evitar eliminar el prefijo
  $(telefonoX).on("keydown", function (e) {
    var telefono = $(this).val();

    // Obtiene el código de la tecla presionada
    var keyCode = e.which || e.keyCode;

    // Verifica si la tecla presionada es la tecla "Backspace" y si se intenta eliminar el prefijo
    if (keyCode === 8 && telefono === prefijoInicial) {
      e.preventDefault(); // Evita la eliminación
    }
  });

  // Agrega un evento input para revertir el valor si se intenta eliminar el prefijo
  $(telefonoX).on("input", function () {
    var telefono = $(this).val();

    // Verifica si el valor no contiene el prefijo
    if (!telefono.startsWith(prefijoInicial)) {
      // Restablece el valor del campo al valor inicial válido
      $(this).val(prefijoInicial);
    } else {
      // Almacena el valor actual como valor inicial válido
      valorInicial = telefono;
    }
  });

  // Agrega un evento input para validar que el primer número después del prefijo no sea cero
  $(telefonoX).on("input", function () {
    var telefono = $(this).val();

    // Obtiene el número inmediatamente después del prefijo
    var numeroDespuesDelPrefijo = telefono.substr(prefijoInicial.length, 1);

    // Verifica si el número inmediatamente después del prefijo es cero
    if (numeroDespuesDelPrefijo === "0") {
      // Elimina el cero
      $(this).val(prefijoInicial + telefono.substr(prefijoInicial.length + 1));
    }
  });
}

/**
 * Validaciones para correo electronico
 * @param {*} correo
 * @returns
 */
// Validar sintaxis del correo electronico
function validarCorreoElectronico(correo) {
  // Expresión regular para validar un correo electrónico
  var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

  // Verificar si el correo cumple con la expresión regular
  return regex.test(correo);
}

/**
 * Validar numero de celular
 * @param {*} idPais
 * @param {*} telefono
 * @returns
 */
// Funcion para validar numero de telefono
function validarNumeroCelular(idPais, telefono) {
  var title = "Teléfono inválido!";

  // Obtén el prefijo del país directamente del valor del select
  var prefijoCodigoPais = idPais;

  // Remueve espacios en blanco al inicio y al final del número de teléfono
  telefono = telefono.trim();

  // Verifica si el teléfono comienza con el prefijo del país
  if (telefono.startsWith(prefijoCodigoPais)) {
    // Verifica si el teléfono contiene solo el prefijo del país
    if (telefono.length === prefijoCodigoPais.length) {
      // Muestra una alerta para indicar que el teléfono es inválido
      var message =
        "Ingrese un número de teléfono para el prefijo (" +
        prefijoCodigoPais +
        ")";
      alert_validar(title, message);
      return false; // Retorna falso para indicar que la validación no ha pasado

      // Validacion para numero de telefono ecuatoriano
    } else if (telefono.startsWith("+593")) {
      // Verifica que el segundo dígito sea "9"
      if (telefono.charAt(4) === "9") {
        // Verifica si el teléfono tiene el formato correcto (incluyendo el prefijo), sin espacios ni otros caracteres no válidos.
        var formatoValido = /^\+593\d{9}$/; // Expresión regular para verificar el formato

        if (formatoValido.test(telefono)) {
          return true; // El número es válido
        } else {
          // Muestra una alerta para indicar que el número no es válido
          var message =
            "El número de teléfono móvil ecuatoriano debe tener el formato correcto, incluyendo el prefijo " +
            prefijoCodigoPais;
          alert_validar(title, message);
          return false; // Retorna falso para indicar que la validación no ha pasado
        }
      } else {
        // Muestra una alerta para indicar que el segundo dígito debe ser "9"
        var message =
          'El primer dígito después del prefijo debe ser "9" para un número de teléfono móvil Ecuatoriano';
        alert_validar(title, message);
        return false; // Retorna falso para indicar que la validación no ha pasado
      }

      // Validacion para numero de telefono de USA
    } else if (telefono.startsWith("+1")) {
      // Ejemplo de validación adicional para números de teléfono de EE. UU.:
      if (/^\+1\d{10}$/.test(telefono)) {
        return true; // El número es válido
      } else {
        // Muestra una alerta de SweetAlert2 para indicar que el número no es válido
        var message =
          "El número de teléfono de USA debe tener el formato correcto.";
        alert_validar(title, message);
        return false; // Retorna falso para indicar que la validación no ha pasado
      }

      // Aun no se designa alguna validacion
    } else {
      Swal.fire({
        icon: "error",
        title: "Contacte a un administrador!",
        text: "Aún no se asigna la validación para el número de teléfono.",
        confirmButtonText: "Aceptar",
      });
      return false; // Retorna falso para indicar que la validación no ha pasado
    }
  }
  return true; // Retorna verdadero si la validación pasa
}

/**
 * Validaciones para cedula o pasaporte
 * @param {*} idPais
 * @param {*} cedula
 * @returns
 */
function validarNumeroCedula(idPais, cedula) {
  // Obtén el prefijo del país directamente del valor del select
  var prefijoCodigoPais = idPais;

  // Validacion para el numero de cedula ecuatoriana (FALTA VALIDACION PARA PASAPORTE)
  if (prefijoCodigoPais == "+593") {
    //Preguntamos si la cedula consta de 10 digitos
    if (cedula.length == 10) {
      //Obtenemos el digito de la region que sonlos dos primeros digitos
      var digito_region = cedula.substring(0, 2);

      //Pregunto si la region existe ecuador se divide en 24 regiones
      if (digito_region >= 1 && digito_region <= 24) {
        // Extraigo el ultimo digito
        var ultimo_digito = cedula.substring(9, 10);

        //Agrupo todos los pares y los sumo
        var pares =
          parseInt(cedula.substring(1, 2)) +
          parseInt(cedula.substring(3, 4)) +
          parseInt(cedula.substring(5, 6)) +
          parseInt(cedula.substring(7, 8));

        //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
        var numero1 = cedula.substring(0, 1);
        var numero1 = numero1 * 2;
        if (numero1 > 9) {
          var numero1 = numero1 - 9;
        }

        var numero3 = cedula.substring(2, 3);
        var numero3 = numero3 * 2;
        if (numero3 > 9) {
          var numero3 = numero3 - 9;
        }

        var numero5 = cedula.substring(4, 5);
        var numero5 = numero5 * 2;
        if (numero5 > 9) {
          var numero5 = numero5 - 9;
        }

        var numero7 = cedula.substring(6, 7);
        var numero7 = numero7 * 2;
        if (numero7 > 9) {
          var numero7 = numero7 - 9;
        }

        var numero9 = cedula.substring(8, 9);
        var numero9 = numero9 * 2;
        if (numero9 > 9) {
          var numero9 = numero9 - 9;
        }

        var impares = numero1 + numero3 + numero5 + numero7 + numero9;

        //Suma total
        var suma_total = pares + impares;

        //extraemos el primero digito
        var primer_digito_suma = String(suma_total).substring(0, 1);

        //Obtenemos la decena inmediata
        var decena = (parseInt(primer_digito_suma) + 1) * 10;

        //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
        var digito_validador = decena - suma_total;

        //Si el digito validador es = a 10 toma el valor de 0
        if (digito_validador == 10) var digito_validador = 0;

        //Validamos que el digito validador sea igual al de la cedula
        if (digito_validador == ultimo_digito) {
          return true; // envia el formulario
        } else {
          // Valida si la cedula no es correcta
          var icon = "warning";
          var title = "Cédula Invalida!";
          var message = "Ingrese un número de Cédula Ecuatoriana.";
          alert_validar_exist(icon, title, message);

          return false; // Evita enviar el formulario
        }
      } else {
        // valida si la region no pertenece
        var icon = "warning";
        var title = "Cédula Invalida!";
        var message = "Esta Cédula no pertenece a ninguna región.";
        alert_validar_exist(icon, title, message);

        return false; // Evita enviar el formulario
      }
    } else {
      // Valida si la cedula no tiene 10 digitos
      var icon = "warning";
      var title = "Cédula Invalida!";
      var message = "La Cédula debe contener 10 dígitos.";
      alert_validar_exist(icon, title, message);

      return false; // Evita enviar el formulario
    }

    // Validacion para el numero de cedula USA
  } else if (prefijoCodigoPais == "+1") {
    // Valida si la cedula no es correcta
    var icon = "warning";
    var title = "Cédula Invalida!";
    var message = "Ingrese un número de identificación Estadounidense.";
    alert_validar_exist(icon, title, message);

    return false; // Evita enviar el formulario

    // Valida cuando no se ha agregado la validacion
  } else {
    alert_error_load();
    return false;
  }
}

/**
 * VALIDAR SI YA EXISTE LA CEDULA EN LA BASE DE DATOS CORRESPONDIENTE
 * @param {*} cedula
 * @param {*} callback
 */
// Función para validar si ya existe la cédula en la base de datos
function validarCedula(cedula, callback) {
  // Designa la ruta dependiendo del directorio en el que se encuentra
  var relPath = definirNivel();

  // Ruta del directorio de registro usuario
  if (urlActual.includes(ruta_registro_usuario)) {
    var urlAjax = relPath + "controllers/Utils/user.php?arqui=verificar_cedula";

    // Ruta del directorio de perfil
  } else if (urlActual.includes(ruta_perfil)) {
    var urlAjax = relPath + "controllers/Utils/user.php?arqui=verificar_cedula";

    // Ruta del directorio raiz para el login
  } else {
    var urlAjax = relPath + "controllers/Utils/user.php?arqui=verificar_cedula";
  }

  $.post(urlAjax, { cedula: cedula })
    .done(function (resultado) {
      callback(resultado);
    })
    .fail(function (error) {
      callback("error");
    });
}

/**
 * VALIDAR SI YA EXISTE EL CORREO EN LA BASE DE DATOS CORRESPONDIENTE
 * @param {*} correo
 * @param {*} callback
 */
// Función para validar si ya existe el correo en la base de datos
function validarCorreo(correo, callback) {
  // Designa la ruta dependiendo del directorio en el que se encuentra
  var relPath = definirNivel();

  // Ruta del directorio de registro usuario
  if (urlActual.includes(ruta_registro_usuario)) {
    var urlAjax = relPath + "controllers/Utils/user.php?arqui=verificar_correo";
    // Ruta del directorio de perfil
  } else if (urlActual.includes(ruta_perfil)) {
    var urlAjax = relPath + "controllers/Utils/user.php?arqui=verificar_correo";

    // Ruta del directorio raiz para el login
  } else {
    var urlAjax = relPath + "controllers/Utils/user.php?arqui=verificar_correo";
  }

  $.post(urlAjax, { correo: correo })
    .done(function (resultado) {
      callback(resultado);
    })
    .fail(function (error) {
      callback("error");
    });
}

function validar_soloNumeros(e) {
  return valida_codigo_asci(e, "0123456789");
}

function validar_soloLetras(e) {
    return valida_codigo_asci(e, " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ");
}

function validar_LetrasNumeros_otroscaracteres(e) {
    return valida_codigo_asci(e, " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789.-@/¿?#");
}

function valida_codigo_asci(e, formato_valida) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key);
  letras = formato_valida;
  especiales = [8, 13];
  tecla_especial = false;
  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
  if (letras.indexOf(tecla) == -1 && !tecla_especial) return false;
  else return true;
}

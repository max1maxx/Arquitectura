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
 * Validaciones
 */

$(document).ready(function () {
  // $("#linea_base_met, #denominador_met, #primer_trimestre_met, #segundo_trimestre_met, #tercer_trimestre_met").keypress(function (event) {
  //   return validar_soloNumeros(event);
  // });

  $("#nombre_obj, #descrip_obj").keypress(function (event) {
    return validar_LetrasNumeros_otroscaracteres(event);
  });
});

// Función para validar campos antes de enviar el formulario
function validarCampos() {
  var nombre_obj = $("#nombre_obj").val();
  var descrip_obj = $("#descrip_obj").val();

  // Verificar si algún campo está vacío
  if (
    nombre_obj === "" ||
    descrip_obj === ""
  ) {
    alert_vacios();
    return false; // Evita enviar el formulario si hay campos vacíos
  }
  return true; // Todos los campos están completos, puede enviar el formulario
}

/**
 * Validacion para texto
 * @param {*} txt
 * @returns
 */
function validarDosPalabrasSoloLetras(txt) {
  // Expresión regular que permite máximo dos palabras y solo letras
  var regex = /^[A-Za-z]+\s?[A-Za-z]*$/;

  // Verificar si el txt cumple con la expresión regular y no contiene números
  return regex.test(txt) && !/\d/.test(txt);
}

/**
 * Validacion para texto
 * @param {*} txt
 * @returns
 */
function validarUnaPalabraSoloLetras(txt) {
  // Expresión regular que permite una sola palabra y solo letras
  var regex = /^[A-Za-z]+$/;

  // Verificar si el txt cumple con la expresión regular y no contiene números
  return regex.test(txt) && !/\d/.test(txt);
}

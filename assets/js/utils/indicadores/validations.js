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
  $("#anio_ind").keypress(function (event) {
    return validar_soloNumeros(event);
  });

  $("#nombre_ind, #descrip_ind, #formula_ind").keypress(function (event) {
    return validar_LetrasNumeros_otroscaracteres(event);
  });
});

// Función para validar campos antes de enviar el formulario
function validarCampos() {
  var nombre_ind = $("#nombre_ind").val();
  var formula_ind = $("#formula_ind").val();
  var anio_ind = $("#anio_ind").val();
  var descrip_ind = $("#descrip_ind_usuario").val();
  var id_obj = $("#id_obj").val();

  // Verificar si algún campo está vacío
  if (
    nombre_ind === "" ||
    formula_ind === "" ||
    anio_ind === "" ||
    descrip_ind === "" ||
    id_obj === ""
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

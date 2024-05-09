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
  $("#cumpl_asig").keypress(function (event) {
    return validar_soloNumeros(event);
  });

  $("#obser_asig, #link_evidencia_asig").keypress(function (event) {
    return validar_LetrasNumeros_otroscaracteres(event);
  });
});

// Función para validar campos antes de enviar el formulario
function validarCampos() {
  var id_met = $("#id_met").val();
  var link_evidencia_asig = $("#link_evidencia_asig").val();
  var obser_asig = $("#obser_asig").val();
  var trimestre_asig = $("#descrip_ind_usuario").val();
  var cumpl_asig = $("#cumpl_asig").val();
  // Verificar si algún campo está vacío
  if (
    id_met === "" ||
    link_evidencia_asig === "" ||
    obser_asig === "" ||
    trimestre_asig === "" ||
    cumpl_asig === ""
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

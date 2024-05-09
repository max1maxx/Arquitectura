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

var G_id_usuario = $("#user_id_x").val();
var G_id_rol = $("#rol_id_x").val();

var checkbox1 = $("#switch-desactivados1");
var checkbox2 = $("#switch-desactivados2");

var registrosPorPagina = 5;
var paginaActual = 1;
var totalRegistros = 0;
var totalPaginas = 0;

/**
 * Abrir pop
 */
function abrir_pop() {
  var pop = "#pop_objetivos";
  open_modal(pop);
}

/**
 * Cerrar pop
 */
function cancelar() {
  var pop = "#pop_objetivos";
  closed_modal(pop);
}

/**
 * Actualiza la tabla con los registros actuales (incluyendo las filas vacías)
 * @param {*} pagina
 * @param {*} registros
 * @param {*} inicio
 * @param {*} fin
 */
function actualizarTabla(pagina, registros, inicio, fin) {
  var tablaBody = $("#tabla_objetivos tbody");
  tablaBody.empty();

  // Conteo de registros por pagina
  var tempContainer = $("<div></div>");
  tempContainer.html(registros);
  var cantidadDeFilas = tempContainer.find("tr").length;

  // Agregar registros
  tablaBody.html(registros);

  if (window.innerWidth > 1240) {
    // Si no hay suficientes registros para llenar la página, agregamos filas vacías
    if (cantidadDeFilas !== 0) {
      for (var i = cantidadDeFilas; i < registrosPorPagina; i++) {
        var filaVacia = '<tr><td colspan="13"></td></tr>';
        tablaBody.append(filaVacia);
      }
    }
  }
}

/**
 * Cargar datos en la tabla
 * @param {*} pagina
 * @param {*} filtro
 */
function cargarDatosEnTabla(pagina, filtro) {
  $.post(
    "../controllers/Utils/objetivos.php?arqui=listar",
    { pagina: pagina, filtro: filtro },
    function (data) {
      datosTabla(pagina, filtro, data);
    }
  );
}

/**
 * Cargar datos inactivos en la tabla
 * @param {*} pagina
 * @param {*} filtro
 */
function cargarDatosInactivosEnTabla(pagina, filtro) {
  $.post(
    "../controllers/Utils/objetivos.php?arqui=listar_inactivos",
    { pagina: pagina, filtro: filtro },
    function (data) {
      datosTabla(pagina, filtro, data);
    }
  );
}

/**
 * Datos que se cargan en la tabla
 * @param {*} pagina
 * @param {*} filtro
 * @param {*} data
 */
function datosTabla(pagina, filtro, data) {
  var tablaBody = $("#tabla_objetivos tbody");
  tablaBody.empty();

  var response = JSON.parse(data);

  if (response.totalResultados == 0) {
    tablaBody.html(
      '<tr><td colspan="13">Ningún dato disponible en la tabla</td></tr>'
    );
    totalRegistros = 0;
    totalPaginas = 0;
    $("#paginas").text("Página " + pagina + " de " + totalPaginas);
    $("#total-registros").text(totalRegistros);
  } else {
    totalRegistros = response.totalResultados;
    totalPaginas = response.totalPaginas;

    var inicio = (pagina - 1) * registrosPorPagina;
    var fin = inicio + registrosPorPagina;

    $("#paginas").text("Página " + pagina + " de " + totalPaginas);
    $("#total-registros").text(totalRegistros);

    actualizarTabla(pagina, response.output, inicio, fin);
  }
  // Llamar a la función para actualizar los botones
  actualizarBotones();
}

/**
 * Función para manejar la habilitación/deshabilitación de los botones
 */
function actualizarBotones() {
  var paginacionHTML =
    '<button class="button5 efects__button btn_navegacion" id="anterior"><i class="bx bx-chevrons-left"></i></button>';

  // Condicion para las primeras 5 paginas
  if (totalPaginas <= 5) {
    for (var i = 1; i <= totalPaginas; i++) {
      var claseActiva = i === paginaActual ? " pagination_btn_active" : "";
      paginacionHTML +=
        '<button class="button5 efects__button' +
        claseActiva +
        (i === paginaActual ? "" : " btn_navegacion") +
        '" id="pagina_' +
        i +
        '">' +
        i +
        "</button>";
    }
  } else {
    // Condicion primera mitad
    if (paginaActual <= 2) {
      for (var i = 1; i <= 4; i++) {
        //Numero de paginas inicio
        var claseActiva = i === paginaActual ? " pagination_btn_active" : "";
        paginacionHTML +=
          '<button class="button5 efects__button' +
          claseActiva +
          (i === paginaActual ? "" : " btn_navegacion") +
          '" id="pagina_' +
          i +
          '">' +
          i +
          "</button>";
      }
      paginacionHTML += '<span id="separador_inicio">...</span>';
      paginacionHTML +=
        '<button class="button5 efects__button btn_navegacion" id="pagina_' +
        totalPaginas +
        '">' +
        totalPaginas +
        "</button>";

      // Condicion segunda mitad
    } else if (paginaActual >= totalPaginas - 1) {
      paginacionHTML +=
        '<button class="button5 efects__button btn_navegacion" id="pagina_1">1</button>';
      paginacionHTML += '<span id="separador_final">...</span>';
      for (var i = totalPaginas - 3; i <= totalPaginas; i++) {
        //Numero de paginas fin
        var claseActiva = i === paginaActual ? " pagination_btn_active" : "";
        paginacionHTML +=
          '<button class="button5 efects__button' +
          claseActiva +
          (i === paginaActual ? "" : " btn_navegacion") +
          '" id="pagina_' +
          i +
          '">' +
          i +
          "</button>";
      }

      // Condicion central
    } else {
      paginacionHTML +=
        '<button class="button5 efects__button btn_navegacion" id="pagina_1">1</button>';

      if (paginaActual > 3) {
        paginacionHTML += '<span id="separador_inicio">...</span>';
      }

      for (var i = paginaActual - 1; i <= paginaActual + 1; i++) {
        var claseActiva = i === paginaActual ? " pagination_btn_active" : "";
        paginacionHTML +=
          '<button class="button5 efects__button' +
          claseActiva +
          (i === paginaActual ? "" : " btn_navegacion") +
          '" id="pagina_' +
          i +
          '">' +
          i +
          "</button>";
      }

      if (paginaActual < totalPaginas - 2) {
        paginacionHTML += '<span id="separador_final">...</span>';
      }
      paginacionHTML +=
        '<button class="button5 efects__button btn_navegacion" id="pagina_' +
        totalPaginas +
        '">' +
        totalPaginas +
        "</button>";
    }
  }

  paginacionHTML +=
    '<button class="button5 efects__button btn_navegacion" id="siguiente"><i class="bx bx-chevrons-right"></i></button>';

  $(".pagination").html(paginacionHTML);

  $("#siguiente").prop("disabled", paginaActual >= totalPaginas);
  $("#anterior").prop("disabled", paginaActual === 1);

  asignarEventos();
}

/**
 * Eventos para cambio de pagina
 */
function asignarEventos() {
  $("#anterior").click(function () {
    irAPagina("anterior");
  });

  $("#siguiente").click(function () {
    irAPagina("siguiente");
  });

  for (var i = 1; i <= totalPaginas; i++) {
    $("#pagina_" + i).click(function () {
      irAPagina($(this).text());
    });
  }
}

/**
 * Manejar la navegación a la página siguiente
 * @param {*} destino
 */
function irAPagina(destino) {
  if (destino === "siguiente" && paginaActual < totalPaginas) {
    paginaActual++;
  } else if (destino === "anterior" && paginaActual > 1) {
    paginaActual--;
  } else {
    var numeroPagina = parseInt(destino);
    if (!isNaN(numeroPagina)) {
      if (numeroPagina < 1) {
        numeroPagina = 1;
      } else if (numeroPagina > totalPaginas) {
        numeroPagina = totalPaginas;
      }
      paginaActual = numeroPagina;
    }
  }

  if (checkbox1.is(":checked")) {
    cargarDatosInactivosEnTabla(
      paginaActual,
      $("#filtro_objetivos").val().toLowerCase()
    );
  } else {
    cargarDatosEnTabla(paginaActual, $("#filtro_objetivos").val().toLowerCase());
  }
}

/**
 * Ejecuta cuando carga la pagina
 */
$(document).ready(function () {
  // Activar campos y agregar el prefijo del pais seleccionado
  validacionPaisCampos();

  // Ocultar pop al cargar la pagina
  $("#overlay").hide();
  $("#pop_objetivos").hide();

  // Obtener datos en los select
  // obtenerIndicadores();

  // Filtro para el buscador de la tabla
  $("#filtro_objetivos").on("input", function () {
    paginaActual = 1;

    if (checkbox1.is(":checked")) {
      cargarDatosInactivosEnTabla(paginaActual, $(this).val().toLowerCase());
    } else {
      cargarDatosEnTabla(paginaActual, $(this).val().toLowerCase());
    }
  });

  // Switch para el cambio a resultados desactivados y activados
  checkbox1.change(function () {
    $("#filtro_objetivos").val("");

    var subtitulo_objetivos = document.getElementById("subtitulo_objetivos");
    paginaActual = 1;

    if (checkbox1.is(":checked")) {
      subtitulo_objetivos.textContent = "Lista de objetivos inactivos";
      // Checkbox activado
      cargarDatosInactivosEnTabla(paginaActual, "");

      checkbox2.prop("checked", true);
    } else {
      subtitulo_objetivos.textContent = "Lista de objetivos";
      // Checkbox desactivado
      cargarDatosEnTabla(paginaActual, "");

      checkbox2.prop("checked", false);
    }
  });

  // Evento de cambio en el checkbox
  checkbox2.change(function () {
    $("#filtro_objetivos").val("");

    var subtitulo_objetivos = document.getElementById("subtitulo_objetivos");
    paginaActual = 1;

    if (checkbox2.is(":checked")) {
      subtitulo_objetivos.textContent = "Lista de objetivos inactivos";
      // Checkbox activado
      cargarDatosInactivosEnTabla(paginaActual, "");

      checkbox1.prop("checked", true);
    } else {
      subtitulo_objetivos.textContent = "Lista de objetivos";
      // Checkbox desactivado
      cargarDatosEnTabla(paginaActual, "");

      checkbox1.prop("checked", false);
    }
  });
});

/**
 * Eliminar regisstro
 * @param {*} id_resultado
 */
// Activo
function eliminarActivo(id_obj) {
  var id_tabla = "id_obj";
  var texto = "desactivarlo";
  var buttonColor = "#FFA500";
  var buttonText = "Desactivar";
  var eliminar = "eliminar";
  var estado = "desactivar";
  var url_ajax = "../controllers/Utils/objetivos.php?arqui=";
  var cargarDatos = function () {
    cargarDatosEnTabla(paginaActual, "");
  };

  eliminarAlerta(
    id_obj,
    id_tabla,
    texto,
    buttonColor,
    buttonText,
    eliminar,
    estado,
    url_ajax,
    cargarDatos
  );
}

// Inactivo
function eliminarInactivo(id_obj) {
  var id_tabla = "id_obj";
  var texto = "activarlo";
  var buttonColor = "#27AE60";
  var buttonText = "Activar";
  var eliminar = "eliminar";
  var estado = "activar";
  var url_ajax = "../controllers/Utils/objetivos.php?arqui=";
  var cargarDatos = function () {
    cargarDatosInactivosEnTabla(paginaActual, "");
  };

  eliminarAlerta(
    id_obj,
    id_tabla,
    texto,
    buttonColor,
    buttonText,
    eliminar,
    estado,
    url_ajax,
    cargarDatos
  );
}

// Eliminar
function eliminar(id_obj) {
  // Obtener los datos del usuario para la funcion
  $.post(
    "../controllers/Utils/objetivos.php?arqui=mostrar_informacion_objetivos",
    { id_obj: id_obj },
    function (data) {
      data = JSON.parse(data);
      if (data.id_estado == 1) {
        eliminarActivo(id_obj);
      } else if (data.id_estado == 2) {
        eliminarInactivo(id_obj);
      }
    }
  );
}

/**
 * Nuevo registro
 */
function nuevo() {
  // Agregar titulo al pop
  $("#pop_title_objetivos").html("NUEVO REGISTRO");

  // Restaurar valores
  $("#id_obj").val("");
  $("#objetivos_form")[0].reset();

  abrir_pop();
}

/**
 * Actualizar registro
 * @param {*} id_obj
 */
function editar(id_obj) {
  $.post(
    "../controllers/Utils/objetivos.php?arqui=mostrar_informacion_objetivos",
    { id_obj: id_obj },
    function (data) {
      data = JSON.parse(data);
      $("#id_obj").val(data.id_obj);
      $("#nombre_obj").val(data.nombre_obj);
      $("#descrip_obj").val(data.descrip_obj);
      // Agregar titulo al pop
      $("#pop_title_objetivos").html("EDITAR REGISTRO");

      abrir_pop();
    }
  );
}

// Funcion init
function init() {
  $("#objetivos_form").on("submit", function (e) {
    nuevo_actualizar(e);
  });

  $("#formulario_nodejs").on("submit", function (e) {
    nuevonodejs(e);
  });
}

/**
 * Función para enviar el formulario
 * @param {*} e
 * @returns
 */
function nuevo_actualizar(e) {
  e.preventDefault();
  var id_obj = $("#id_obj").val();
  // No existe un id_obj, por lo que se inserta uno nuevo
  if (!id_obj) {
    // Validar campos antes de enviar el formulario
    if (!validarCampos()) {
      return; // No enviar el formulario si hay campos vacíos
    }
    enviarFormulario(); // Agregar llamada a la función enviarFormulario
  } else {
    // Obtener los datos para la funcion
    $.post(
      "../controllers/Utils/objetivos.php?arqui=mostrar_informacion_objetivos",
      { id_obj: id_obj },
      function (data) {
        data = JSON.parse(data);

        // Validar campos antes de enviar el formulario
        if (!validarCampos()) {
          return; // No enviar el formulario si hay campos vacíos
        }
        enviarFormulario(); // Agregar llamada a la función enviarFormulario
      }
    );
  }
}

/**
 * Función para enviar el formulario
 */
function enviarFormulario() {
  var formData = new FormData($("#objetivos_form")[0]);

  $.ajax({
    url: "../controllers/Utils/objetivos.php?arqui=nuevo_actualizar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      data = JSON.parse(data);
      if (data.status === "success") {
        // Alerta de exito
        alert_success(data);

        checkbox1.prop("checked", false); // Establecer el estado del checkbox como inactivo
        checkbox2.prop("checked", false); // Establecer el estado del checkbox como inactivo

        cargarDatosEnTabla(paginaActual, "");

        $(".overlay").hide(); // Ocultar fondo oscuro
        $("#pop_objetivos").hide(); // Ocultar modal
      } else {
        // Alerta de error
        alert_error(data);
      }
    },
    error: function () {
      alert_ajax();
    },
  });

  deshabilitar_campos();
}

/**
 * Mostrar modal
 */
$(document).on("click", "#btnAbrirModal_objetivos", function () {
  nuevo();
});

/**
 * Cerrar modal
 */
$(document).on("click", "#btnCerrarModal_objetivos", function () {
  cancelar();

  deshabilitar_campos();
});

/**
 * Deshabilita los campos de telefono y dni
 */
function deshabilitar_campos() {
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

init();

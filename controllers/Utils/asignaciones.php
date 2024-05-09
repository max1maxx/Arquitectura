<?php
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

// Obtener conexion
require_once '../../configs/connections/connection.php';
// Obtener el modelo
require_once '../../models/Utils/Asignaciones.php';
$asignaciones = new Asignaciones();


// Solicitud de controlador
switch ($_GET[CONTROLADOR_TABLA]) {


        // Mostrar la informacion para editar
    case "mostrar_informacion_asignaciones":
        $datos = $asignaciones->get_asignaciones_id($_POST["id_asig"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["id_asig"] = $row["id_asig"];
                $output["id_met"] = $row["id_met"];
                $output["link_evidencia_asig"] = $row["link_evidencia_asig"];
                $output["obser_asig"] = $row["obser_asig"];
                $output["trimestre_asig"] = $row["trimestre_asig"];
                $output["cumpl_asig"] = $row["cumpl_asig"];
                $output["id_estado"] = $row["id_estado"];
            }
            echo json_encode($output);
        }
        break;

        // Mostrar lista de activos en la tabla
    case "listar":
        $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

        $resultadosPorPagina = 5;
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $datos = $asignaciones->get_asignaciones_activo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $asignaciones->get_total_asignaciones_activo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Mostrar lista de inactivos en la tabla
    case "listar_inactivos":
        $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

        $resultadosPorPagina = 5;
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $datos = $asignaciones->get_asignaciones_inactivo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $asignaciones->get_total_asignaciones_inactivo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;


        // Insertar y editar
    case "nuevo_actualizar":
        if (empty($_POST["id_asig"])) {
            $datos = $asignaciones->insert_asignaciones(
                $_POST["id_met"],
                $_POST["link_evidencia_asig"],
                $_POST["obser_asig"],
                $_POST["trimestre_asig"],
                $_POST["cumpl_asig"]
            );
        } else {
            $datos = $asignaciones->update_asignaciones(
                $_POST["id_asig"],
                $_POST["id_met"],
                $_POST["link_evidencia_asig"],
                $_POST["obser_asig"],
                $_POST["trimestre_asig"],
                $_POST["cumpl_asig"]
            );
        }
        echo json_encode($datos);
        break;

        // Eliminar por ID
    case "eliminar":
        $datos = $asignaciones->delete_asignaciones(
            $_POST["id_asig"]
        );
        echo json_encode($datos);
        break;

        // Desactivar por ID
    case "desactivar":
        $datos = $asignaciones->desactivar_asignaciones($_POST["id_asig"]);
        echo json_encode($datos);
        break;


        // Activar por ID
    case "activar":
        $datos = $asignaciones->activar_asignaciones($_POST["id_asig"]);
        echo json_encode($datos);
        break;



        // Obtener todos los objetivos que existen
    case "obtener_metas":
        $datos = $asignaciones->get_Metas();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $objetivos = [
                    "id_met" => $row["id_met"]
                ];
                $output[] = $objetivos;
            }
            echo json_encode($output);
        }
        break;


        // Obtener todos los objetivos activos
    case "obtener_metas_activos":
        $datos = $asignaciones->get_Metas_activos();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $objetivos = [
                    "id_met" => $row["id_met"]
                ];
                $output[] = $objetivos; // Agrega cada resultado al array $output
            }
            echo json_encode($output);
        }
        break;


        // Verificacion de indicador existente en la base de datos
    case "verificar_asignacion":
        $nombre_asignacion = $_POST['link_evidencia_asig'];
        $resultado = $asignaciones->verificar_Asignaciones($nombre_asignacion);
        echo json_encode($resultado);
        break;
}



/**
 * Funcion que muestra los registros en la tabla
 */
function informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina)
{
    $output = '';
    $contador = 1 + $offset;

    foreach ($datos as $row) {
        $output .= '
        <tr>
            <td>' . $contador++ . '</td>
            <td>' . "I-ASI-00" . $row["id_asig"] . '</td>
            <td>' . "I-MET-00" . $row["id_met"] . '</td>
            <td>' . $row["link_evidencia_asig"] . '</td>
            <td>' . $row["obser_asig"] . '</td>
            <td>' . $row["trimestre_asig"] . '</td>
            <td>' . $row["cumpl_asig"] . '</td>
            <td class="tabla_botones">
                <button type="button" onClick="editar(' . $row["id_asig"] . ');" id="' . $row["id_asig"] . '" class="button4 efects2__button2 btn_editar2" title="Editar">
                    <div><i class="fa fa-edit"></i></div>
                </button>
                <button type="button" onClick="eliminar(' . $row["id_asig"] . ');" id="' . $row["id_asig"] . '" class="button4 efects2__button2 btn_eliminar2" title="Eliminar">
                    <div><i class="fa fa-close icon"></i></div>
                </button>
            </td>
        </tr>';
    }

    $totalPaginas = ceil($totalResultados / $resultadosPorPagina);

    echo json_encode(
        array(
            'output' => $output,
            'totalResultados' => $totalResultados,
            'totalPaginas' => $totalPaginas
        )
    );
}

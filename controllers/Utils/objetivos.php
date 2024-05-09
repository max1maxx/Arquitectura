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
require_once '../../models/Utils/Objetivos.php';
$objetivos = new Objetivos();


// Solicitud de controlador
switch ($_GET[CONTROLADOR_TABLA]) {
        // Mostrar la informacion para editar
    case "mostrar_informacion_objetivos":
        $datos = $objetivos->get_objetivos_id($_POST["id_obj"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["id_obj"] = $row["id_obj"];
                $output["nombre_obj"] = $row["nombre_obj"];
                $output["descrip_obj"] = $row["descrip_obj"];
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

        $datos = $objetivos->get_objetivos_activo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $objetivos->get_total_objetivos_activo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Mostrar lista de inactivos en la tabla
    case "listar_inactivos":
        $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

        $resultadosPorPagina = 5;
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $datos = $objetivos->get_objetivos_inactivo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $objetivos->get_total_objetivos_inactivo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Insertar y editar
    case "nuevo_actualizar":
        if (empty($_POST["id_obj"])) {
            $datos = $objetivos->insert_objetivos(
                $_POST["nombre_obj"],
                $_POST["descrip_obj"]
            );
        } else {
            $datos = $objetivos->update_objetivos(
                $_POST["id_obj"],
                $_POST["nombre_obj"],
                $_POST["descrip_obj"]
            );
        }
        echo json_encode($datos);
        break;

        // Eliminar por ID
    case "eliminar":
        $datos = $objetivos->delete_objetivos(
            $_POST["id_obj"]
        );
        echo json_encode($datos);
        break;

        // Desactivar por ID
    case "desactivar":
        $datos = $objetivos->desactivar_objetivos($_POST["id_obj"]);
        echo json_encode($datos);
        break;


        // Activar por ID
    case "activar":
        $datos = $objetivos->activar_objetivos($_POST["id_obj"]);
        echo json_encode($datos);
        break;



        // Verificacion de indicador existente en la base de datos
    case "verificar_objetivos":
        $nombre_objetivo = $_POST['nombre_obj'];
        $resultado = $objetivos->verificar_Objetivo($nombre_objetivo);
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
            <td>' . $row["nombre_obj"] . '</td>
            <td>' . $row["descrip_obj"] . '</td>
            <td class="tabla_botones">
                <button type="button" onClick="editar(' . $row["id_obj"] . ');" id="' . $row["id_obj"] . '" class="button4 efects2__button2 btn_editar2" title="Editar">
                    <div><i class="fa fa-edit"></i></div>
                </button>
                <button type="button" onClick="eliminar(' . $row["id_obj"] . ');" id="' . $row["id_obj"] . '" class="button4 efects2__button2 btn_eliminar2" title="Eliminar">
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

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
require_once '../../models/Utils/Indicadores.php';
$indicadores = new Indicadores();


// Solicitud de controlador
switch ($_GET[CONTROLADOR_TABLA]) {


        // Mostrar la informacion para editar
    case "mostrar_informacion_indicadores":
        $datos = $indicadores->get_indicadores_id($_POST["id_ind"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {

                $output["id_ind"] = $row["id_ind"];
                $output["nombre_ind"] = $row["nombre_ind"];
                $output["formula_ind"] = $row["formula_ind"];
                $output["descrip_ind"] = $row["descrip_ind"];
                $output["anio_ind"] = $row["anio_ind"];
                $output["id_obj"] = $row["id_obj"];
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

        $datos = $indicadores->get_indicadores_activo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $indicadores->get_total_indicadores_activo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Mostrar lista de inactivos en la tabla
    case "listar_inactivos":
        $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

        $resultadosPorPagina = 5;
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $datos = $indicadores->get_indicadores_inactivo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $indicadores->get_total_indicadores_inactivo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Insertar y editar
    case "nuevo_actualizar":
        if (empty($_POST["id_ind"])) {
            $datos = $indicadores->insert_indicadores(
                $_POST["nombre_ind"],
                $_POST["formula_ind"],
                $_POST["descrip_ind"],
                $_POST["anio_ind"],
                $_POST["id_obj"],
                $_POST["fechaDesactivacion_ind"]
            );
        } else {
            $datos = $indicadores->update_indicadores(
                $_POST["id_ind"],
                $_POST["nombre_ind"],
                $_POST["formula_ind"],
                $_POST["descrip_ind"],
                $_POST["anio_ind"],
                $_POST["id_obj"]
            );
        }
        echo json_encode($datos);
        break;

        // Eliminar por ID
    case "eliminar":
        $datos = $indicadores->delete_indicadores(
            $_POST["id_ind"]
        );
        echo json_encode($datos);
        break;

        // Desactivar por ID
    case "desactivar":
        $datos = $indicadores->desactivar_indicadores($_POST["id_ind"]);
        echo json_encode($datos);
        break;


        // Activar por ID
    case "activar":
        $datos = $indicadores->activar_indicadores($_POST["id_ind"]);
        echo json_encode($datos);
        break;



        // Obtener todos los objetivos que existen
    case "obtener_objetivos":
        $datos = $indicadores->get_Objetivos();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $objetivos = [
                    "id_obj" => $row["id_obj"],
                    "nombre_obj" => $row["nombre_obj"],
                    "descrip_obj" => $row["descrip_obj"]
                ];
                $output[] = $objetivos;
            }
            echo json_encode($output);
        }
        break;



        // Obtener todos los objetivos activos
    case "obtener_objetivos_activos":
        $datos = $indicadores->get_Objetivos_activos();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $objetivos = [
                    "id_obj" => $row["id_obj"],
                    "nombre_obj" => $row["nombre_obj"],
                    "descrip_obj" => $row["descrip_obj"]
                ];
                $output[] = $objetivos; // Agrega cada resultado al array $output
            }
            echo json_encode($output);
        }
        break;


        // Verificacion de indicador existente en la base de datos
    case "verificar_indicador":
        $nombre_indicador = $_POST['nombre_indicador'];
        $resultado = $indicadores->verificar_Indicador($nombre_indicador);
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
            <td>' . "I-DOC-00" . $row["id_ind"] . '</td>
            <td>' . $row["nombre_ind"] . '</td>
            <td>' . $row["formula_ind"] . '</td>
            <td>' . $row["descrip_ind"] . '</td>
            <td>' . $row["anio_ind"] . '</td>
            <td>' . $row["nombre_obj"] . '</td>
            <td class="tabla_botones">
                <button type="button" onClick="editar(' . $row["id_ind"] . ');" id="' . $row["id_ind"] . '" class="button4 efects2__button2 btn_editar2" title="Editar">
                    <div><i class="fa fa-edit"></i></div>
                </button>
                <button type="button" onClick="eliminar(' . $row["id_ind"] . ');" id="' . $row["id_ind"] . '" class="button4 efects2__button2 btn_eliminar2" title="Eliminar">
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

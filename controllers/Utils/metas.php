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
require_once '../../models/Utils/Metas.php';
$metas = new Metas();


// Solicitud de controlador
switch ($_GET[CONTROLADOR_TABLA]) {


        // Mostrar la informacion para editar
    case "mostrar_informacion_metas":
        $datos = $metas->get_metas_id($_POST["id_met"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["id_met"] = $row["id_met"];
                $output["id_ind"] = $row["id_ind"];
                $output["estado_met"] = $row["estado_met"];
                $output["linea_base_met"] = $row["linea_base_met"];
                $output["comportamiento_met"] = $row["comportamiento_met"];
                $output["unidad_medida_met"] = $row["unidad_medida_met"];
                $output["sentido_medicion_met"] = $row["sentido_medicion_met"];
                $output["denominador_met"] = $row["denominador_met"];
                $output["primer_trimestre_met"] = $row["primer_trimestre_met"];
                $output["segundo_trimestre_met"] = $row["segundo_trimestre_met"];
                $output["tercer_trimestre_met"] = $row["tercer_trimestre_met"];
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

        $datos = $metas->get_metas_activo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $metas->get_total_metas_activo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Mostrar lista de inactivos en la tabla
    case "listar_inactivos":
        $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

        $resultadosPorPagina = 5;
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $datos = $metas->get_metas_inactivo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $metas->get_total_metas_inactivo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Insertar y editar
    case "nuevo_actualizar":
        if (empty($_POST["id_met"])) {
            $datos = $metas->insert_metas(
                $_POST["id_ind"],
                $_POST["estado_met"],
                $_POST["linea_base_met"],
                $_POST["comportamiento_met"],
                $_POST["unidad_medida_met"],
                $_POST["sentido_medicion_met"],
                $_POST["denominador_met"],
                $_POST["primer_trimestre_met"],
                $_POST["segundo_trimestre_met"],
                $_POST["tercer_trimestre_met"]
            );
        } else {
            $datos = $metas->update_metas(
                $_POST["id_met"],
                $_POST["id_ind"],
                $_POST["estado_met"],
                $_POST["linea_base_met"],
                $_POST["comportamiento_met"],
                $_POST["unidad_medida_met"],
                $_POST["sentido_medicion_met"],
                $_POST["denominador_met"],
                $_POST["primer_trimestre_met"],
                $_POST["segundo_trimestre_met"],
                $_POST["tercer_trimestre_met"]
            );
        }
        echo json_encode($datos);
        break;

        // Eliminar por ID
    case "eliminar":
        $datos = $metas->delete_metas(
            $_POST["id_met"]
        );
        echo json_encode($datos);
        break;

        // Desactivar por ID
    case "desactivar":
        $datos = $metas->desactivar_metas($_POST["id_met"]);
        echo json_encode($datos);
        break;


        // Activar por ID
    case "activar":
        $datos = $metas->activar_metas($_POST["id_met"]);
        echo json_encode($datos);
        break;



        // Obtener todos los objetivos que existen
    case "obtener_indicadores":
        $datos = $metas->get_Indicadores();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $objetivos = [
                    "id_ind" => $row["id_ind"],
                    "nombre_ind" => $row["nombre_ind"]
                ];
                $output[] = $objetivos;
            }
            echo json_encode($output);
        }
        break;


        // Obtener todos los objetivos activos
    case "obtener_indicadores_activos":
        $datos = $metas->get_Indicadores_activos();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $objetivos = [
                    "id_ind" => $row["id_ind"],
                    "nombre_ind" => $row["nombre_ind"]
                ];
                $output[] = $objetivos; // Agrega cada resultado al array $output
            }
            echo json_encode($output);
        }
        break;


        // Verificacion de indicador existente en la base de datos
    case "verificar_indicador":
        $nombre_indicador = $_POST['nombre_indicador'];
        $resultado = $metas->verificar_Metas($nombre_indicador);
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
            <td>' . "I-MET-00" . $row["id_met"] . '</td>
            <td>' . $row["nombre_ind"] . '</td>
            <td>' . $row["estado_met"] . '</td>
            <td>' . $row["linea_base_met"] . '</td>
            <td>' . $row["comportamiento_met"] . '</td>
            <td>' . $row["unidad_medida_met"] . '</td>
            <td>' . $row["sentido_medicion_met"] . '</td>
            <td>' . $row["denominador_met"] . '</td>
            <td>' . $row["primer_trimestre_met"] . '</td>
            <td>' . $row["segundo_trimestre_met"] . '</td>
            <td>' . $row["tercer_trimestre_met"] . '</td>
            <td class="tabla_botones">
                <button type="button" onClick="editar(' . $row["id_met"] . ');" id="' . $row["id_met"] . '" class="button4 efects2__button2 btn_editar2" title="Editar">
                    <div><i class="fa fa-edit"></i></div>
                </button>
                <button type="button" onClick="eliminar(' . $row["id_met"] . ');" id="' . $row["id_met"] . '" class="button4 efects2__button2 btn_eliminar2" title="Eliminar">
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

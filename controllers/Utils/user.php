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
require_once '../../models/Utils/User.php';
$usuario = new Usuario();


// Solicitud de controlador
switch ($_GET[CONTROLADOR_TABLA]) {

        // Login administrador
    case "login_admin":

        $datos = $usuario->login_admin(
            $_POST["correo_usuariol2"],
            $_POST["password_usuariol2"]
        );
        echo json_encode($datos);
        break;



    case "login_usuario":

        $datos = $usuario->login_user(
            $_POST["correo_usuario3"],
            $_POST["password_usuario3"]
        );
        echo json_encode($datos);
        break;



        // Mostrar la informacion del usuario en el perfil
    case "mostrar_informacion_usuario":
        $datos = $usuario->get_usuario_id($_POST["id_usuario"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {

                $output["id_usuario"] = $row["id_usuario"];
                $output["nombre_usuario"] = $row["nombre_usuario"];
                $output["apellido_usuario"] = $row["apellido_usuario"];
                $output["dni_usuario"] = $row["dni_usuario"];
                $output["telefono_usuario"] = $row["telefono_usuario"];
                $output["correo_usuario"] = $row["correo_usuario"];
                $output["password_usuario"] = $row["password_usuario"];
                $output["id_pais"] = $row["id_pais"];
                $output["id_rol"] = $row["id_rol"];
                $output["id_estado"] = $row["id_estado"];
                // Obtener la imagen como Blob y agregarla a los datos de salida
                $output["foto_usuario"] = base64_encode($row["foto_usuario"]);
            }
            echo json_encode($output);
        }
        break;



        // Verificar contraseña
    case "verificar_contraseña":
        $id_usuario = $_POST["id_usuario"];
        $contrasenia_actual = $_POST["passwd"];

        // Obtener la contraseña cifrada almacenada en la base de datos para el usuario
        $passw_actual = $usuario->get_usuario_id($id_usuario);
        $contrasenia_db = $passw_actual[0]["password_usuario"];

        // Verificar si la contraseña actual coincide con la almacenada en la base de datos
        if (password_verify($contrasenia_actual, $contrasenia_db)) {
            $datos = [
                "status" => "success",
                "title" => "Contraseña correcta",
                "message" => "Se actualizó la contraseña correctamente."
            ];
        } else {
            $datos = [
                "status" => "error",
                "title" => "Contraseña incorrecta",
                "message" => "La contraseña actual ingresada no es correcta"
            ];
        }
        echo json_encode($datos);
        break;



        // Actualizar datos del perfil de usuario
    case "actualizar_perfil":
        // Verificar si se ha subido una nueva imagen
        if (!empty($_POST["foto_usuario"])) {
            $foto_usuario = base64_decode($_POST["foto_usuario"]);
        } else {
            // Obtener la imagen actual del usuario
            $datos = $usuario->get_usuario_id($_POST["id_usuario"]);
            if (is_array($datos) == true and count($datos) <> 0) {
                $foto_usuario = $datos[0]["foto_usuario"];
            }
        }

        // Actualiza los datos del usuario en la base de datos
        $datos = $usuario->update_perfil(
            $_POST["id_usuario"],
            $_POST["nombre_usuario"],
            $_POST["apellido_usuario"],
            $_POST["id_pais"],
            $_POST["dni_usuario"],
            $_POST["telefono_usuario"],
            $foto_usuario
        );

        echo json_encode($datos);
        break;



        // Actualizar la contraseña del usuario
    case "actualizar_contrasenia":
        $id_usuario = $_POST["id_usuario"];
        $contrasenia_actual = $_POST["currentPassword"];
        $nueva_contrasenia = $_POST["newPassword"];

        // Obtener la contraseña cifrada almacenada en la base de datos para el usuario
        $passw_actual = $usuario->get_usuario_id($id_usuario);
        $contrasenia_db = $passw_actual[0]["password_usuario"];

        // Verificar si la contraseña actual coincide con la almacenada en la base de datos
        if (password_verify($contrasenia_actual, $contrasenia_db)) {
            // La contraseña actual es válida, cifra la nueva contraseña
            $contrasenia_cifrada = password_hash($nueva_contrasenia, PASSWORD_DEFAULT);

            // Actualiza la contraseña en la base de datos
            $datos = $usuario->update_contrasenia($id_usuario, $contrasenia_cifrada);
        } else {
            $datos = [
                "status" => "error",
                "title" => "Contraseña incorrecta",
                "message" => "La contraseña actual ingresada no es correcta"
            ];
        }

        echo json_encode($datos);
        break;



        // Cambiar contraseña
    case "cambiar_contraseña":
        $id_usuario = $_POST['id_usuario'];
        $password_usuario = $_POST['password_usuario'];

        // Cifrar contraseña
        $contrasenia_cifrada = password_hash($password_usuario, PASSWORD_DEFAULT);

        $datos = $usuario->update_contrasenia($id_usuario, $contrasenia_cifrada);

        echo json_encode($datos);
        break;



        // Mostrar lista de activos en la tabla
    case "listar":
        $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

        $resultadosPorPagina = 5;
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $datos = $usuario->get_usuarios_activo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $usuario->get_total_usuarios_activo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Mostrar lista de inactivos en la tabla
    case "listar_inactivos":
        $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

        $resultadosPorPagina = 5;
        $offset = ($pagina - 1) * $resultadosPorPagina;

        $datos = $usuario->get_usuarios_inactivo($offset, $resultadosPorPagina, $filtro);
        $totalResultados = $usuario->get_total_usuarios_inactivo($filtro);

        informacionTabla($offset, $datos, $totalResultados, $resultadosPorPagina);
        break;



        // Insertar y editar
    case "nuevo_actualizar":
        if (empty($_POST["id_usuario"])) {
            $datos = $usuario->insert_usuario(
                $_POST["nombre_usuario"],
                $_POST["apellido_usuario"],
                $_POST["correo_usuario"],
                $_POST["telefono_usuario"],
                $_POST["dni_usuario"],
                $_POST["password_usuario"],
                $_POST["id_pais"],
                $_POST["fechaDesactivacion_usuario"],
                $_POST["id_rol"]
            );
        } else {
            $datos = $usuario->update_usuario(
                $_POST["id_usuario"],
                $_POST["nombre_usuario"],
                $_POST["apellido_usuario"],
                $_POST["correo_usuario"],
                $_POST["telefono_usuario"],
                $_POST["dni_usuario"],
                $_POST["id_pais"],
                $_POST["id_rol"]
            );
        }
        echo json_encode($datos);
        break;



        // Eliminar por ID
    case "eliminar":
        $datos = $usuario->delete_usuario(
            $_POST["id_usuario"]
        );
        echo json_encode($datos);
        break;



        // Desactivar por ID
    case "desactivar":
        $datos = $usuario->desactivar_usuario($_POST["id_usuario"]);
        echo json_encode($datos);
        break;



        // Activar por ID
    case "activar":
        $datos = $usuario->activar_usuario($_POST["id_usuario"]);
        echo json_encode($datos);
        break;



        // Eliminar foto por ID
    case "eliminar_foto":
        $datos = $usuario->delete_photo(
            $_POST["id_usuario"]
        );
        echo json_encode($datos);
        break;



        // Obtener todos los paises que existen
    case "obtener_paises":
        $datos = $usuario->get_Paises();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $pais = [
                    "id_pais" => $row["id_pais"],
                    "nombre_pais" => $row["nombre_pais"],
                    "abreviatura_pais" => $row["abreviatura_pais"],
                    "prefijo_pais" => $row["prefijo_pais"]
                ];
                $output[] = $pais;
            }
            echo json_encode($output);
        }
        break;



        // Obtener todos los paises activos
    case "obtener_paises_activos":
        $datos = $usuario->get_Paises_activos();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $rol = [
                    "id_pais" => $row["id_pais"],
                    "nombre_pais" => $row["nombre_pais"],
                    "abreviatura_pais" => $row["abreviatura_pais"],
                    "prefijo_pais" => $row["prefijo_pais"]
                ];
                $output[] = $rol; // Agrega cada resultado al array $output
            }
            echo json_encode($output);
        }
        break;



        // Obtener todos los roles que existen
    case "obtener_roles":
        $datos = $usuario->get_Roles();
        $output = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $rol = [
                    "id_rol" => $row["id_rol"],
                    "nombre_rol" => $row["nombre_rol"]
                ];
                $output[] = $rol;
            }
            echo json_encode($output);
        }
        break;



        // Verificacion de cedula existente en la base de datos
    case "verificar_cedula":
        $cedula = $_POST['cedula'];
        $resultado = $usuario->verificar_Cedula($cedula);
        echo json_encode($resultado);
        break;



        // Verificacion de correo existente en la base de datos
    case "verificar_correo":
        $correo = $_POST['correo'];
        $resultado = $usuario->verificar_Correo($correo);
        echo json_encode($resultado);
        break;



        // Obtener los datos activos filtrado sin paginacion
    case "copy_portapapeles_activo":
        // Verifica si se ha proporcionado un filtro
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';
        $id_usuario_accion = isset($_POST['id_usuario_accion']) ? $_POST['id_usuario_accion'] : '';
        $id_rol_accion = isset($_POST['id_rol_accion']) ? $_POST['id_rol_accion'] : '';
        $nombre_documento = isset($_POST['nombre_documento']) ? $_POST['nombre_documento'] : '';
        $estado_documento = isset($_POST['estado_documento']) ? $_POST['estado_documento'] : '';
        $extencion_archivo = isset($_POST['extencion_archivo']) ? $_POST['extencion_archivo'] : '';

        $datos = $usuario->copy_portapapeles_activo($filtro, $id_usuario_accion, $id_rol_accion, $nombre_documento, $estado_documento, $extencion_archivo);

        // Devuelve los resultados en formato JSON
        header('Content-Type: application/json');
        echo json_encode(['output' => $datos]);
        break;



        // Obtener los datos inactivos filtrado sin paginacion
    case "copy_portapapeles_inactivo":
        // Verifica si se ha proporcionado un filtro
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';
        $id_usuario_accion = isset($_POST['id_usuario_accion']) ? $_POST['id_usuario_accion'] : '';
        $id_rol_accion = isset($_POST['id_rol_accion']) ? $_POST['id_rol_accion'] : '';
        $nombre_documento = isset($_POST['nombre_documento']) ? $_POST['nombre_documento'] : '';
        $estado_documento = isset($_POST['estado_documento']) ? $_POST['estado_documento'] : '';
        $extencion_archivo = isset($_POST['extencion_archivo']) ? $_POST['extencion_archivo'] : '';

        $datos = $usuario->copy_portapapeles_inactivo($filtro, $id_usuario_accion, $id_rol_accion, $nombre_documento, $estado_documento, $extencion_archivo);

        // Devuelve los resultados en formato JSON
        header('Content-Type: application/json');
        echo json_encode(['output' => $datos]);
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
            <td>' . $row["nombre_usuario"] . " " . $row["apellido_usuario"] . '</td>
            <td>' . $row["dni_usuario"] . '</td>
            <td>' . $row["telefono_usuario"] . '</td>
            <td>' . $row["correo_usuario"] . '</td>
            <td>' . $row["abreviatura_pais"] . '</td>
            <td>' . $row["nombre_rol"] . '</td>
            <td class="tabla_botones">
            <button type="button" onClick="cambiarContraseña(' . $row["id_usuario"] . ');" id="' . $row["id_usuario"] . '" class="button4 efects2__button2 btn_organizaciones2" title="Cambiar contraseña">
                    <div><i class="fa fa-key"></i></div>
                </button>
                <button type="button" onClick="editar(' . $row["id_usuario"] . ');" id="' . $row["id_usuario"] . '" class="button4 efects2__button2 btn_editar2" title="Editar">
                    <div><i class="fa fa-edit"></i></div>
                </button>
                <button type="button" onClick="eliminar(' . $row["id_usuario"] . ');" id="' . $row["id_usuario"] . '" class="button4 efects2__button2 btn_eliminar2" title="Eliminar">
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

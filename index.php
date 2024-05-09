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

// Conexión BDD
require_once 'configs/connections/connection.php';

// Variables globales
require_once 'configs/global/vars.php';

// Obtener la URL solicitada
$folderPath = dirname($_SERVER['SCRIPT_NAME']);
$request_uri = $_SERVER['REQUEST_URI']; //Esta ruta es para produccion
$url_local = substr($request_uri, strlen($folderPath)); //Esta ruta es para local

$url = $url_local;  //Cambiar aqui la ruta para local o producción


// Incluir archivos de rutas específicos
require_once 'configs/routes/public.php';
require_once 'configs/routes/admin.php';
require_once 'configs/routes/control.php';

// Definir un array de rutas amigables
$routes = [];

// Agregar las rutas de usuario al array $routes
foreach ($publicRoutes as $key => $value) {
    $routes[$key] = $value;
}

// Agregar las rutas de administrador al array $routes
foreach ($adminRoutes as $key => $value) {
    $routes[$key] = $value;
}

// Agregar las rutas de control al array $routes
foreach ($controlRoutes as $key => $value) {
    $routes[$key] = $value;
}


// Comprobar si la ruta solicitada está en el array
if (array_key_exists($url, $routes)) {

    if (isset($adminRoutes[$url])) {
        // Verificar la sesión solo para las rutas del administrador
        if (isset($_SESSION["id_usuario"])) {

            if ($_SESSION["id_rol"] == $G_rol_admin || $_SESSION["id_rol"] == $G_rol_planificador) {
                include $routes[$url];

            } else if ($_SESSION["id_rol"] == $G_rol_user) {
                header("Location:" . Conectar::ruta());

            } else {
                header("Location:" . Conectar::ruta() . '404');
            }
        } else {
            header("Location:" . Conectar::ruta() . 'administrador');
        }

    } else if (isset($publicRoutes[$url])) {
        // Verificar la sesión solo para las rutas del usuario
        if (isset($_SESSION["id_usuario"])) {

            if ($_SESSION["id_rol"] == $G_rol_user) {
                include $routes[$url];

            } else if ($_SESSION["id_rol"] == $G_rol_admin) {
                header("Location:" . Conectar::ruta() . 'administrador');

            } else {
                header("Location:" . Conectar::ruta() . '404');
            }
        } else {
            header("Location:" . Conectar::ruta() . 'login');
        }

    } else {
        // Rutas sin control de sesion
        include $routes[$url];
    }
} else {
    // Ruta no encontrada, mostrar la página de error 404
    include 'views/Error/404.php';
}
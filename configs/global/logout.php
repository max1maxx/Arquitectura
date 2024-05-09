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

// Cierra la sesión
if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] != null) {

    // verifica a qué login va a redireccionar
    if ($_SESSION['id_rol'] == $G_rol_user) {
        $redireccion = $login_user;
    } else if ($_SESSION['id_rol'] == $G_rol_admin || $_SESSION['id_rol'] == $G_rol_planificador) {
        $redireccion = $login_admin;
    }

    // Destruye la sesión y regenera el ID de la sesión
    session_regenerate_id(true);
    session_destroy();

    // Cierra la sesión de manera efectiva
    session_write_close();

    header("Location:" . Conectar::ruta() . $redireccion);

    exit;
}
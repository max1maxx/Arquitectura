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

// Variables
$inicio_public = '';
$login_admin = 'administrador';
$login_user = 'login';
$Profile = 'perfil';
$Error_404 = '404';
$Logout = 'logout';

// Designacion de rutas
$controlRoutes = [
    '/' . $inicio_public => 'views/Public/home/index.php',
    '/' . $login_admin => 'views/Auth/admin.php',
    '/' . $login_user => 'views/Auth/user.php',
    '/' . $Profile => 'views/Account/user_profile.php',
    '/' . $Error_404 => 'views/Error/404.php',
    '/' . $Logout => 'configs/global/logout.php',
];

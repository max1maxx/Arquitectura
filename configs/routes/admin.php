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
$inicio_admin = 'admin';
$Users ='admin/usuarios';
$Objetivos = 'admin/objetivos';
$Indicadores = 'admin/indicadores';
$Metas = 'admin/metas';

// Designacion de rutas
$adminRoutes = [
    '/' . $inicio_admin => 'views/Admin/home/index.php',
    '/' . $Users => 'views/Admin/user/index.php',
    '/' . $Objetivos => 'views/Admin/objetivos/index.php',
    '/' . $Indicadores => 'views/Admin/indicadores/index.php',
    '/' . $Metas => 'views/Admin/metas/index.php',
];
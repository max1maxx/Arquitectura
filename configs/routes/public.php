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
$inicio = 'inicio';
$Asignacion = 'public/asignacion';


// Designacion de rutas
$publicRoutes = [
    '/' . $inicio => 'views/Public/home/index.php',
    '/' . $Asignacion => 'views/Public/asignaciones/index.php',
];
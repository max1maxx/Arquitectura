<!-- /*
 * ----------------------------------------------------------------------------
 * Propiedad de <Armando Josue Velasquez Delgado> <<https://armandovelasquez.com>>
 * Todos los derechos reservados. Ninguna parte de este software puede ser 
 * reproducida, distribuida o transmitida de ninguna forma o por ningún medio, 
 * electrónico o mecánico, incluyendo fotocopias, grabaciones o cualquier otro 
 * sistema de almacenamiento y recuperación de información, sin el permiso 
 * previo por escrito del autor.
 * ----------------------------------------------------------------------------
 */ -->

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Estilos generales -->
    <?php require_once 'includes/Design/head.php'; ?>

    <!-- Estilos propios -->
    <link href="<?= RUTA ?>assets/css/Admin/home.css" rel="stylesheet">

    <title>Inicio</title>
</head>

<body>
    <!-- SIDEBAR -->
    <?php require_once 'includes/Design/sidebar.php'; ?>

    <section id="content">
        <!-- NAVBAR -->
        <?php require_once 'includes/Design/navbar.php'; ?>

        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido</h1>
            <ul class="breadcrumbs">
                <li><a href="#" class="active">Inicio</a></li>
            </ul>

            <div class="general_contenedor">
                <div class="info-data">
                    <div class="contenedor_perfil">
                        <div class="contenedor_subtitulo_pagina">
                            <h3></h3>
                        </div>
                        <div class="perfil">
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </section>
</body>

</html>

<script src="<?= RUTA ?>assets/js/utils/user/controller.js"></script>
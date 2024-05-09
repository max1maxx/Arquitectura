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

<?php
if (isset($_SESSION["id_usuario"]) && $_SESSION['dni_usuario'] != 'Ninguno') {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Estilos generales -->
        <?php require_once 'includes/Design/head.php'; ?>

        <!-- Estilos propios -->
        <link href="<?= RUTA ?>assets/css/Account/profile.css" rel="stylesheet">

        <title>Perfil</title>
    </head>

    <body>
        <!-- SIDEBAR -->
        <?php require_once 'includes/Design/sidebar.php'; ?>

        <section id="content">
            <!-- NAVBAR -->
            <?php require_once 'includes/Design/navbar.php'; ?>

            <!-- MAIN -->
            <main>
                <h1 class="title">Perfil</h1>
                <ul class="breadcrumbs"></ul>

                <div class="general_contenedor">
                    <div class="info-data">
                        <div class="contenedor_perfil">
                            <div class="contenedor_subtitulo_pagina">
                                <h3>Datos personales</h3>
                            </div>
                            <div class="perfil">
                                <!-- contenedor de foto de perfil -->
                                <div class="avatar">
                                    <div class="foto_perfil">
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <img id="imagenPrevisualizacion" class="fotoUsuario"
                                                    src="<?= RUTA ?>assets/img/default/Default-User.svg"
                                                    alt="Click aquí para subir tu foto"
                                                    title="Click aquí para subir tu foto">
                                                <button type="button" onclick="verificacion_eliminar_foto()" class="eliminar_foto_perfil" title="Eliminar foto"><i class="bx bx-x"></i></button>
                                            </label>
                                            <input id="file-input" type="file" name="image" />
                                            <figcaption>
                                                <p>Cambiar foto</p>
                                            </figcaption>
                                        </div>
                                    </div>
                                    <div class="nombre_perfil">
                                        <h3>
                                            <?php
                                            $nombreCompleto = $_SESSION["nombre_usuario"];
                                            $nombres = explode(" ", $nombreCompleto);
                                            echo $nombres[0] . " " . $_SESSION["apellido_usuario"];
                                            ?>
                                        </h3>
                                        <p>
                                            <?= $_SESSION['nombre_rol'] ?>
                                        </p>
                                        <br>
                                        <div class="contenedor_cambiar_contraseña">
                                            <button id="cambio_contrasenia"
                                                class="button2 efects__button btn_navegacion">Cambiar contraseña</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenedor del campos -->
                                <div class="content">
                                    <div>
                                        <label for="nombre_usuario">Nombre <span class="requerido">*</span></label>
                                        <input class="input" type="text" id="nombre_usuario" name="nombre_usuario"
                                            placeholder="Ingrese su nombre">
                                    </div>

                                    <div>
                                        <label for="apellido_usuario">Apellido <span
                                                class="requerido">*</span></label>
                                        <input class="input" type="text" id="apellido_usuario"
                                            name="apellido_usuario" placeholder="Ingrese su apellido">
                                    </div>

                                    <div>
                                        <label for="id_pais">País <span class="requerido">🔒</span></label>
                                        <select class="input inactive" name="id_pais" id="id_pais"
                                            data-placeholder="Seleccione" disabled readonly></select>
                                    </div>

                                    <div>
                                        <label for="dni_usuario">Cédula <span class="requerido">*</span></label>
                                        <input class="input inactive" type="text" id="dni_usuario" name="dni_usuario"
                                            placeholder="Seleccione su país">
                                    </div>

                                    <div>
                                        <label for="telefono_usuario">Celular <span class="requerido">*</span></label>
                                        <input class="input inactive" type="text" id="telefono_usuario"
                                            name="telefono_usuario" placeholder="Seleccione su país">
                                    </div>

                                    <div>
                                        <label for="correo_usuario">Correo Electrónico <span
                                                class="requerido">*</span></label>
                                        <input class="input" type="text" id="correo_usuario" name="correo_usuario"
                                            placeholder="Ingrese su correo electrónico">
                                    </div>

                                </div>
                            </div>
                            <div class="contenedor_boton">
                                <button id="btnactualizar" class="button efects__button btn_actualizar">ACTUALIZAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
    </body>

    </html>

    <?php
} else {
    header("Location:" . Conectar::ruta() . $login);
}
?>

<!-- Funcionalidad -->
<script src="<?= RUTA ?>assets/js/profile/script.js"></script>
<script src="<?= RUTA ?>assets/js/profile/controller.js"></script>
<script src="<?= RUTA ?>assets/js/utils/user/validations.js"></script>
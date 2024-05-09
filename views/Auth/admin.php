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
if (isset($_SESSION["id_usuario"])) {
    header("Location:" . Conectar::ruta() . $inicio_admin);
} else {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Estilos generales -->
        <?php require_once 'includes/Design/head.php'; ?>

        <!-- Estilos propios -->
        <link href="<?= RUTA ?>assets/css/Auth/admin.css" rel="stylesheet">

        <title>Ingreso Administrador</title>
    </head>

    <body>
        <div class="main">

            <div class="switch">

                <form id="login_admin_form" method="post">

                    <h3 class="switch__title title">ADMINISTRADOR</h3>
                    <p class="switch__description description"><?= $G_nombre_sito ?></p>

                    <input class="input form_input" type="text" id="correo_usuariol2" name="correo_usuariol2"
                        placeholder="Ingrese su correo electrónico" autocomplete="off">
                        
                    <input class="input form_input" type="password" id="password_usuariol2" name="password_usuariol2"
                        placeholder="Ingrese su contraseña" autocomplete="off">

                    <a href="" class="recuperarContrasenia"></a>

                    <button type="submit" class="button efects__button">INGRESAR</button>

                </form>
            </div>
        </div>
    </body>

    </html>

    <?php
}
?>

<!-- Funcionalidad -->
<script src="<?= RUTA ?>assets/js/auth/controller.js"></script>
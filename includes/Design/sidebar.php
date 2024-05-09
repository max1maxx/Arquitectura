<section id="sidebar">
    <a href="<?= RUTA . ($_SESSION['id_rol'] == $G_rol_user ? $inicio : $inicio_admin) ?>" class="brand">
        <img class="logo_site" src="<?= RUTA ?>assets/img/favicon/favicon.ico" alt="Logo">
        <div class="title_text" id="title_page_sidebar">
            <p>
                <?= $G_nombre_sito ?>
            </p>
        </div>
    </a>

    <ul class="side-menu">
        <li><a href="<?= RUTA . ($_SESSION['id_rol'] == $G_rol_user ? $inicio : $inicio_admin) ?>" class="sidebar_inicio"><i class='bx bxs-dashboard icon'></i>
                Inicio</a></li>

        <li class="divider" data-text="regístro">REGISTRO</li>
        <?php if ($_SESSION['id_rol'] == $G_rol_admin) { ?>
            <li><a href="<?= RUTA . $Users ?>"><i class='bx bxs-user-detail icon'></i> Usuarios</a></li>
        <?php } ?>

        <?php if ($_SESSION['id_rol'] == $G_rol_planificador) { ?>
            <li><a href="<?= RUTA . $Objetivos ?>"><i class='bx bxs-user-detail icon'></i> Objetivos</a></li>
        <?php } ?>

        <?php if ($_SESSION['id_rol'] == $G_rol_planificador) { ?>
            <li><a href="<?= RUTA . $Indicadores ?>"><i class='bx bx-right-indent icon'></i> Indicadores</a></li>
        <?php } ?>

        <?php if ($_SESSION['id_rol'] == $G_rol_planificador) { ?>
            <li><a href="<?= RUTA . $Metas ?>"><i class='bx bxs-user-check icon'></i></i> Metas</a></li>
        <?php } ?>

        <?php if ($_SESSION['id_rol'] == $G_rol_user) { ?>
            <li><a href="<?= RUTA . $Asignacion ?>"><i class='bx bxs-user-check icon'></i></i> Asignaciones</a></li>
        <?php } ?>

        <li class="divider" data-text="más">Más</li>
        <div class="contenedor_config">
            <li><a href="<?= RUTA . $Logout ?>"><i class='bx bx-log-out icon salir'></i> Salir</a></li>
        </div>
    </ul>
</section>
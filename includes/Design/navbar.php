<nav id="nav">
    <div class="toggle-sidebar">
        <i class='bx bx-menu'></i>
    </div>
    <form action="#">
        <div class="form-group">

        </div>
    </form>

    <input type="hidden" id="user_id_x" value="<?= $_SESSION["id_usuario"] ?>">
    <input type="hidden" id="rol_id_x" value="<?= $_SESSION["id_rol"] ?>">
    <input type="hidden" id="route_page_x" value="<?= RUTA ?>">

    <div class="contenedor_user">
        <span class="name_user">
            <?php
            $nombreCompleto = $_SESSION["nombre_usuario"];
            $nombres = explode(" ", $nombreCompleto);
            echo $nombres[0] . " " . $_SESSION["apellido_usuario"];
            ?>
        </span>

        <div class="profile">
            <?php
            if (isset($_SESSION['foto_usuario']) && !empty($_SESSION['foto_usuario'])) {
                echo '<img src="data:image/png;base64,' . base64_encode($_SESSION['foto_usuario']) . '"/>';
            } else {
                echo '<img src="' . RUTA . 'assets/img/default/Default-User.svg" alt="">';
            }
            ?>
            <ul class="profile-link">
                <li><a href="<?= RUTA . $Profile ?>"><i class='bx bxs-user icon'></i> Perfil</a></li>
                <li><a href="https://armandovelasquez.com" target="_blank"><i class='bx bx-support icon'></i> Soporte</a></li>
                <li><a href="<?= RUTA . $Logout ?>"><i class='bx bx-log-out'></i> Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Boton para volver hacia arriba -->
    <button id="btn_top"><i class='bx bxs-chevrons-up'></i></button>

</nav>
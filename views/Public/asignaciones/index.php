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

    <!-- Popup -->
    <?php require 'includes/Popups/pop_asignaciones.php'; ?>

    <!-- Estilos propios -->
    <link href="<?= RUTA ?>assets/css/Admin/user.css" rel="stylesheet">

    <title>Indicadores</title>
</head>

<body>
    <!-- SIDEBAR -->
    <?php require_once 'includes/Design/sidebar.php'; ?>

    <section id="content">
        <!-- NAVBAR -->
        <?php require_once 'includes/Design/navbar.php'; ?>

        <!-- MAIN -->
        <main>
            <h1 class="title">Registro Indicadores</h1>
            <ul class="breadcrumbs">
                <li><a href="<?= RUTA ?>Admin">Inicio</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Indicadores</a></li>
            </ul>

            <div class="general_contenedor">
                <div class="info-data">
                    <div class="contenedor_perfil">
                        <div class="contenedor_subtitulo_pagina">
                            <h3 id="subtitulo_asignaciones">Lista de Indicadores</h3>
                        </div>
                        <div class="perfil">
                            <div class="contenedor_botones">
                                <div class="btn_principal">
                                    <button class="button2 efects__button btn_nuevo" id="btnAbrirModal_asignaciones"><i class='bx bxs-add-to-queue icon'></i> Nuevo Registro</button>
                                </div>
                                <div class="btn_segundario">
                                    <button id="excel_table_usuario" class="button3 efects__button btn_excel">Excel</button>
                                    <button id="csv_table_usuario" class="button3 efects__button btn_csv">CSV</button>
                                </div>
                            </div>

                            <hr>

                            <div class="contenedor_buscador">
                                <input class="input" type="text" id="filtro_asignaciones" placeholder="Buscar asignaciones...">
                            </div>

                            <div class="contenedor_tabla">

                                <div class="Encabezado_tabla">
                                    <h1>Todos los Indicadores</h1>

                                    <div class="contenedor_desactivados">
                                        <label for="switch-desactivados1" class="switch">
                                            <input type="checkbox" id="switch-desactivados1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped table-responsive-stack" id="tabla_asignaciones">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="th_tabla">#</th>
                                            <th class="th_tabla">Codigo</th>
                                            <th class="th_tabla">Meta</th>
                                            <th class="th_tabla">Evidencia</th>
                                            <th class="th_tabla">Observación</th>
                                            <th class="th_tabla">Trimestre</th>
                                            <th class="th_tabla">Valor Cumplimiento</th>
                                            <th class="th_tabla th_botones">

                                                <div class="contenedor_desactivados2">
                                                    <label for="switch-desactivados2" class="switch2">
                                                        <input type="checkbox" id="switch-desactivados2">
                                                        <span class="slider2 round2"></span>
                                                    </label>
                                                </div>


                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- Datos de la tabla llamados por el controller.js -->
                                    </tbody>
                                </table>

                                <div class="informacion_tabla">
                                    <div class="total-registros">
                                        Total de registros: <span id="total-registros">0</span>
                                    </div>
                                    <div class="numero_paginas">
                                        <h6 id="paginas">0</h6>
                                    </div>
                                </div>

                                <div class="contenedor_paginacion">
                                    <div class="pagination">
                                        <!-- Codigo para los botones de navegacion -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>

<!-- Funcionalidad -->
<script src="<?= RUTA ?>assets/js/utils/asignaciones/script.js"></script>
<script src="<?= RUTA ?>assets/js/utils/asignaciones/controller.js"></script>
<script src="<?= RUTA ?>assets/js/utils/asignaciones/validations.js"></script>
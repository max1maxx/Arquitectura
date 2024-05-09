<div id="overlay" class="overlay"></div>
<div id="pop_usuario" class="modal">
    <div class="content">
        <h2 id="pop_title_usuario" class="pop_title"></h2>
        <hr>
        <form method="post" id="usuario_form">
            <div id="usuario_form_contenedor" class="form_contenedor">
                <input type="hidden" name="id_usuario" id="id_usuario" />
                <input type="hidden" name="password_usuario" id="password_usuario" value="default" />
                <input type="hidden" name="fechaDesactivacion_usuario" id="fechaDesactivacion_usuario" />

                <div>
                    <label for="nombre_usuario">Nombre <span class="requerido">*</span></label>
                    <input class="input" type="text" id="nombre_usuario" name="nombre_usuario"
                        placeholder="Ingrese su nombre">
                </div>

                <div>
                    <label for="apellido_usuario">Apellido <span class="requerido">*</span></label>
                    <input class="input" type="text" id="apellido_usuario" name="apellido_usuario"
                        placeholder="Ingrese su apellido">
                </div>

                <div>
                    <label for="id_pais">País <span class="requerido">*</span></label>
                    <select class="input" name="id_pais" id="id_pais" data-placeholder="Seleccione"></select>
                </div>

                <div>
                    <label for="dni_usuario">Cédula <span class="requerido">*</span></label>
                    <input class="input inactive" type="text" id="dni_usuario" name="dni_usuario"
                        placeholder="Seleccione su país" disabled>
                </div>

                <div>
                    <label for="telefono_usuario">Celular <span class="requerido">*</span></label>
                    <input class="input inactive" type="text" id="telefono_usuario" name="telefono_usuario"
                        placeholder="Seleccione su país" disabled>
                </div>

                <div>
                    <label for="correo_usuario">Correo Electrónico <span class="requerido">*</span></label>
                    <input class="input" type="text" id="correo_usuario" name="correo_usuario"
                        placeholder="Ingrese su correo electrónico">
                </div>

                <div>
                    <label for="id_rol">Rol <span class="requerido">*</span></label>
                    <select class="input" name="id_rol" id="id_rol" data-placeholder="Seleccione"></select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="button2 efects2__button2 btn_enviar"><i class="fa fa-check"></i>
                    Guardar</button>

                <button type="reset" id="btnCerrarModal_usuario" class="button2 efects2__button2 btn_cancelar"><i
                        class="fa fa-close"></i>
                    Cancelar</button>
            </div>
        </form>
    </div>


</div>
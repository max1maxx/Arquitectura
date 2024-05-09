<div id="overlay" class="overlay"></div>
<div id="pop_objetivos" class="modal">
    <div class="content">
        <h2 id="pop_title_objetivos" class="pop_title"></h2>
        <hr>
        <form method="post" id="objetivos_form">
            <div id="objetivos_form_contenedor" class="form_contenedor">
                <input type="hidden" name="id_obj" id="id_obj" />
                <input type="hidden" name="fechaDesactivacion_obj" id="fechaDesactivacion_obj" />

                <div>
                    <label for="nombre_obj">Nombre <span class="requerido">*</span></label>
                    <input class="input" type="text" id="nombre_obj" name="nombre_obj" placeholder="Nombre...">
                </div>

                <div>
                    <label for="descrip_obj">Descripción <span class="requerido">*</span></label>
                    <input class="input" type="text" id="descrip_obj" name="descrip_obj" placeholder="Descripción...">
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="button2 efects2__button2 btn_enviar"><i class="fa fa-check"></i>
                    Guardar</button>

                <button type="reset" id="btnCerrarModal_objetivos" class="button2 efects2__button2 btn_cancelar"><i class="fa fa-close"></i>
                    Cancelar</button>
            </div>
        </form>
    </div>


</div>
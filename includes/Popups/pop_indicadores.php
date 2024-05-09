<div id="overlay" class="overlay"></div>
<div id="pop_indicadores" class="modal">
    <div class="content">
        <h2 id="pop_title_indicadores" class="pop_title"></h2>
        <hr>
        <form method="post" id="indicadores_form">
            <div id="indicadores_form_contenedor" class="form_contenedor">
                <input type="hidden" name="id_ind" id="id_ind" />
                <input type="hidden" name="fechaDesactivacion_ind" id="fechaDesactivacion_ind" />

                <div>
                    <label for="nombre_ind">Nombre <span class="requerido">*</span></label>
                    <input class="input" type="text" id="nombre_ind" name="nombre_ind" maxlength="200" placeholder="Nombre">
                </div>

                <div>
                    <label for="formula_ind">Fórmula <span class="requerido">*</span></label>
                    <input class="input" type="text" id="formula_ind" name="formula_ind" maxlength="200" placeholder="Fórmula">
                </div>

                <div>
                    <label for="anio_ind">Año <span class="requerido">*</span></label>
                    <input class="input" type="text" id="anio_ind" name="anio_ind" maxlength="4" placeholder="Año">
                </div>

                <div>
                    <label for="descrip_ind">Descripción <span class="requerido">*</span></label>
                    <input class="input" type="text" id="descrip_ind" name="descrip_ind" placeholder="Descripción">
                </div>

                <div>
                    <label for="id_obj">Objetivo <span class="requerido">*</span></label>
                    <select class="input" name="id_obj" id="id_obj" data-placeholder="Seleccione">

                    </select>

                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="button2 efects2__button2 btn_enviar"><i class="fa fa-check"></i>
                    Guardar</button>

                <button type="reset" id="btnCerrarModal_indicadores" class="button2 efects2__button2 btn_cancelar"><i class="fa fa-close"></i>
                    Cancelar</button>
            </div>
        </form>
    </div>


</div>
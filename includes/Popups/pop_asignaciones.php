<div id="overlay" class="overlay"></div>
<div id="pop_asignaciones" class="modal">
    <div class="content">
        <h2 id="pop_title_asignaciones" class="pop_title"></h2>
        <hr>
        <form method="post" id="asignaciones_form">
            <div id="asignaciones_form_contenedor" class="form_contenedor">
                <input type="hidden" name="id_asig" id="id_asig" />
                <input type="hidden" name="fechaDesactivacion_asig" id="fechaDesactivacion_asig" />


                <div>
                    <label for="id_met">Meta <span class="requerido">*</span></label>
                    <select class="input" id="id_met" name="id_met">
                    </select>
                </div>

                <div>
                    <label for="link_evidencia_asig">Link Evidencia <span class="requerido">*</span></label>
                    <input class="input" type="text" id="link_evidencia_asig" name="link_evidencia_asig" placeholder="Link documento...">
                </div>

                <div>
                    <label for="obser_asig">Observación <span class="requerido">*</span></label>
                    <input class="input" type="text" id="obser_asig" name="obser_asig" placeholder="Observación...">
                </div>

                <div>
                    <label for="trimestre_asig">Trimestre <span class="requerido">*</span></label>
                    <select class="input" id="trimestre_asig" name="trimestre_asig">
                        <option value="Primer trimestre">Primer trimestre</option>
                        <option value="Segundo trimestre">Segundo trimestre</option>
                        <option value="Tercer trimestre">Tercer trimestre</option>
                    </select>
                </div>

                <div>
                    <label for="cumpl_asig">Valor cumplimiento <span class="requerido">*</span></label>
                    <input class="input" type="text" id="cumpl_asig" name="cumpl_asig" placeholder="0">
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="button2 efects2__button2 btn_enviar"><i class="fa fa-check"></i>
                    Guardar</button>

                <button type="reset" id="btnCerrarModal_asignaciones" class="button2 efects2__button2 btn_cancelar"><i class="fa fa-close"></i>
                    Cancelar</button>
            </div>
        </form>
    </div>


</div>
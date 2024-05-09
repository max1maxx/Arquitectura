<div id="overlay" class="overlay"></div>
<div id="pop_metas" class="modal">
    <div class="content">
        <h2 id="pop_title_metas" class="pop_title"></h2>
        <hr>
        <form method="post" id="metas_form">
            <div id="metas_form_contenedor" class="form_contenedor">
                <input type="hidden" name="id_met" id="id_met" />
                <input type="hidden" name="fechaDesactivacion_met" id="fechaDesactivacion_met" />


                <div>
                    <label for="id_ind">Indicador <span class="requerido">*</span></label>
                    <select class="input" id="id_ind" name="id_ind">
                    </select>
                </div>

                <div>
                    <label for="estado_met">Estado <span class="requerido">*</span></label>
                    <select class="input" id="estado_met" name="estado_met">
                        <option value="VIGENTE">VIGENTE</option>
                        <option value="NO APLICABLE">NO APLICABLE</option>
                    </select>
                </div>

                <div>
                    <label for="linea_base_met">Línea Base <span class="requerido">*</span></label>
                    <input class="input" type="text" id="linea_base_met" name="linea_base_met" maxlength="4" placeholder="0">
                </div>

                <div>
                    <label for="comportamiento_met">Comportamiento <span class="requerido">*</span></label>
                    <select class="input" id="comportamiento_met" name="comportamiento_met">
                        <option value="CONTINUO">CONTINUO</option>
                        <option value="DISCRETO POR PERIODO">DISCRETO POR PERIODO</option>
                    </select>
                </div>

                <div>
                    <label for="unidad_medida_met">Unidad de medida <span class="requerido">*</span></label>
                    <select class="input" id="unidad_medida_met" name="unidad_medida_met">
                        <option value="NUMERO">NÚMERO</option>
                        <option value="PORCENTAJE">PORCENTAJE</option>
                    </select>
                </div>

                <div>
                    <label for="sentido_medicion_met">Sentido Medición <span class="requerido">*</span></label>
                    <select class="input" id="sentido_medicion_met" name="sentido_medicion_met">
                        <option value="ASCENDENTE">ASCENDENTE</option>
                        <option value="DESCENDENTE">DESCENDENTE</option>
                    </select>
                </div>

                <div>
                    <label for="denominador_met">Denominador <span class="requerido">*</span></label>
                    <input class="input" type="text" id="denominador_met" name="denominador_met" maxlength="4" placeholder="0">
                    </select>
                </div>

                <div>
                    <label for="primer_trimestre_met">Primer Trimestre <span class="requerido">*</span></label>
                    <input class="input" type="text" id="primer_trimestre_met" name="primer_trimestre_met" maxlength="4" placeholder="0">
                    </select>
                </div>

                <div>
                    <label for="segundo_trimestre_met">Segundo Trimestre <span class="requerido">*</span></label>
                    <input class="input" type="text" id="segundo_trimestre_met" name="segundo_trimestre_met" maxlength="4" placeholder="0">
                    </select>
                </div>

                <div>
                    <label for="tercer_trimestre_met">Tercer Trimestre <span class="requerido">*</span></label>
                    <input class="input" type="text" id="tercer_trimestre_met" name="tercer_trimestre_met" maxlength="4" placeholder="0">
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="button2 efects2__button2 btn_enviar"><i class="fa fa-check"></i>
                    Guardar</button>

                <button type="reset" id="btnCerrarModal_metas" class="button2 efects2__button2 btn_cancelar"><i class="fa fa-close"></i>
                    Cancelar</button>
            </div>
        </form>
    </div>


</div>
<div class="row">
    <div class="col-xs-12">
        <form id="frmCondicion" name="frmCondicion" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Nombre de la condición: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdCondicion" id="txtIdCondicion" value="{{ id }}"/>
                <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ nombre }}"
                       placeholder="Condición" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Flujo:</label>
                <input type="hidden" class="form-control" name="txtIdFlujo" id="txtIdFlujo" value="{{ id_flujo }}"/>
                <input type="hidden" class="form-control" name="txtFlujo" id="txtFlujo" value="{{ flujo }}"/>
                <select class="form-control" style="width:100%;" id="slFlujo" name="slFlujo" lang="es"></select>
            </div>
            <div class="form-group">
                <label>Valor: (Código PHQL)<span class="text-red">*</span> </label>
                <textarea class="form-control" name="txtValor"  id="txtValor" rows="4" placeholder="Consulta SQL la cual muestre la condición a cumplir."
                          data-fv-notempty="true">{{ valor }}</textarea>
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="4"
                          placeholder="Descripción detallada que podrá ayudar a identificar la condición." data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
            <p class="text-right text-muted"> <span class="text-yellow">**</span> NOTA: Es importante que siempre agregues en la sentencia WHERE <b> id_solicitud=:id_solicitud:</b></p>
        </form>
    </div>
</div>
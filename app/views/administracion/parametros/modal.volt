<div class="row">
    <div class="col-xs-12">
        <form id="frmParametro" name="frmParametro" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Nombre: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdParametro" id="txtIdParametro" value="{{ id_parametro }}"/>
                <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ nombre }}" placeholder="Nombre del parámetro" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Valor: <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="txtValor" id="txtValor" value="{{ valor }}" placeholder="Valor del parámetro" data-fv-notempty="true"/>
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" rows="2" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción clara del parámetro.">{{ descripcion }}</textarea>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <form id="frmEstatus" name="frmEstatus" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Estatus: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdEstatus" id="txtIdEstatus" value="{{ id }}"/>
                <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ nombre }}" placeholder="Estatus" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Color: <span class="text-red">*</span></label>
                <div class="input-group my-colorpicker2 colorpicker-element">
                    <input type="text" class="form-control" name="txtColor" value="{{ color }}"
                           id="txtColor" placeholder="Seleccionamos el color . . ." data-fv-notempty="true"  data-fv-color-type="'hex', 'hsl', 'hsla', 'keyword', 'rgb', 'rgba'"/>
                    <div class="input-group-addon">
                        <i id="iColor" style="background: {{ color }}"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="3" placeholder="Descripción detallada que podrá ayudar a identificar el estatus."
                          data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
        </form>
    </div>
</div>
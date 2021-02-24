<div class="row">
    <div class="col-xs-12">
        <form id="frmCalendario" name="frmCalendario" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label for ="txtFecha">Fecha del día inhábil:</label>
                <input type="hidden" class="form-control" name="txtIdDiaInhabil" id="txtIdDiaInhabil" value="{{ id }}"/>
                <div class='input-group'> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    <input type="hidden" class="form-control" name="txtDiaInhabil" id="txtDiaInhabil" value="{{ fecha }}"/>
                    <input type="text" class="form-control" name="txtFecha" id="txtFecha" placeholder="Día inhábil"
                           data-fv-notempty="true" />
                </div>
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="2" placeholder="Descripción detallada que podrá ayudar a identificar la fecha del día inhábil."
                          data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
        </form>
    </div>
</div>
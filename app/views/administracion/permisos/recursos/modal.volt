<div class="row">
    <div class="col-xs-12">
        <form id="frmRecurso" name="frmRecurso" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Recurso: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdRecurso" id="txtIdRecurso" value="{{ id }}" />
                <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ nombre }}" placeholder="Recurso" data-fv-notempty="true" />
            </div>
             <div class="form-group">
                 <label>Privacidad <span class="text-red">*</span></label>
                 <select id="slPrivacidad" name="slPrivacidad" class="form-control">
                    <option value="PRIVADA" selected>PRIVADA</option>
                    <option value="PUBLICA">PUBLICA</option>
                 </select>
             </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="3" placeholder="Descripción detallada que podrá ayudar a identificar el recurso."
                          data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
        </form>
    </div>
</div>
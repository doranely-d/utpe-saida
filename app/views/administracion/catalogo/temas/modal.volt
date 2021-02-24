<div class="row">
    <div class="col-xs-12">
        <form id="frmTema" name="frmTema" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Tema: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdTema" id="txtIdTema" value="{{ id_tema }}"/>
                <input type="text" class="form-control" name="txtTema" id="txtTema" value="{{ tema }}"
                       placeholder="Título del Tema" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="3" placeholder="Descripción detallada que podrá ayudar a identificar el tema."
                          data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <form id="frmSubtema" name="frmSubtema" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Tema:  <span class="text-red">*</span></label>
                <div class="col-sm-12 pad-mar">
                    <input type="hidden" class="form-control" name="txtIdTema" id="txtIdTema" value="{{ id_tema }}"/>
                    <input type="hidden" class="form-control" name="txtTema" id="txtTema" value="{{ tema }}"/>
                    <select class="form-control" style="width:100%" id="slTema" name="slTema" lang="es"></select>
                </div>
            </div>
            <div class="form-group">
                <label>Subtema: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdSubtema" id="txtIdSubtema" value="{{ id_subtema }}"/>
                <input type="text" class="form-control" name="txtSubtema" id="txtSubtema" value="{{ subtema }}"
                       placeholder="Título del Subtema" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="3" placeholder="Descripción detallada que podrá ayudar a identificar el subtema."
                          data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
        </form>
    </div>
</div>
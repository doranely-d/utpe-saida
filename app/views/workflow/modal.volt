<div class="row">
    <div class="col-xs-12">
        <form id="frmFlujo" name="frmFlujo" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Nombre: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtId" id="txtId" value="{{ ID }}"/>
                <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ NOMBRE }}" placeholder="Nombre del flujo" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="4" placeholder="Descripción a detalle que podrá ayudar a identificar el flujo."
                          data-fv-notempty="true">{{ DESCRIPCION }}</textarea>
            </div>
        </form>
    </div>
</div>
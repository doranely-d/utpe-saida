<div class="row">
    <div class="col-xs-12">
        <form id="frmMenu" name="frmMenu" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Menú: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdMenu" id="txtIdMenu" value="{{ id_menu }}"/>
                <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ nombre }}" placeholder="Nombre del menú" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Menú padre: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdPadre" id="txtIdPadre" value="{{ id_padre }}"/>
                <input type="hidden" class="form-control" name="txtPadre" id="txtPadre" value="{{ padre }}"/>
                <select class="form-control" style="width:100%" id="slPadre" name="slPadre" lang="es"></select>
            </div>
            <div class="form-group">
                <label>Url: <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="txtUrl" id="txtUrl" value="{{ url }}" placeholder="Url" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Icono: <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="txtIcono" id="txtIcono" value="{{ icono }}" placeholder="Icono a mostrar" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Orden: <span class="text-red">*</span></label>
                <input type="number" class="form-control" name="txtOrden" id="txtOrden" value="{{ orden }}" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="4" placeholder="Descripción detallada que podrá ayudar a identificar el item en el menú."
                          data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
        </form>
    </div>
</div>
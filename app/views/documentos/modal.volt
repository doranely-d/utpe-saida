<div class="row">
    <div class="col-xs-12">
        <form id="frmDocumento" name="frmDocumento" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nombre del documento: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdDocumento" id="txtIdDocumento" value="{{ id_documento }}"/>
                <input type="text" class="form-control" name="txtNombreDoc" id="txtNombreDoc" value="{{ nombre }}" placeholder="Nombre"
                       data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Selecciona el documento: <span class="text-red">*</span></label>
                <input id="inpDocumento" name="inpDocumento" type="file" data-fv-notempty="true" />
            </div>
        </form>
    </div>
</div>
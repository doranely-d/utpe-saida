<div class="row">
    <div class="col-md-12">
        <form id="frmUsuario" name="frmUsuario" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label class="text-muted">Nombre completo: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdUsuario" id="txtIdUsuario" value="{{ id_usuario }}"/>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-address-book"></i></div>
                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre(s)"   data-fv-regexp="true"
                           data-fv-regexp-regexp="^[.áéíóúñÁÉÍÓÚÑA-Za-z _]*$" data-fv-notempty="true"  maxlength="150" minlength="10" value="{{ nombre }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="text-muted">Correo electrónico: <span class="text-red">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                    <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" placeholder="Correo electrónico" data-fv-notempty="true" data-fv-email="true" value="{{ correo }}" />
                </div>
            </div>
        </form>
    </div>
</div>
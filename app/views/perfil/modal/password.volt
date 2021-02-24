<div class="row">
    <div class="col-md-12">
        <form id="frmUsuario" name="frmUsuario" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group" id="form-password">
                <div class="col-xs-6">
                    <div class="form-group row">
                        <input type="hidden" class="form-control" name="txtIdUsuario" id="txtIdUsuario" value="{{ id_usuario }}"/>
                        <label class="text-muted">Password: <span class="text-red">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-key"></i></div>
                            <input type="password" class="form-control" name="txtPassword" id="txtPassword"  data-fv-notempty="true"   minlength="6"
                                   data-fv-different="true" data-fv-different-field="txtUsuario" data-fv-different-message="La contraseña no puede ser igual al nombre de usuario."
                                   data-fv-not-empty-message="Por favor introduce un valor"/>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="text-muted">Confirmar password: <span class="text-red">*</span></label>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword"
                               data-fv-notempty="true" data-fv-identical="true" data-fv-identical-field="txtPassword" data-fv-identical-message=" Las contraseñas no coinciden."/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
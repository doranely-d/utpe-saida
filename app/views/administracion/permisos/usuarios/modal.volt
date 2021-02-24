<div class="row">
    <div class="col-md-12">
        <form id="frmUsuario" name="frmUsuario" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">

            <div class="form-group">
                <label class="text-muted">Usuario: <span class="text-red">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="hidden" class="form-control" name="txtIdUsuario" id="txtIdUsuario" placeholder="Id"  value="{{ id }}"/>
                    <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Nombre de usuario"  maxlength="15"
                           data-fv-notempty="true" value="{{ usuario }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="text-muted">Nombre completo: <span class="text-red">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-address-book"></i>
                    </div>
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
            <div class="form-group" id="form-password">
                <div class="col-xs-6">
                    <div class="form-group row">
                        <label class="text-muted">Password: <span class="text-red">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-key"></i></div>
                            <input type="password" class="form-control" name="txtPassword" id="txtPassword" placeholder="Password" data-fv-notempty="true"   minlength="6"
                                   data-fv-different="true" data-fv-different-field="txtUsuario" data-fv-different-message="La contraseña no puede ser igual al nombre de usuario."
                                   data-fv-not-empty-message="Por favor introduce un valor" value="{{ password }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="text-muted">Confirmar password: <span class="text-red">*</span></label>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword"
                               data-fv-notempty="true" data-fv-identical="true" data-fv-identical-field="txtPassword"
                               data-fv-identical-message=" Las contraseñas no coinciden."  value="{{ password }}"/>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-12"><br></div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active tab-blue"><a href="#tab_roles" data-toggle="tab" aria-expanded="true"><i class="fa fa-address-card "></i> Roles <span class="text-yellow">*</span></a></li>
                <li class="tab-blue"><a href="#tab_dependencias" data-toggle="tab" aria-expanded="false"><i class="fa fa-university"></i> Dependencias <span class="text-yellow">*</span></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_roles">
                    <form id="frmRol" name="frmRol" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" name="txtRol" id="txtRol" placeholder="Buscar rol.." data-fv-notempty="true" autocomplete="off"/>
                            <input type="hidden" class="form-control" name="txtInfoRol" id="txtInfoRol" placeholder="Info Rol" data-fv-notempty="true" />
                            <span class="input-group-btn">
                            <button type="submit" id="btnAgregarRol" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar</button>
                        </span>
                        </div>
                    </form>
                    <br>
                    <table id="tblRoles"
                           data-mobile-responsive="true"
                           data-locale="es-MX"
                           data-height="250"
                           data-pagination="true"
                           data-page-size="10"
                           data-page-list="[20, 30, 50, 100, 200]"
                           data-search="false"
                           data-toggle="false"
                           data-show-toggle="false"
                           data-resizable="false"
                           data-striped="false"
                           data-show-refresh="false"
                           data-show-footer="false"
                           class="table table-bordered table-hover table-condensed">
                        <thead>
                        <tr>
                            <th data-field="ID" data-visible="false" data-sortable="true">ID</th>
                            <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                            <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCIÓN</th>
                            <th data-sortable="false" data-align="center" data-formatter="usuarios.rolesFormatter" data-width="100">ACCIONES</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane" id="tab_dependencias">
                    <form id="frmDependencia" name="frmDependencia" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" name="txtDependencia" id="txtDependencia" placeholder="Dependencia" autocomplete="off" data-fv-notempty="true" style="text-transform: uppercase;" />
                            <input type="hidden" class="form-control" name="txtInfoDependencia" id="txtInfoDependencia" placeholder="Info Dependencia" data-fv-notempty="true" />
                            <span class="input-group-btn">
                                <button type="submit" id="btnAgregarDependencia" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar</button>
                            </span>
                        </div>
                    </form>
                    <br>
                    <table id="tblDependencias"
                           data-mobile-responsive="true"
                           data-locale="es-MX"
                           data-height="250"
                           data-pagination="true"
                           data-page-size="10"
                           data-page-list="[20, 30, 50, 100, 200]"
                           data-search="false"
                           data-toggle="false"
                           data-show-toggle="false"
                           data-resizable="false"
                           data-striped="false"
                           data-show-refresh="false"
                           data-show-footer="false"
                           class="table table-bordered table-hover table-condensed">
                        <thead>
                        <tr>
                            <th data-field="FLEX_VALUE_ID"  data-sortable="true">ID</th>
                            <th data-field="DESCRIPTION" data-sortable="true">NOMBRE</th>
                            <th data-field="FLEX_VALUE" data-sortable="true">IDENTIFICADOR</th>
                            <th data-sortable="false" data-align="center" data-formatter="usuarios.dependenciasFormatter" data-width="100">ACCIONES</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
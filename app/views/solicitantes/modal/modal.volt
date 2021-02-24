<div class="row">
    <div class="col-xs-12">
        <form id="frmSolicitantes" name="frmSolicitantes" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <label class="col-xs-2 datos-solicitante">Persona física:</label>
                        <div class="col-xs-4">
                            <label class="text-muted">Nombre(s):</label>
                            <input type="hidden" class="form-control" name="txtIdSolicitante" id="txtIdSolicitante" value="{{ id_solicitante }}"/>
                            <input id="txtNombre" name="txtNombre" class="form-control" value="{{ nombre }}" type="text" disabled>
                        </div>
                        <div class="col-xs-3">
                            <label class="text-muted">Apellido Paterno:</label>
                            <input class="form-control" name="txtApellidoP" id="txtApellidoP" value="{{ apellido_paterno }}" type="text" disabled>
                        </div>
                        <div class="col-xs-3">
                            <label class="text-muted">Apellido Materno:</label>
                            <input class="form-control" name="txtApellidoM" id="txtApellidoM" value="{{ apellido_materno }}" type="text" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-2 datos-solicitante">Persona Moral:</label>
                            <div class="col-xs-4">
                                <label class="text-muted">Razón Social:</label>
                                <input id="txtTelFijo" name="txtTelFijo" class="form-control" value="{{ telefono_fijo }}" type="text" disabled>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-xs-2 datos-solicitante"> Seudónimo:</label>
                        <div class="col-xs-4">
                            <input class="form-control" value="{{ seudonimo }}" type="text" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE PARA NOTIFICACIONES</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <label class="col-xs-2 radio-notificaciones control-label"> Correo electrónico
                        </label>
                        <div class="col-sm-4 area-4 area-notificacion">
                            <label class="text-muted"> Correo electrónico:</label>
                            <input class="form-control" name="txtCorreo" id="txtCorreo" value="{{ correo }}" type="text" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-xs-2 radio-notificaciones control-label">
                            Domicilio:
                        </label>
                        <div class="col-xs-5 area-5 area-notificacion">
                            <label class="text-muted"> Calle, número exterior y número interior:</label>
                            <input class="form-control" id="txtCalle" name="txtCalle" value="{{ domicilio }}"  type="text" disabled>
                        </div>
                        <div class="col-xs-5 area-5 area-notificacion">
                            <label class="text-muted"> Colonia o fraccionamiento:</label>
                            <input class="form-control" id="txtColonia" name="txtColonia" value="{{ colonia }}"  type="text" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-4 col-xs-offset-2  area-5 area-notificacion">
                            <label class="text-muted"> Entidad Federativa / País:</label>
                            <input class="form-control" id="txtEstado" name="txtEstado" value="{{ estado }}"  type="text" disabled>
                        </div>
                        <div class="col-xs-4 area-5 area-notificacion">
                            <label class="text-muted"> Delegación o municipio:</label>
                            <input class="form-control" id="txtMunicipio" name="txtMunicipio" value="{{ municipio }}"  type="text" disabled>
                        </div>
                        <div class="col-xs-2 area-5 area-notificacion">
                            <label class="text-muted"> Código Postal:</label>
                            <input class="form-control" id="txtCodigoP" name="txtCodigoP" value="{{ codigo_postal }}" type="text" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-4 col-xs-offset-2 area-5 area-notificacion">
                            <label class="text-muted"> Entre las calles:</label>
                            <input class="form-control" id="txtDireccion" name="txtDireccion" value="{{ domicilio }}"  type="text" disabled>
                        </div>
                        <div class="col-xs-4 area-5 area-notificacion">
                            <label class="text-muted"> Otras referencias para la ubicación del domicilio:</label>
                            <input class="form-control" id="txtColonia" name="txtColonia" value="{{ colonia }}" type="text" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-xs-2 radio-notificaciones control-label">Telefónos:
                        </label>
                        <div class="col-xs-3">
                            <label class="text-muted">Teléfono fijo:</label>
                            <input id="txtTelFijo" name="txtTelFijo" class="form-control" value="{{ telefono_fijo }}" type="text" disabled>
                        </div>
                        <div class="col-xs-3">
                            <label class="text-muted">Teléfono celular:</label>
                            <input class="form-control" name="txtTelCel" id="txtTelCel" value="{{ telefono_celular }}" type="text" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <label class="col-md-2 control-label">
                            Persona autorizada:
                        </label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-muted">Apellido paterno:</label>
                                <input class="form-control" id="txtApellidoPPA" name="txtApellidoPPA" value="{{ apellido_p_persona_a }}" type="text" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-muted"> Apellido Materno:</label>
                                <input class="form-control" id="txtApellidoMPA" name="txtApellidoMPA" value="{{ apellido_m_persona_a }}"type="text" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-muted"> Nombre(s):</label>
                                <input class="form-control" id="txtNombrePA" name="txtNombrePA" value="{{ nombre_persona_a }}" type="text" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
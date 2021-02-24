<div class="row">
    <div class="col-xs-12">
        <form id="frmTransaccion" name="frmTransaccion" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active tab-blue"><a href="#tab_transaccion" data-toggle="tab" aria-expanded="true">Conexión <span class="text-yellow">*</span></a></li>
                    <li class="tab-blue"><a href="#tab_roles" data-toggle="tab" aria-expanded="false">Roles <span class="text-yellow">*</span></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_transaccion">
                        <div class="col-md-12"><br></div>
                        <div class="form-group">
                            <label>Nombre: <span class="text-red">*</span></label>
                            <input type="hidden" class="form-control" name="txtIdFlujoA" id="txtIdFlujoA"/>
                            <input type="hidden" class="form-control" name="txtIdEtapaA" id="txtIdEtapaA" value="{{ ID_ETAPA }}"/>
                            <input type="hidden" class="form-control" name="txtIdTransaccion" id="txtIdTransaccion" value="{{ ID }}"/>
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ NOMBRE }}"
                                   placeholder="¿Que nombre debe tener conexión en el diagrama?" data-fv-notempty="true" />
                        </div>
                        <div class="form-group">
                            <label>Descripci&#243;n: <span class="text-red">*</span></label>
                            <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="2"
                                      placeholder="Descripción a detalle que podrá ayudar a identificar la conexión." data-fv-notempty="true">{{ DESCRIPCION }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="slAccion">Ir por este camino si...</label>
                            <select class="form-control" style="width:100%;" id="slAccion" name="slAccion" lang="es" data-fv-notempty="true"
                                    data-fv-notempty-message="Selecciona la acción a realizar">
                                <option value="0">Se pasa a la siguiente etapa</option>
                                <option value="1">Se prepara respuesta</option>
                                <option value="2">Se notifica al solicitante</option>
                                <option value="3">Se notifica a la UTPE</option>
                                <option value="4">Se cumple la condición</option>
                                <option value="5">No se cumple la condición</option>
                                <option value="6">Se turna a las dependencias</option>
                                <option value="9">Se turna a la UAR</option>
                                <option value="7">Se analiza las peticiones</option>
                                <option value="8">Se analiza la respuesta</option>
                                <option value="10">Se Termina el flujo</option>
                            </select>
                        </div>
                        <div class="form-group hidden conexion"  id="div-respuesta">
                            <label for="slPrevencion">Selecciona el tipo de notificación:</label>
                            <input type="hidden" class="form-control" name="txtIdPrevencion" id="txtIdPrevencion" value="{{ ID_PREVENCION }}"/>
                            <select class="form-control" style="width:100%;" id="slPrevencion" name="slPrevencion" lang="es" data-fv-notempty="true"></select>
                        </div>
                        <div class="form-group hidden conexion"  id="div-condicion">
                            <label for="slCondicion">Condición:</label>
                            <input type="hidden" class="form-control" name="txtIdCondicion" id="txtIdCondicion" value="{{ ID_CONDICION }}"/>
                            <select class="form-control" style="width:100%;" id="slCondicion" name="slCondicion" lang="es"></select>
                        </div>
                        <div class="form-group"  id="div-etapa">
                            <label for="slEtapa">Selecciona la etapa a conectar:</label>
                            <input type="hidden" class="form-control" name="txtIdNEtapa" id="txtIdNEtapa" value="{{ N_ETAPA_ID }}"/>
                            <select class="form-control" style="width:100%;" id="slEtapa" name="slEtapa" lang="es" data-fv-notempty="true"
                                    data-fv-notempty-message="Selecciona la etapa a conectar"></select>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_roles">
                        <div class="col-md-12"><br></div>
                        <form id="frmRol" name="frmRol" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok"
                              data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
                            <div class="input-group input-group-md">
                                <input type="text" class="form-control" name="txtRol" id="txtRol" placeholder="Escribe el nombre del rol para realizar la selección.." autocomplete="off"/>
                                <input type="hidden" class="form-control" name="txtInfoRol" id="txtInfoRol" placeholder="Info Rol" data-fv-notempty="true" />
                                <span class="input-group-btn">
                            <button type="button" id="btnAgregarRol" class="btn btn-success" onclick="workflowP.agregarRoles()"><span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar</button>
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
                                <th data-sortable="false" data-align="center" data-formatter="workflowP.rolesFormatter" data-width="100">ACCIONES</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
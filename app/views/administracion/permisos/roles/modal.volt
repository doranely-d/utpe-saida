<div class="row">
    <div class="col-xs-12">
        <form id="frmRol" name="frmRol" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok"
              data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label for="txtRol" class="control-label">Rol  <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdRol" id="txtIdRol" value="{{ id }}" placeholder="Id" />
                <input type="text" class="form-control" name="txtRol" id="txtRol" value="{{ nombre }}" placeholder="Nombre del rol" data-fv-notempty="true"/>
            </div>
            <div class="form-group">
                <label for="txtDescripcion" class="control-label">Descripci&#243;n: <span class="text-red">*</span></label>
                <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="3" placeholder="Descripción detallada que podrá ayudar a identificar el rol."
                          data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
        </form>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active tab-blue"><a href="#tab_recursos" data-toggle="tab" aria-expanded="true">Recursos del sistema <span class="text-yellow">*</span></a></li>
                <li class="tab-blue"><a href="#tab_menu" data-toggle="tab" aria-expanded="true">Menu del sistema <span class="text-yellow">*</span></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_recursos">
                    <form id="frmRecurso" name="frmRecurso" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok"
                          data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" name="txtRecurso" id="txtRecurso" placeholder="Búsqueda del recurso ..." data-fv-notempty="true" autocomplete="off"/>
                            <input type="hidden" class="form-control" name="txtInfoRecurso" id="txtInfoRecurso" placeholder="Info del recurso" data-fv-notempty="true" />
                            <span class="input-group-btn">
                            <button type="submit" id="btnAgregarRecurso" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar</button>
                        </span>
                        </div>
                    </form>
                    <br>
                    <table id="tblRecursos"
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
                            <th data-field="CVE_RECURSO" data-visible="false" data-sortable="true">CVE_RECURSO</th>
                            <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                            <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCIÓN</th>
                            <th data-sortable="false" data-align="center" data-formatter="roles.recursoFormatter" data-width="100">ACCIONES</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane" id="tab_menu">
                    <form id="frmMenu" name="frmMenu" role="form" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok"
                          data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" name="txtMenu" id="txtMenu" placeholder="Búsqueda del menu ..." data-fv-notempty="true" autocomplete="off"/>
                            <input type="hidden" class="form-control" name="txtInfoMenu" id="txtInfoMenu" placeholder="Info del menu" data-fv-notempty="true" />
                            <span class="input-group-btn">
                            <button type="submit" id="btnAgregarMenu" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar</button>
                        </span>
                        </div>
                    </form>
                    <br>
                    <table id="tblMenu"
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
                                <th data-field="ID_MENU" data-visible="false" data-sortable="true">ID</th>
                                <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                                <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCIÓN</th>
                                <th data-sortable="false" data-align="center" data-formatter="roles.menuFormatter" data-width="100">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <form id="frmTransacciones" name="frmTransacciones" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group pull-right" style="margin-top: 10px; margin-bottom: 10px;">
                <input type="hidden" class="form-control" name="txtIdEtapa" id="txtIdEtapa"/>
                <button type="button" id="btnTransaccion"
                        class="btn btn-success hidden" data-toggle="tooltip" data-placement="top" title="Agregar Conexión" onclick="workflowP.agregarTransaccion()">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp Agregar Conexión
                </button>
            </div>
            <table id="tblTransacciones"
                   data-mobile-responsive="true"
                   data-locale="es-MX"
                   data-height="500"
                   data-pagination="true"
                   data-side-pagination="server"
                   data-page-size="20"
                   data-search="false"
                   data-show-toggle="false"
                   data-striped="true"
                   data-resizable="true"
                   data-sort-order="asc"
                   data-show-refresh="false"
                   data-fixed-columns="false"
                   data-fixed-number="0"
                   data-advanced-search="false"
                   data-search-on-enter-key="false"
                   data-show-pagination-switch="false"
                   data-pagination-h-align="left"
                   data-smart-display="true"
                   data-cache="false"
                   class="table table-bordered table-hover table-condensed"
                   style="display: none;">
                <thead>
                    <tr>
                        <th data-field="ID" data-visible="false" data-sortable="true" data-align="center" >ID</th>
                        <th data-field="NOMBRE" data-sortable="true" >NOMBRE</th>
                        <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCION</th>
                        <th data-sortable="false" data-align="center" data-formatter="workflowP.transaccionesFormatter" data-width="100">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </form>
    </div>
</div>
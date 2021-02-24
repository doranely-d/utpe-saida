<div class="row">
    <div class="col-md-12">
        <form id="frmPreguntas" name="frmPreguntas" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <input type="hidden" class="form-control" name="txtIdPregunta" id="txtIdPregunta" value="{{ id_pregunta }}"/>
            <div class="row">
                <div class="col-md-12">
                    <table id="tblPreguntas"
                           data-mobile-responsive="true"
                           data-locale="es-MX"
                           data-height="500"
                           data-pagination="true"
                           data-side-pagination="server"
                           data-page-size="20"
                           data-search="true"
                           data-show-toggle="false"
                           data-striped="true"
                           data-resizable="true"
                           data-sort-name="ID_PREGUNTA"
                           data-sort-order="asc"
                           data-show-refresh="true"
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
                                <th data-field="NUMROW" data-align="center" data-formatter="solicitudes.numRowFormatter" data-width="40">NO</th>
                                <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCIÓN</th>
                                <th data-field="OBSERVACIONES">OBSERVACIONES</th>
                                <th data-field="FECHA_I" data-align="center" data-width="100">FECHA REGISTRO</th>
                                <th data-field="TURNADO" data-align="center" data-width="100" data-formatter="solicitudes.turnadoFormatter">TURNADO</th>
                                <th data-sortable="false" data-align="center" data-width="100" data-formatter="solicitudes.accionesFormatter">ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
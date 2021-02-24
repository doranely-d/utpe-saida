<div class="row">
    <div class="col-xs-12">
        <form id="frmTurnado" name="frmTurnado" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <input type="hidden" class="form-control" name="txtIdPregunta" id="txtIdPregunta" value="{{ id_pregunta }}"/>
            <div class="row">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="col-md-4 pull-right">
                            <table class="table table-bordered-title text-center">
                                <thead >
                                <tr>
                                    <th>FOLIO SOLICITUD</th>
                                    <th>FECHA REGISTRO</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><b>{{ folio }}</b></td>
                                    <td><b>{{ fecha_i }}</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <h4 class="text-muted">Información solicitada:</h4>
                            <textarea class="form-control" rows="4" disabled>{{ descripcion }}</textarea><br>
                            <h4 class="text-muted">Comentario adicional:</h4>
                            <textarea class="form-control" rows="4"></textarea><br>
                            <h4 class="text-muted">Dependencias:  <span class="text-yellow">*</span></h4>
                            <select multiple="multiple" name="slDependencias" id="slDependencias" lang="es"></select></br>
                            <p class="text-right text-muted"><span class="text-yellow">*</span> Realizar la búsqueda de las dependencias a las cuales turnar la pregunta seleccionada.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
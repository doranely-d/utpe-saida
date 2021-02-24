<div class="row">
    <div class="col-md-12">
        <form id="frmPreguntas" name="frmPreguntas" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <input type="hidden" class="form-control" name="txtIdPregunta" id="txtIdPregunta" value="{{ id_pregunta }}"/>
            <div class="row">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="col-md-7 pull-right">
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
                        <div class="col-md-12">
                            <h4 class="text-muted">Información solicitada:</h4>
                            <textarea class="form-control" rows="10" disabled>{{ descripcion }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
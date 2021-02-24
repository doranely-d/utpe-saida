<div class="row">
    <div class="col-xs-12">
        <form id="frmPregunta" name="frmPregunta" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>¿Cuál es la pregunta del solicitante?<span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdPregunta" id="txtIdPregunta" value="{{ id_pregunta }}"/>
                <input type="hidden" class="form-control" name="txtIdPreguntad" id="txtIdPreguntad" value="{{ numrow }}"/>
                <textarea class="form-control" rows="6" id="txtPregunta" name="txtPregunta" placeholder="Descripción clara de la información requerida."  data-fv-notempty="true">{{ descripcion }}</textarea>
            </div>
            <div class="form-group">
                <label>Observaciones de la pregunta descrita anteriormente para ayudar con el turnado:</label>
                <textarea class="form-control" rows="4" id="txtObservacion" name="txtObservacion" placeholder="Descripción de las observaciones que podran ayudar al ser turnada la pregunta.">{{ observaciones }}</textarea>
            </div>
        </form>
    </div>
</div>
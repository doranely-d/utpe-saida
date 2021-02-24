<div class="row">
    <div class="col-md-12">
        <form id="frmPreguntas" name="frmPreguntas" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <input type="hidden" class="form-control" name="txtIdPregunta" id="txtIdPregunta" value="{{ id_pregunta }}"/>
            <div class="row">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="col-md-12">
                            <h4 class="text-muted">Folio: {{ folio }}</h4>
                            <h4 class="text-muted">Fecha Ingreso: {{ fecha_i }}</h4>
                            {% if consentimiento === '1' %}
                                <h4 class="text-muted">Antecedente de la solicitud:</h4>
                                <textarea class="form-control" rows="6" disabled>{{ antecedente }}</textarea>
                            {% endif  %}
                        </div>
                        <div class="col-md-12">
                            <h4 class="text-muted">¿Cuál es la pregunta del solicitante?</h4>
                            <textarea class="form-control" rows="6" disabled>{{ descripcion }}</textarea>
                            {% if observaciones %}
                                <h4 class="text-muted">Observaciones de la pregunta descrita anteriormente para ayudar con el turnado:</h4>
                                <textarea class="form-control" rows="6" disabled>{{ observaciones }}</textarea>
                            {% endif  %}
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
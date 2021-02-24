<div class="row">
    <div class="col-xs-12">
        <form id="frmMedio" name="frmMedio" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label>Medio de respuesta: <span class="text-red">*</span></label>
                <input type="hidden" class="form-control" name="txtIdMedio" id="txtIdMedio" value="{{ id_medio_respuesta }}"/>
                <input type="text" class="form-control" name="txtMedio" id="txtMedio" value="{{ medio }}" placeholder="Medio de respuesta" data-fv-notempty="true" />
            </div>
            <div class="form-group">
                <label>Costo: <span class="text-yellow">**</span></label>
                <input type="number" step="0.01" class="form-control" name="txtCosto" id="txtCosto" value="{{ costo }}"  data-fv-notempty="false" />
            </div>
            <p class="text-right"> <span class="text-yellow">**</span> El medio de respuesta puede o no generar algun costo</p>
        </form>
    </div>
</div>
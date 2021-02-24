<div class="row">
    <div class="col-xs-12">
        <form id="frmTurnado" name="frmTurnado" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
              data-fv-icon-validating="glyphicon glyphicon-refresh">
            <input type="hidden" class="form-control" name="txtIdPregunta" id="txtIdPregunta" value="{{ id_pregunta }}"/>
            <div class="row">
                <div class="box box-solid">
                    <div class="col-md-12">
                        <div class="box box-default collapsed-box">
                            <div class="box-header with-border">
                                <div class="pull-left">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i><h3 class="box-title"> &nbsp;Mostrar más detalle</h3></button>
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body" style="">
                                <h4 class="text-muted">Información solicitada:</h4>
                                <textarea class="form-control" rows="3" disabled>{{ descripcion }}</textarea><br>
                                <h4 class="text-muted">Observaciones:</h4>
                                <textarea class="form-control" rows="3" disabled>{{ observaciones }}</textarea>  <br>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h4 class="text-muted">Búsqueda de las dependencias a las cuales turnar la pregunta seleccionada:  <span class="text-yellow">*</span></h4>
                        <select multiple="multiple" name="slDependencias" id="slDependencias" lang="es"></select></br>
                        <h4 class="text-muted">Proporciona datos adicionales para facilitar el turnado de la información:</h4>
                        <textarea class="form-control" rows="3" id="txtComentario" name="txtComentario"></textarea><br>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
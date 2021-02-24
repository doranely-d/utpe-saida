<div class="row">
    <div class="col-xs-12">
        <form id="frmEtapa" name="frmEtapa" role="form" method="post" data-fv-framework="bootstrap"
              data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active tab-blue"><a href="#tab_etapa" data-toggle="tab" aria-expanded="true">Datos de la etapa <span class="text-yellow">*</span></a></li>
                    <li class="tab-blue"><a href="#tab_estado" data-toggle="tab" aria-expanded="false">Datos del estado <span class="text-yellow">*</span></a></li>
                    <li class="tab-blue"><a href="#tab_plazos" data-toggle="tab" aria-expanded="false">Plazos <span class="text-yellow">*</span></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_etapa">
                        <div class="col-md-12"><br></div>
                        <div class="form-group">
                            <label>Nombre: <span class="text-red">*</span></label>
                            <input type="hidden" class="form-control" name="txtIdFlujoA" id="txtIdFlujoA"/>
                            <input type="hidden" class="form-control" name="txtId" id="txtId" value="{{ ID }}"/>
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="{{ NOMBRE }}" placeholder="Escribe el de la nueva etapa" data-fv-notempty="true" />
                        </div>
                        <div class="form-group">
                            <label for="slPrincipal">¿La nueva etapa es una condición?</label>
                            <input type="hidden" class="form-control" name="txtCondicion" id="txtCondicion" value="{{ CONDICION }}"/>
                            <select class="form-control" style="width:100%;" id="slCondicion" name="slCondicion" lang="es">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Color de la etiqueta: <span class="text-red">*</span></label>
                            <div class="input-group my-colorpicker2 colorpicker-element">
                                <input type="text" class="form-control" name="txtColor" value="{{ COLOR }}"
                                       id="txtColor" placeholder="Seleccionamos el color como etiqueta de la etapa . . ." data-fv-notempty="true"  data-fv-color-type="'hex', 'hsl', 'hsla', 'keyword', 'rgb', 'rgba'"/>
                                <div class="input-group-addon"><i id="iColor" style="background: {{ COLOR }}"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Descripci&#243;n: <span class="text-red">*</span></label>
                            <textarea class="form-control" name="txtDescripcion"  id="txtDescripcion" rows="3" placeholder="Descripción a detalle que podrá ayudar a identificar la etapa."
                                      data-fv-notempty="true">{{ DESCRIPCION }}</textarea>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_estado">
                        <div class="col-md-12"><br></div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="txtIdEstado" id="txtIdEstado" value="{{ ID_ESTADO }}"/>
                            <label>Nombra el estado de la solicitud para esta etapa: <span class="text-red">*</span></label>
                            <input type="text" class="form-control" name="txtNombreEstado" id="txtNombreEstado" value="{{ NOMBRE_ESTADO }}" placeholder="Escribe el nombre del estado de la solicitud" data-fv-notempty="true"/>
                        </div>
                        <div class="form-group">
                            <label>Color de la etiqueta: <span class="text-red">*</span></label>
                            <div class="input-group my-colorpicker2 colorpicker-element">
                                <input type="text" class="form-control" name="txtColorEstado" value="{{ COLOR_ESTADO }}"
                                       id="txtColorEstado" placeholder="Seleccionamos el color como etiqueta del estado . . ." data-fv-notempty="true"  data-fv-color-type="'hex', 'hsl', 'hsla', 'keyword', 'rgb', 'rgba'"/>
                                <div class="input-group-addon"><i id="iColor2" style="background: {{ COLOR_ESTADO }}"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Descripci&#243;n: <span class="text-red">*</span></label>
                            <textarea class="form-control" name="txtDescripcionEstado"  id="txtDescripcionEstado" rows="3" placeholder="Descripción a detalle que podrá ayudar a identificar el estado."
                                      data-fv-notempty="true">{{ DESCRIPCION_ESTADO }}</textarea>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_plazos">
                        <div class="col-md-12"><br></div>
                        <div class="form-group ">
                            <label>Días asignados por la ley: <span class="text-red">*</span></label>
                            <input type="text" class="form-control" name="txtDiasLey" id="txtDiasLey" value="{{ DIAS_LEY }}"
                                   placeholder="Días asignados por la ley" data-fv-notempty="true" />
                        </div>
                        <div class="form-group">
                            <label>Días asignados por la UTPE: <span class="text-red">*</span></label>
                            <input type="text" class="form-control" name="txtDiasUtpe" id="txtDiasUtpe" value="{{ DIAS_UTPE }}"
                                   placeholder="Días asignados por la UTPE" data-fv-notempty="true" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
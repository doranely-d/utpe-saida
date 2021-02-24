{# solicitudes/registro-sai.volt #}
{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/wizard/fuelux.min.css') }}
    {{ stylesheet_link('css/bootstrap/fileinput.css') }}
    {{ stylesheet_link('css/bootstrap/sweetalert.css') }}
    {{ stylesheet_link('css/bootstrap/bootstrap-datetimepicker.min.css') }}
    {{ stylesheet_link('css/bootstrap/select2.min.css') }}
    {{ stylesheet_link('css/bootstrap3-editable/css/bootstrap-editable.css') }}
    {{ stylesheet_link('js/extra/iCheck/all.css') }}
{% endblock %}

{% block content %}
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <section class="content">
        <!-- WIZARD -->
        <div class="fuelux">
            <div class="wizard" data-initialize="wizard" id="formularioWizard" data-restrict="previous">
                <div class="steps-container">
                    <ul class="steps">
                        <li data-step="1" class="active">
                            <span class="badge">1</span>Informacion del solicitante<span class="chevron"></span>
                        </li>
                        <li data-step="2">
                            <span class="badge">2</span>Información de la Solicitud<span class="chevron"></span>
                        </li>
                    </ul>
                </div>
                <div class="actions">
                    <button type="button" class="btn btn-success btn-next btn-lg" data-last="Finalizar">
                        Siguiente<span class="glyphicon glyphicon-arrow-right"></span>
                    </button>
                </div>
                <!-- FORMULARIO DE REGISTRO DE SOLICITUD -->
                <form id="frmSolicitud" name="frmSolicitud" method="POST" action="#">
                    <!-- DATOS NECESARIOS PARA LA CAPTURA DE SOLICITUD -->
                    <input type="hidden" class="form-control" name="txtIdSolicitud" id="txtIdSolicitud" value="{{ id }}"/>
                    <!-- / DATOS NECESARIOS PARA LA CAPTURA DE SOLICITUD -->

                    <div class="step-content">
                        <!-- INFORMACIÓN DEL SOLICITANTE -->
                        <div class="step-pane active" data-step="1">
                            <!-- ENCABEZADO SOLICITUD -->
                            <div class="panel panel-default panel-solicitud">
                                <div class="panel-body ">
                                    <div class="rows">
                                        <div class="col-md-5">{{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,'style': 'opacity:0.3;width: 75%;') }}</div>
                                        <div class="col-md-7  pull-right">
                                            <h3 class="text-right"><b> SOLICITUD DE ACCESO A LA INFORMACIÓN </br>PÚBLICA DEL PODER EJECUTIVO</b></h3>
                                            <div class="row">
                                                <div class="col-md-5  pull-right">
                                                    <table class="table table-bordered-title text-center">
                                                        <thead>
                                                            <tr>
                                                                <th width="50" scope="col">FOLIO</th>
                                                                <th width="50" scope="col">FECHA REGISTRO</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><b>{{ folio }}</b></td>
                                                                <td><b>{{ date("d/m/Y")}}</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">SOBRE EL AVISO DE PRIVACIDAD</h3>
                                    </div>
                                    <div class="panel-body">
                                        <b> La Unidad de Transparencia del Poder Ejecutivo del Estado de Querétaro es el organismo
                                            responsable del  tratamiento de los datos que nos proporcione, mismos que serán utilizados
                                            para efectuar el trámite de su solicitud de acceso a la información pública.
                                            Consulte nuestro aviso de privacidad en
                                            <a href="http://bit.ly/2zqyiGf" target="_blank">http://bit.ly/2zqyiGf</a> o en la oficina de atención de la Unidad.
                                        </b>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE Y/O REPRESENTANTE LEGAL</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-2 texto-centrado">
                                                <input type="radio"  name="grupo-radio"  value="radio-solicitante" class="radio" checked> Solicitante
                                            </label>
                                        </div>
                                        <div class="row area-solicitud">
                                            <label class="col-md-2 text-right">
                                                <input type="radio"  name="grupo-radio-persona"  value="radio-pfisica"
                                                       class="radio-persona" checked>Persona física:
                                            </label>
                                            <div class="radio-solicitante radio-pfisica">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Apellido Paterno</label>
                                                        <input class="form-control" name="txtApellidoP" id="txtApellidoP"
                                                               placeholder="Apellido Paterno" type="text" data-fv-notempty="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Apellido Materno</label>
                                                        <input class="form-control" name="txtApellidoM" id="txtApellidoM"
                                                               placeholder="Apellido Materno" type="text" data-fv-notempty="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Nombre(s)</label>
                                                        <input id="txtNombre" name="txtNombre" class="form-control"
                                                               placeholder="Nombre(s)" type="text" data-fv-notempty="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row area-solicitud">
                                            <label class="col-md-2 text-right">
                                                <input type="radio" name="grupo-radio-persona" value="radio-pmoral" class="radio-persona">Persona moral:
                                            </label>
                                            <div class="col-md-6 radio-pmoral ">
                                                <div class="form-group">
                                                    <label class="text-muted">Razón social</label>
                                                    <input class="form-control" id="txtRazonSocial" name="txtRazonSocial"
                                                           placeholder="Razón social o denominación" type="text" data-fv-notempty="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2 text-right">Representante legal: <span class="text-yellow">*</span></label>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Apellido Paterno (representante):</label>
                                                    <input class="form-control" name="txtApellidoPR" id="txtApellidoPR"
                                                           placeholder="Apellido Paterno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Apellido Materno (representante):</label>
                                                    <input class="form-control" name="txtApellidoMR" id="txtApellidoMR"
                                                           placeholder="Apellido Materno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Nombre(s) (representante):</label>
                                                    <input id="txtNombreR" name="txtNombreR" class="form-control"
                                                           placeholder="Nombre(s)" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right"> <b><span class="text-yellow">*</span></b> Solamente con poder notarial
                                            (presentar original o copia certificada para cotejo)</p>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 texto-centrado">
                                                <input type="radio"  name="grupo-radio"  value="radio-seudonimo" class="radio"> Seudónimo
                                            </label>
                                            <div class="col-sm-4 radio-seudonimo">
                                                <div class="form-group">
                                                    <label class="text-muted">Seudónimo (indicar)</label>
                                                    <input class="form-control" id="txtSeudonimo" name="txtSeudonimo"
                                                           type="text" placeholder="Seudónimo" data-fv-notempty="true">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 texto-centrado">
                                                <input type="radio" name="grupo-radio"  value="radio-anonimo" id="radio-anonimo" class="radio"> Anónimo
                                            </label>
                                            <div class="col-sm-8">
                                                Al representar su solicitud utilizando seudónimo  o de forma anónima, no es
                                                necesario completar la siguiente sección ni firmar la presente solicitud.
                                                <br>Sin embargo, debe considerar que la(s) notificación(es) que corresponda(n)
                                                a su trámites, se realizará en los ESTRADOS de la Unidad de Transparencia del Poder Ejecutivo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE O REPRESENTANTE LEGAL - PARA NOTIFICACIONES</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-2 radio-notificaciones control-label text-right">
                                                <input type="checkbox" class="minimal" value="checkbox-correo" checked> Correo electrónico
                                            </label>
                                            <div class="col-md-4 checkbox-correo area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Correo electrónico:</label>
                                                    <input class="form-control" id="txtCorreo" name="txtCorreo" type="email"
                                                           placeholder="Dirección de correo electrónico válida" data-fv-notempty="true">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 radio-notificaciones control-label text-right">
                                                <input type="checkbox" class="minimal" value="checkbox-domicilio" checked> Domicilio <span class="text-yellow">**</span>
                                            </label>
                                            <div  class="col-md-5 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Calle, número exterior y número interior:</label>
                                                    <input class="form-control" id="txtDireccion" name="txtDireccion" type="text"
                                                           placeholder="Calle, número exterior y número interior"  data-fv-notempty="true">
                                                </div>
                                            </div>
                                            <div class="col-md-5 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Colonia o fraccionamiento:</label>
                                                    <input class="form-control" id="txtColonia" name="txtColonia"
                                                           placeholder="Colonia o fraccionamiento" type="text" data-fv-notempty="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-2 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Entidad Federativa / País:</label>
                                                    <select class="form-control" style="width:100%" id="slEstado"
                                                            name="slEstado" data-fv-notempty="true">
                                                        <option value=""> Selecciona el estado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Delegación o municipio:</label>
                                                    <select class="form-control" style="width:100%" id="slMunicipio"
                                                            name="slMunicipio" data-fv-notempty="true">
                                                        <option value=""> Selecciona el municipio</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Código Postal:</label>
                                                    <input class="form-control" id="txtCodigoP" name="txtCodigoP"
                                                           placeholder="C.P " type="text" data-fv-notempty="true" data-mask="0#" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-2 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Entre las calles:</label>
                                                    <input class="form-control" id="txtEntreCalles" name="txtEntreCalles"
                                                           type="text" data-fv-notempty="true" >
                                                </div>
                                            </div>
                                            <div class="col-md-4 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Otras referencias para la ubicación del domicilio:</label>
                                                    <input class="form-control" id="txtOtraReferencia" name="txtOtraReferencia"
                                                           type="text" data-fv-notempty="true" >
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right text-muted"><b><span class="text-yellow">** </span></b>
                                            Todas las notificaciones fuera del Municipio de Querétaro y zona conurbada se efectuarán por correo certificado.</p>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 radio-notificaciones control-label text-right">
                                                <input type="checkbox" class="minimal" value="checkbox-telefono" checked> Telefóno
                                            </label>
                                            <div class="checkbox-telefono area-notificacion">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Telefóno Fijo:</label>
                                                        <input class="form-control" id="txtTelefonoFijo" name="txtTelefonoFijo"
                                                               placeholder="Telefóno Fijo" type="text" data-mask="0#">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Telefóno Celular:</label>
                                                        <input class="form-control" id="txtTelefonoCel" name="txtTelefonoCel"
                                                               placeholder="Telefóno Celular" type="text" data-mask="(00) 0000-0000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right text-muted">Únicamente para informarle sobre la existencia de notificación,
                                            misma que deberá recoger en la Unidad. <br>De no contar con otro dato
                                            para la debida notificación y/o si no es posible localizarlo por
                                            este medio, se efectuará la notificación en Estrados de la Unidad.</p>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 control-label text-right">Persona autorizada:</label>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Apellido paterno:</label>
                                                    <input class="form-control" id="txtApellidoPPA" name="txtApellidoPPA"
                                                           placeholder="Apellido paterno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted"> Apellido Materno:</label>
                                                    <input class="form-control" id="txtApellidoMPA" name="txtApellidoMPA"
                                                           placeholder=" Apellido Materno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted"> Nombre(s):</label>
                                                    <input class="form-control" id="txtNombrePA" name="txtNombrePA"
                                                           placeholder="Nombre(s)" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right text-muted">Distinta al titular o representante legal. Deberá presentar carta poder al momento de ser notificado.</p>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">CONSENTIMIENTO PARA EL TRATAMIENTO DE DATOS PERSONALES</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <p><b>La información de la presente Solicitud debe ser registrada y capturada en la Plataforma
                                                    Nacional de Transparencia, administrada por el Instituto Nacional de Transparencia,
                                                    Acceso a la Información y Protección de Datos Personales, según lo establecido en el
                                                    artículo 118 de la Ley de Transparencia y Acceso a la Información Pública del Estado de Querétaro.
                                                </b></p>
                                            <p><b> Autorizo a la Unidad, para el uso de los datos personales proporcionados en la presente solicitud, para su registro y captura en la PNT:</b></p>
                                            <div class="form-group">
                                                <label style="margin: 10px"><input type="radio" name="radio-consentimiento" class="radio-consentimiento" value="1" checked="">Si</label>
                                                <label style="margin: 10px"><input type="radio" name="radio-consentimiento" class="radio-consentimiento"  value="0">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-pane" data-step="2">
                            <!-- ENCABEZADO SOLICITUD -->
                            <div class="panel panel-default panel-solicitud">
                                <div class="panel-body">
                                    <div class="rows">
                                        <div class="col-md-5">{{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,'style': 'opacity:0.3;width: 75%;') }}</div>
                                        <div class="col-md-7  pull-right">
                                            <h3 class="text-right"><b> SOLICITUD DE ACCESO A LA INFORMACIÓN </br>PÚBLICA DEL PODER EJECUTIVO</b></h3>
                                            <div class="row">
                                                <div class="col-md-5  pull-right">
                                                    <table class="table table-bordered-title text-center">
                                                        <thead>
                                                            <tr>
                                                                <th width="50" scope="col">FOLIO</th>
                                                                <th width="50" scope="col">FECHA REGISTRO</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><b>{{ folio }}</b></td>
                                                                <td><b>{{ date("d/m/Y")}}</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panel-center">DESCRIPCIÓN DE LA INFORMACIÓN SOLICITADA </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-3 control-label"><input type="checkbox" class="checkbox-antecedente" value="checkbox-antecedente"> Agregar antecedente</label>
                                        <div class="col-md-10 col-md-offset-1 checkbox-antecedente hidden">
                                            <label>Antecedentes de la solicitud:</label>
                                            <textarea class="form-control" rows="4" id="txtAntecedentes" name="txtAntecedentes"
                                                      placeholder="Redactar los antecedentes de la solicitud.">{{ antecedente }}</textarea>
                                            <label><input type="checkbox" class="minimal" value="checkbox-antecedentes" checked> Mostrar antecedente a las dependencias</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <label class="col-md-3 control-label"><input type="checkbox" class="checkbox" value="checkbox-preguntas"> Dividir en varias preguntas</label>
                                        <div class="col-md-10 col-md-offset-1 checkbox-agrupar">
                                            <div class="form-group">
                                                <label>¿Cuál es la pregunta del solicitante?<span class="text-red">*</span></label>
                                                <textarea class="form-control" rows="4" id="txtPeticion" name="txtPeticion"
                                                          placeholder="Descripción de las observaciones que podran ayudar al ser turnada la pregunta."
                                                          data-fv-notempty="true">{{ antecedente }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Observaciones de la pregunta descrita anteriormente para ayudar con el turnado</label>
                                                <textarea class="form-control" rows="4" id="txtObservaciones" name="txtObservaciones"
                                                          placeholder="Descripción de las observaciones que podran ayudar al ser turnada la pregunta."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1 checkbox-preguntas hidden">
                                            <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                                <button id="btnAgregarPregunta" class="btn btn-success" data-toggle="tooltip"
                                                        data-placement="top" title="Agregar Pregunta">
                                                    <span class="fa fa-plus"></span>&nbsp; Agregar Pregunta
                                                </button>
                                            </div>
                                            <table id="tblPreguntas"
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
                                                   data-sort-name="ID_PREGUNTA"
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
                                                        <th data-field="NUMROW" data-align="center" data-formatter="solicitudes.numRowFormatter"
                                                            data-width="100">NO. PREGUNTA</th>
                                                        <th data-field="DESCRIPCION" data-sortable="false">DESCRIPCIÓN</th>
                                                        <th data-field="OBSERVACIONES" data-sortable="false">OBSERVACIONES</th>
                                                        <th data-sortable="false" data-align="center" data-width="100"
                                                            data-formatter="solicitudes.actionFormatter">ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panel-center">DATOS QUE FACILITEN LA BÚSQUEDA Y EVENTUAL LOCALIZACIÓN DE LA INFORMACIÓN</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-md-2 text-right" style="padding-top: 20px;">
                                            Catálogo de temas <span class="text-yellow">*</span>
                                        </label>
                                        <div class="form-group col-md-3">
                                            <label for="slTema" class="text-muted text-right">Tema: <span class="text-red">*</span></label>
                                            <select class="form-control" style="width:100%" id="slTema" name="slTema" data-fv-notempty="true"></select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="slSubtema" class="text-muted text-right">Subtema: <span class="text-red">*</span></label>
                                            <select class="form-control" style="width:100%" id="slSubtema" name="slSubtema" data-fv-notempty="true"></select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="slTitulo" class=" text-muted text-right">Título:</label>
                                            <select class="form-control" style="width:100%" id="slTitulo" name="slTitulo"></select>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="text-right">
                                        <span class="text-yellow">*</span>
                                        Agregar la información necesaria sobre la relación del tema con la solicitud, asignando un catálogo a la solicitud.
                                    </p>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panel-center">INDIQUE CÓMO DESEA RECIBIR LA INFORMACIÓN (Ver numeral 9 y 10 de la sección de Información General) </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <p>Para proceder a pagar es necesario que seleccione uno de los Trámites del siguiente
                                                listado y agregue el concepto. Si necesita ayuda, llámenos al teléfono (442) 211 7070
                                                o  al 01-800 237 2233 de lunes a viernes de 08:00 a 20:00 hrs. y sábados de 09:00 a 14:00 hrs.</p>
                                            <div class="form-group col-md-3">
                                                <label for="slMedioR" class=" text-muted text-right">Medio de respuesta: <span class="text-red">*</span></label>
                                                <select class="form-control" style="width:100%" id="slMedioR" name="slMedioR" lang="es"></select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="text-muted text-right">Cantidad: <span class="text-red">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-cart-plus"></i></div>
                                                    <input class="form-control" id="txtCantidad" name="txtCantidad" type="number"value="1">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="text-muted text-right">Importe: <span class="text-red">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                                                    <input class="form-control" id="txtImporte" name="txtImporte" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3" style="padding-top: 25px;">
                                                <button id="btnAgregarMedio" type="button" class="btn btn-success" data-toggle="tooltip"
                                                        data-placement="top" title="Agregar medio de respuesta"><span class="fa fa-plus"></span>&nbsp; Agregar Medio
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <table id="tblMediosRespuesta"
                                                   data-toggle="tblMediosRespuesta"
                                                   data-show-footer="true"
                                                   data-mobile-responsive="true"
                                                   data-locale="es-MX"
                                                   data-show-export="false"
                                                   data-pagination="true"
                                                   data-side-pagination="server"
                                                   data-page-size="20"
                                                   data-search="false"
                                                   data-show-toggle="false"
                                                   data-striped="true"
                                                   data-resizable="true"
                                                   data-click-to-select="false"
                                                   data-sort-name="ID_MEDIO_RESPUESTA"
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
                                                   class="table table-bordered table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th data-field="ID_MEDIO_RESPUESTA"  data-sortable="false">ID</th>
                                                        <th data-field="MEDIO" data-sortable="false">DESCRIPCIÓN</th>
                                                        <th data-field="CANTIDAD" data-sortable="false">CANTIDAD</th>
                                                        <th data-field="IMPORTE" data-sortable="false" data-formatter="general.formatoMoneda"
                                                            data-align="center" data-footer-formatter="solicitudes.totalFormatter">IMPORTE</th>
                                                        <th data-sortable="false" data-align="center" data-formatter="solicitudes.mediosFormatter" data-width="100">ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panel-center">DOCUMENTOS ANEXOS </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                                <button id="btnAgregarDocumento" type="button" class="btn btn-success" data-toggle="tooltip"
                                                        data-placement="top" title="Agregar Documento"><span class="fa fa-plus"></span>&nbsp; Agregar Documento
                                                </button>
                                            </div>
                                            <table id="tblDocumentos"
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
                                                   data-sort-name="ID_DOCUMENTO"
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
                                                   class="table table-bordered table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th data-field="NUMROW" data-align="center" data-sortable="true"
                                                            data-formatter="solicitudes.numRowFormatter"  data-width="100">NO. DOCUMENTO</th>
                                                        <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                                                        <th data-field="EXTENSION" data-sortable="true">EXTENSIÓN</th>
                                                        <th data-sortable="false" data-align="center" data-width="200"
                                                            data-formatter="solicitudes.documentoActionFormatter">ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <a id="scrolltop"></a><!-- ScrollTop -->
            </div>
        </div>
    </section>
</div>
{% endblock %}

{% block footer %}
    {{ javascript_include('js/jquery/select2/select2.min.js') }}
    {{ javascript_include('js/jquery/select2/language/es.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-datetimepicker.min.js') }}
    {{ javascript_include('js/bootstrap/sweetalert.js') }}
    {{ javascript_include('js/wizard/fuelux.min.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/editable/bootstrap-table-editable.js') }}
    {{ javascript_include('css/bootstrap3-editable/js/bootstrap-editable.min.js') }}
    {{ javascript_include('js/bootstrap/fileinput/fileinput.js') }}
    {{ javascript_include('js/bootstrap/fileinput/locales/es.js') }}
    {{ javascript_include('js/jquery/mask/jquery.mask.js') }}
    {{ javascript_include('js/jquery/jquery.fileDownload.js') }}
    {{ javascript_include('js/extra/iCheck/icheck.min.js') }}
    {{ javascript_include('js/views/solicitudes/registro-sai.js') }}
{% endblock %}
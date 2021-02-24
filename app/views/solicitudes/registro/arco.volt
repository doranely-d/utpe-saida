{# registro/arco.volt #}
{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/wizard/fuelux.min.css') }}
    {{ stylesheet_link('css/bootstrap/fileinput.css') }}
    {{ stylesheet_link('css/bootstrap/sweetalert.css') }}
    {{ stylesheet_link('css/bootstrap/bootstrap-datetimepicker.min.css') }}
    {{ stylesheet_link('css/bootstrap/select2.min.css') }}
    {{ stylesheet_link('css/bootstrap3-editable/css/bootstrap-editable.css') }}
    {{ stylesheet_link('css/jquery/multi.min.css') }}
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
                        <button type="button" class="btn btn-success btn-next btn-lg" data-last="Finalizar">Siguiente<span class="glyphicon glyphicon-arrow-right"></span></button>
                    </div>
                    <!-- FORMULARIO DE REGISTRO DE SOLICITUD -->
                    <form id="frmSolicitud" name="frmSolicitud" method="POST" action="#">
                        <!-- DATOS NECESARIOS PARA LA CAPTURA DE SOLICITUD -->
                        <input type="hidden" class="form-control" name="txtIdSolicitud" id="txtIdSolicitud" value="{{ id }}"/>
                        <input type="hidden" class="form-control" name="txtIdEtapa" id="txtIdEtapa" value="{{ id_etapa }}"/>
                        <!-- /DATOS NECESARIOS PARA LA CAPTURA DE SOLICITUD -->

                        <div class="step-content">
                            <!-- INFORMACIÓN DEL SOLICITANTE -->
                            <div class="step-pane active" data-step="1">
                                <!-- ENCABEZADO SOLICITUD -->
                                <div class="panel panel-default panel-solicitud">
                                    <div class="panel-body ">
                                        <div class="rows">
                                            <div class="col-md-5">{{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,'style': 'opacity:0.3;width: 65%;') }}</div>
                                            <div class="col-md-7  pull-right">
                                                <h3 class="text-right"> <b>SOLICITUD PARA EL EJERCICIO DE LOS DERECHOS “ARCO”  <br>
                                                        (Acceso, Rectificación Cancelación y Oposición)</b></h3>
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
                                <div class="rows">
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title panel-center">SOBRE EL AVISO DE PRIVACIDAD</h3>
                                            </div>
                                            <div class="panel-body">
                                                <b> La Unidad de Transparencia del Poder Ejecutivo del Estado de Querétaro es el organismo responsable del
                                                    tratamiento de los datos que nos proporcione, mismos que serán utilizados para efectuar el trámite de su
                                                    solicitud para el ejercicio de los derechos ARCO. Consulte nuestro aviso de privacidad en http://bit.ly/2zqyiGf o
                                                    en la oficina de atención de la Unidad.
                                                </b>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title panel-center">DATOS DEL TITULAR</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-row">
                                                    <label class="col-md-2 control-label">Titular de los datos personales:</label>
                                                    <div class="form-group col-md-3">
                                                        <label for="txtApellidoPT" class="text-muted"> Apellido Paterno: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="txtApellidoPT" id="txtApellidoPT" placeholder="Apellido Paterno" data-fv-notempty="true">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="txtApellidoMT" class="text-muted"> Apellido Materno: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="txtApellidoMT" id="txtApellidoMT" placeholder="Apellido Materno" data-fv-notempty="true">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="txtNombreT" class="text-muted"> Nombres(s): <span class="text-red">*</span></label>
                                                        <input  type="text" class="form-control"  name="txtNombreT" id="txtNombreT" placeholder="Nombre(s)" data-fv-notempty="true">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-3 col-md-offset-2">
                                                        <label for="txtFechaNacimiento" class="text-muted"> Fecha de nacimiento: <span class="text-red">*</span></label>
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="hidden" class="form-control" name="txtFecha" id="txtFecha" value="{{ fecha_nacimiento }}"/>
                                                            <input class="form-control pull-right" id="txtFechaNacimiento" name="txtFechaNacimiento" type="text" data-fv-notempty="true"   data-fv-date-format="YYYY/MM/DD" data-fv-date-message="The value is not a valid date">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="col-md-2 text-muted" style="padding-top: 10px;"> Vive:<span class="text-red">*</span></label>
                                                        <label class="col-md-2" style="padding-top: 10px;"><input type="radio" name="grupo-vive" value="SI" class="radio-vive" checked> Si</label>
                                                        <label class="col-md-3" style="padding-top: 10px;"><input type="radio" name="grupo-vive" value="NO" class="radio-vive"> No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title panel-center">ACREDITACIÓN DE LA IDENTIDAD DEL TITULAR <span class="text-yellow"> *</span> </h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <label class="col-md-2">
                                                        <input type="radio" name="checkbox-titular" value="radio-mayor" class="radio-acreditacion" checked> Si es mayor de edad
                                                    </label>
                                                    <div class="col-md-10 radio-mayor"></div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-md-2 checkbox-edad">
                                                        <input type="radio" name="checkbox-titular" value="radio-menor" class="radio-acreditacion"> Si es menor de edad
                                                    </label>
                                                    <div class="col-md-10 radio-menor"></div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-md-2 checkbox-edad">
                                                        <input type="radio" name="checkbox-titular" value="radio-fallecido" class="radio-acreditacion fallecido"> Si es fallecido
                                                    </label>
                                                    <div class="col-md-10 radio-fallecido"></div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-md-2 checkbox-edad">
                                                        <input type="radio" name="checkbox-titular" value="radio-otro" class="radio-acreditacion">Otro (sólo validado por la UTPE)
                                                    </label>
                                                    <div class="col-md-4 radio-otro">
                                                        <input id="txtOtro" name="txtOtro" class="form-control" placeholder="Escribe el nombre del documento" type="text" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title panel-center">DATOS DEL REPRESENTANTE, TUTOR, INTERESADO <span>(si aplica)</span></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-row">
                                                    <label class="col-md-2 text-right">Representante:</label>
                                                    <div class="form-group col-md-3">
                                                        <label for="txtApellidoPR" class="text-muted">Apellido paterno:</label>
                                                        <input type="text"class="form-control" id="txtApellidoPR" name="txtApellidoPR" placeholder="Apellido paterno">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="txtApellidoMR" class="text-muted"> Apellido Materno:</label>
                                                        <input type="text" class="form-control" id="txtApellidoMR" name="txtApellidoMR" placeholder=" Apellido Materno">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="txtNombreR" class="text-muted"> Nombre(s):</label>
                                                        <input  type="text" class="form-control" id="txtNombreR" name="txtNombreR" placeholder="Nombre(s)">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <label class="col-md-2 text-right">Se acredita como:</label>
                                                    <div class="col-md-10">
                                                        <div class="col-md-2">
                                                            <label class="text-muted">
                                                                <input type="checkbox" class="minimal" name="checkRepresentante[]" value="Representante"> Representante
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="text-muted">
                                                                <input type="checkbox" class="minimal fallecido" name="checkRepresentante[]" value="Interesado"> Interesado por fallecimiento del titular
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="text-muted">
                                                                <input type="checkbox" class="minimal" name="checkRepresentante[]" value="Padre o Madre"> Padre/Madre
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="text-muted">
                                                                <input type="checkbox" class="minimal" name="checkRepresentante[]" value="Tutor"> Tutor
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title panel-center">ACREDITACIÓN DE LA IDENTIDAD DEL REPRESENTANTE O TUTOR <span>(si aplica)</span></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="form-row">
                                                        <label class="col-md-3">Persona física. Representante, persona que ejerce la patria potestad, tutor, interesado</label>
                                                        <div class="col-md-9 checkbox-persona" style="padding-top: 20px;"></div>
                                                    </div>
                                                    <div class="form-row">
                                                        <label class="col-md-4">Acreditación como representante:</label>
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <label class=" col-md-2 text-muted text-right"> - Persona Física</label>
                                                            <div class="col-md-10 checkbox-fisica"></div>
                                                        </div>
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <label class="col-md-2 text-muted text-right"> - Persona Moral</label>
                                                            <div class="col-md-10 checkbox-moral"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <label class="col-md-4">Persona que ejerce la patria potestad o tutor:</label>
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <label class=" col-md-2 text-muted text-right"> - Padre/Madre</label>
                                                            <div class="col-md-10 checkbox-padres"></div>
                                                        </div>
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <label class="col-md-2 text-muted text-right"> - Tutor</label>
                                                            <div class="col-md-10 checkbox-tutor"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <label class="col-md-3">Persona interesada a causa del fallecimiento del titular:</label>
                                                        <div class="col-md-9 checkbox-tutor-fallecido"></div>
                                                    </div>
                                                </div>
                                                <p class="text-right text-muted"><span class="text-yellow">*</span> Presentar copia simple y original para cotejar.</p>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE O REPRESENTANTE LEGAL -
                                                    PARA NOTIFICACIONES</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <label class="col-md-2 radio-notificaciones control-label text-right">
                                                        <input type="checkbox" class="minimal" value="checkbox-correo"> Correo electrónico
                                                    </label>
                                                    <div class="col-md-4 checkbox-correo area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Correo electrónico:</label>
                                                            <input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Dirección de correo electrónico válida " type="email" data-fv-notempty="true" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <label class="col-md-2 radio-notificaciones control-label text-right">
                                                        <input type="checkbox" class="minimal" value="checkbox-domicilio"> Domicilio <span class="text-yellow">**</span>
                                                    </label>
                                                    <div  class="col-md-5 checkbox-domicilio area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Calle, número exterior y número interior:</label>
                                                            <input class="form-control" id="txtDireccion" name="txtDireccion" placeholder="Calle, número exterior y número interior" type="text" data-fv-notempty="true">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 checkbox-domicilio area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Colonia o fraccionamiento:</label>
                                                            <input class="form-control" id="txtColonia" name="txtColonia" placeholder="Colonia o fraccionamiento" type="text" data-fv-notempty="true" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2 checkbox-domicilio area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Entidad Federativa / País:</label>
                                                            <select class="form-control" style="width:100%" id="slEstado" name="slEstado" lang="es" data-fv-notempty="true" ></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 checkbox-domicilio area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Delegación o municipio:</label>
                                                            <select class="form-control" style="width:100%" id="slMunicipio" name="slMunicipio" lang="es" data-fv-notempty="true"></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 checkbox-domicilio area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Código Postal:</label>
                                                            <input class="form-control" id="txtCodigoP" name="txtCodigoP" placeholder="C.P " type="text" data-fv-notempty="true" data-mask="0#" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2 checkbox-domicilio area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Entre las calles:</label>
                                                            <input class="form-control" id="txtEntreCalles" name="txtEntreCalles" type="text" data-fv-notempty="true" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 checkbox-domicilio area-notificacion">
                                                        <div class="form-group">
                                                            <label class="text-muted"> Otras referencias para la ubicación del domicilio:</label>
                                                            <input class="form-control" id="txtOtraReferencia" name="txtOtraReferencia" type="text" data-fv-notempty="true" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-right text-muted"><b><span class="text-yellow">** </span></b>
                                                    Todas las notificaciones fuera del Municipio de Querétaro y zona conurbada se efectuarán por correo certificado.</p>
                                                <hr>
                                                <div class="row">
                                                    <label class="col-md-2 radio-notificaciones control-label text-right">
                                                        <input type="checkbox" class="minimal" value="checkbox-telefono"> Telefóno
                                                    </label>
                                                    <div class="checkbox-telefono area-notificacion">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="text-muted">Telefóno Fijo:</label>
                                                                <input class="form-control" id="txtTelefonoFijo" name="txtTelefonoFijo" placeholder="Telefóno Fijo" type="text" data-mask="0#">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="text-muted">Telefóno Celular:</label>
                                                                <input class="form-control" id="txtTelefonoCel" name="txtTelefonoCel" placeholder="Telefóno Celular" type="text" data-mask="(00) 0000-0000">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-right text-muted">Únicamente para informarle sobre la existencia de notificación,
                                                    misma que deberá recoger en la Unidad. <br>De no contar con otro dato
                                                    para la debida notificación y/o si no es posible localizarlo por
                                                    este medio, se efectuará la notificación en Estrados de la Unidad.</p>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <b>Notificación en ESTRADOS  de la Unidad de Transparencia del Poder
                                                    Ejecutivo del Estado de Querétaro. </b>
                                                Al no proporcionar datos
                                                que permitan la notificación a través de los medios antes señalados, esta Unidad notificará en ESTRADOS a más tardar el día 20 y hasta
                                                el día hábil número 50, a partir de la recepción de la presente
                                                solicitud. Debe considerar además que, de ser necesaria la prevención
                                                (numeral 4 del apartado de Información General), se publicaría
                                                la notificación correspondiente, a más tardar el 5º día hábil,
                                                contado
                                                a partir de la recepci
                                                ón de su solicitud.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Información de la Solicitud -->
                            <div class="step-pane" data-step="2">
                                <!-- ENCABEZADO SOLICITUD -->
                                <div class="panel panel-default panel-solicitud">
                                    <div class="panel-body ">
                                        <div class="rows">
                                            <div class="col-md-5">
                                                {{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro','style': 'opacity:0.3;width: 65%;') }}
                                            </div>
                                            <div class="col-md-7  pull-right">
                                                <h3 class="text-right"> <b>SOLICITUD PARA EL EJERCICIO DE LOS DERECHOS “ARCO”  <br>
                                                        (Acceso, Rectificación Cancelación y Oposición)</b></h3>
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
                                                                <td><b>{{ fecha_i }}</b></td>
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
                                                <textarea class="form-control" rows="4" id="txtAntecedentes" name="txtAntecedentes" placeholder="Redactar los antecedentes de la solicitud.">{{ antecedente }}</textarea>
                                                <label><input type="checkbox" class="minimal" value="checkbox-antecedentes" checked> Mostrar antecedente a las dependencias</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-3 control-label"><input type="checkbox" class="checkbox" value="checkbox-preguntas"> Dividir en varias preguntas</label>
                                            <div class="col-md-10 col-md-offset-1 checkbox-agrupar">
                                                <div class="form-group">
                                                    <label>¿Cuál es la pregunta del solicitante?<span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" id="txtPeticion" name="txtPeticion" data-fv-notempty="true"
                                                              placeholder="Descripción de las observaciones que podran ayudar al ser turnada la pregunta.">{{ antecedente }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Observaciones de la pregunta descrita anteriormente para ayudar con el turnado</label>
                                                    <textarea class="form-control" rows="4" id="txtObservaciones" name="txtObservaciones" placeholder="Descripción de las observaciones que podran ayudar al ser turnada la pregunta."></textarea>
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
                                                        <th data-field="NUMROW" data-align="center" data-formatter="solicitudes.numRowFormatter"  data-width="100">NO. PREGUNTA</th>
                                                        <th data-field="DESCRIPCION" data-sortable="false">DESCRIPCIÓN</th>
                                                        <th data-field="OBSERVACIONES" data-sortable="false">OBSERVACIONES</th>
                                                        <th data-sortable="false" data-align="center" data-width="100" data-formatter="solicitudes.actionFormatter">ACCIONES</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dependencia -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">NOMBRE DE LA DEPENDENCIA Y ÁREA RESPONSABLE DE TRATAR LOS DATOS PERSONALES</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="text-muted">Búsqueda de las dependencias a las cuales turnar la solicitud:  <span class="text-yellow">*</span></h4>
                                                <select multiple="multiple" name="slDependencias" id="slDependencias" lang="es"></select></br>
                                                <h4 class="text-muted">Agregar comentario:</h4>
                                                <textarea class="form-control" rows="3" id="txtComentario" name="txtComentario"></textarea><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Derechos ARCO -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DERECHO QUE DESEA EJERCER</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-2 radio-arco">
                                                    <input type="radio" name="radio-arco" id="radio-arco" value="1" class="radio-arco" checked>
                                                    ACCESO
                                                    <span class="checkmark"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <p>Ejercicio del derecho de ACCESO sobre sus datos de carácter personal</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-2 radio-arco">
                                                    <input type="radio" name="radio-arco" value="2" class="radio-arco">
                                                    RECTIFICACIÓN
                                                    <span class="checkmark"></span>
                                                </label>
                                                <div class="col-md-10">
                                                    <p>Ejercicio del derecho de RECTIFICACIÓN de los datos de carácter personal (en la siguiente sección, deberá especificar las modificaciones que se
                                                        solicitan a los datos personales, así como aportar los
                                                        documentos que sustenten la solicitud)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-2 radio-arco">
                                                    <input type="radio" name="radio-arco" value="3" class="radio-arco">
                                                    CANCELACIÓN
                                                </label>
                                                <div class="col-md-10">
                                                    <p>Ejercicio del derecho de CANCELACIÓN de los datos de carácter personal (en la sección siguiente, deberá
                                                        señalar las causas que motiven la supresión de los datos personales)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-2 radio-arco">
                                                    <input type="radio" name="radio-arco" value="4" class="radio-arco">
                                                    OPOSICIÓN
                                                </label>
                                                <div class="col-md-10">
                                                    <p>Ejercicio del derecho de OPOSICIÓN de los datos de carácter personal (en la sección siguiente deberá
                                                        indicar las causas del cese y el daño o perjuicio que le causaría si persisten sus datos personales)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Información del Catálogo -->
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
                                                <select class="form-control" style="width:100%" id="slTema" name="slTema" lang="es"></select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="slSubtema" class="text-muted text-right">Subtema: <span class="text-red">*</span></label>
                                                <select class="form-control" style="width:100%" id="slSubtema" name="slSubtema" lang="es"></select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="slTitulo" class=" text-muted text-right">Título:</label>
                                                <select class="form-control" style="width:100%" id="slTitulo" name="slTitulo" lang="es"></select>
                                            </div>
                                        </div>
                                        <br>
                                        <p class="text-right"><span class="text-yellow">*</span> Agregar la información necesaria sobre la relación del tema con la solicitud, asignando un catálogo a la solicitud.</p>
                                    </div>
                                </div>
                                <!-- Medios de respuesta -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">INDIQUE CÓMO DESEA RECIBIR LA INFORMACIÓN (Ver numeral 9 y 10 de la sección de Información General) </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <p>Para proceder a pagar es necesario que seleccione uno de los Trámites del siguiente listado y agregue el concepto.
                                                    Si necesita ayuda, llámenos al teléfono (442) 211 7070  o  al 01-800 237 2233 de lunes a viernes de 08:00 a 20:00 hrs. y sábados de 09:00 a 14:00 hrs.</p>
                                                <div class="form-group col-md-3">
                                                    <label for="slMedioR" class=" text-muted text-right">Medio de respuesta: <span class="text-red">*</span></label>
                                                    <select class="form-control" style="width:100%" id="slMedioR" name="slMedioR" lang="es"></select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-muted text-right">Cantidad: <span class="text-red">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-cart-plus"></i></div>
                                                        <input class="form-control" id="txtCantidad" name="txtCantidad" type="number" value="1">
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
                                                        <th data-field="IMPORTE" data-sortable="false" data-formatter="general.formatoMoneda"  data-align="center" data-footer-formatter="solicitudes.totalFormatter">IMPORTE</th>
                                                        <th data-sortable="false" data-align="center" data-formatter="solicitudes.mediosFormatter" data-width="100">ACCIONES</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Documentos Anexos -->
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
                                                       data-search="true"
                                                       data-show-toggle="true"
                                                       data-striped="true"
                                                       data-resizable="true"
                                                       data-sort-name="ID_DOCUMENTO"
                                                       data-sort-order="asc"
                                                       data-show-refresh="true"
                                                       data-fixed-columns="false"
                                                       data-fixed-number="0"
                                                       data-advanced-search="false"
                                                       data-search-on-enter-key="false"
                                                       data-show-pagination-switch="false"
                                                       data-pagination-v-align="both"
                                                       data-smart-display="true"
                                                       data-cache="false"
                                                       class="table table-bordered table-hover table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="NUMROW" data-align="center" data-sortable="true" data-formatter="solicitudes.numRowFormatter"  data-width="100">NO. DOCUMENTO</th>
                                                        <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                                                        <th data-field="EXTENSION" data-sortable="true">EXTENSIÓN</th>
                                                        <th data-sortable="false" data-align="center" data-width="200" data-formatter="solicitudes.documentoActionFormatter">ACCIONES</th>
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
    {{ javascript_include('js/jquery/multi.min.js') }}
    {{ javascript_include('js/extra/iCheck/icheck.min.js') }}
    {{ javascript_include('js/views/solicitudes/registro-arco.js') }}
{% endblock %}
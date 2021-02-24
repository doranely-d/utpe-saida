{# solicitudesSai/perfil.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/jquery/multi.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <section class="content-header">
            <h1>
                <span>Perfil de Solicitud</span>
                <small>Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Perfil de Solicitud</li>
            </ol>
        </section>

        <section class="content">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            {{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,'style': 'opacity:0.3;width: 80%;') }}
                        </div>
                        <div class="col-md-7 text-center">
                           <h3> <b>
                               {% if solicitudes.TIPO === "SAI" %}
                                   SOLICITUD DE ACCESO A LA INFORMACIÓN PÚBLICA DEL PODER EJECUTIVO
                               {% else%}
                                   SOLICITUD PARA EL EJERCICIO DE LOS DERECHOS “ARCO” <br>(Acceso, Rectificación Cancelación y Oposición)
                               {% endif%}
                               </b>
                           </h3>
                        </div>
                        <div class="col-md-3 pull-right">
                            <input type="hidden" class="form-control" name="txtIdSolicitante" id="txtIdSolicitante" value="{{ idSolicitante }}"/>
                            <table class="table table-bordered-title text-center" style="margin: 0px;">
                                <thead >
                                <tr>
                                    <th>FOLIO</th>
                                    <th>FECHA REGISTRO</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><b>{{ solicitud.FOLIO }}</b></td>
                                    <td><b>{{ solicitud.FECHA_I }}</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    {% if solicitudes.TIPO === "ARCO" %}
                        <li class="active tab-blue"><a href="#prof_contacto_arco" data-toggle="tab" aria-expanded="false"> Información de Solicitante</a></li>
                    {% endif  %}
                    {% if solicitudes.TIPO === "SAI" %}
                        <li class="active tab-blue"><a href="#prof_contacto" data-toggle="tab" aria-expanded="false"> Información de Solicitante</a></li>
                    {% endif  %}
                    <li class="tab-blue"><a href="#prof_preguntas" data-toggle="tab" aria-expanded="true">Información de la Solicitud</a></li>
                    {% if solicitudes.TIPO === "ARCO" %}
                        <li class="tab-blue"><a href="#prof_derechos" data-toggle="tab" aria-expanded="true">Información Derechos ARCO</a></li>
                    {% endif  %}
                    <li class="tab-blue"><a href="#prof_catalogo" data-toggle="tab" aria-expanded="false">Clasificación de la Solicitud</a></li>
                    <li class="tab-blue"><a href="#prof_medio" data-toggle="tab" aria-expanded="false">Medios de Respuesta</a></li>
                    <li class="tab-blue"><a href="#prof_comentarios" data-toggle="tab" aria-expanded="true"> Comentarios</a></li>
                    <li class="tab-blue"><a href="#prof_historial" data-toggle="tab" aria-expanded="true"> Historial</a></li>
                    <li class="tab-blue"><a href="#prof_documentos" data-toggle="tab" aria-expanded="true"> Documentos Anexos</a></li>
                    <li class="tab-blue"><a href="#prof_prevencion" data-toggle="tab" aria-expanded="true"> Documentos Prevención</a></li>
                </ul>
                <div class="tab-content">
                    {% if solicitudes.TIPO === "ARCO" %}
                    <!-- SOLICITANTE ARCO-->
                    <div class="tab-pane active" id="prof_contacto_arco">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DATOS DEL TITULAR</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-row">
                                    <label class="col-md-2 control-label">Titular de los datos personales:</label>
                                    <div class="form-group col-md-3">
                                        <label for="txtApellidoPT" class="text-muted"> Apellido Paterno:</label>
                                        <input type="hidden" class="form-control" name="txtIdSolicitud" id="txtIdSolicitud" value="{{id_solicitud }}"/>
                                        <input type="hidden" class="form-control" name="txtIdSolicitante" id="txtIdSolicitante" value="{{ solicitante.id_solicitante }}"/>
                                        <input type="text" class="form-control" name="txtApellidoP" id="txtApellidoP" disabled value="{{ titular.apellido_paterno }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="txtApellidoMT" class="text-muted"> Apellido Materno:</label>
                                        <input type="text" class="form-control" name="txtApellidoM" id="txtApellidoM" disabled {{ titular.apellido_materno }}>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="txtNombreT" class="text-muted"> Nombres(s):</label>
                                        <input  type="text" class="form-control"  name="txtNombreT" id="txtNombreT"  {{ titular.nombre }} disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3 col-md-offset-2">
                                        <label for="txtFechaNacimiento" class="text-muted"> Fecha de nacimiento:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" name="txtFecha" id="txtFecha" value="{{ titular.fecha_nacimiento }}" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-2 text-muted" style="padding-top: 10px;"> Vive:</label>
                                        <input type="text" class="form-control" name="txtFecha" id="txtFecha" value="{{ titular.fecha_nacimiento }}" disabled/>
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
                                Autorizo a la Unidad de Transparencia del Poder Ejecutivo del Estado de Querétaro,
                                para el uso de los datos que a continuación proporciono, para recibir notificaciones
                                derivadas del trámite de la presente solicitud.
                                <hr>

                                <div class="form-group row">
                                    <label class="col-md-2 radio-notificaciones control-label"> Correo electrónico
                                    </label>
                                    <div class="col-sm-4 area-4 area-notificacion">
                                        <label class="text-muted"> Correo electrónico:</label>
                                        <input class="form-control" name="txtCorreo" id="txtCorreo" value="{{ solicitante.CORREO }}" type="text" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 radio-notificaciones control-label">
                                        Domicilio:
                                    </label>
                                    <div class="col-md-5 area-5 area-notificacion">
                                        <label class="text-muted"> Calle, número exterior y número interior:</label>
                                        <input class="form-control" id="txtCalle" name="txtCalle" value="{{solicitante.DOMICILIO }}"  type="text" disabled>
                                    </div>
                                    <div class="col-md-5 area-5 area-notificacion">
                                        <label class="text-muted"> Colonia o fraccionamiento:</label>
                                        <input class="form-control" id="txtColonia" name="txtColonia" value="{{ solicitante.COLONIA }}"  type="text" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 col-md-offset-2  area-5 area-notificacion">
                                        <label class="text-muted"> Entidad Federativa / País:</label>
                                        <input class="form-control" id="txtEstado" name="txtEstado" value="{{ solicitante.ESTADO }}"  type="text" disabled>
                                    </div>
                                    <div class="col-md-4 area-5 area-notificacion">
                                        <label class="text-muted"> Delegación o municipio:</label>
                                        <input class="form-control" id="txtMunicipio" name="txtMunicipio" value="{{ solicitante.MUNICIPIO }}"  type="text" disabled>
                                    </div>
                                    <div class="col-md-2 area-5 area-notificacion">
                                        <label class="text-muted"> Código Postal:</label>
                                        <input class="form-control" id="txtCodigoP" name="txtCodigoP" value="{{ solicitante.CODIGO_POSTAL }}" type="text" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 col-md-offset-2 area-5 area-notificacion">
                                        <label class="text-muted"> Entre las calles:</label>
                                        <input class="form-control" id="txtDireccion" name="txtDireccion" value="{{ solicitante.ENTRE_CALLES }}"  type="text" disabled>
                                    </div>
                                    <div class="col-md-4 area-5 area-notificacion">
                                        <label class="text-muted"> Otras referencias para la ubicación del domicilio:</label>
                                        <input class="form-control" id="txtColonia" name="txtColonia" value="{{ solicitante.OTRA_REFERENCIA }}" type="text" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 radio-notificaciones control-label">Telefónos:
                                    </label>
                                    <div class="col-md-3">
                                        <label class="text-muted">Teléfono fijo:</label>
                                        <input id="txtTelFijo" name="txtTelFijo" class="form-control" value="{{ solicitante.TELEFONO_FIJO }}" type="text" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted">Teléfono celular:</label>
                                        <input class="form-control" name="txtTelCel" id="txtTelCel" value="{{ solicitante.TELEFONO_CELULAR }}" type="text" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 radio-notificaciones control-label">Persona autorizada:
                                    </label>
                                    <div class="col-md-3">
                                        <label class="text-muted">Apellido paterno:</label>
                                        <input class="form-control" id="txtApellidoPPA" name="txtApellidoPPA" type="text" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted"> Apellido Materno:</label>
                                        <input class="form-control" id="txtApellidoMPA" name="txtApellidoMPA" type="text" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted"> Nombre(s):</label>
                                        <input class="form-control" id="txtNombrePA" name="txtNombrePA" type="text" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {% endif  %}
                    {% if solicitudes.TIPO === "SAI" %}
                    <!-- SOLICITANTE -->
                    <div class="tab-pane active" id="prof_contacto">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE Y/O REPRESENTANTE LEGAL</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group row">
                                    <label class="col-md-2 datos-solicitante">Persona física:</label>
                                    <div class="col-md-4">
                                        <label class="text-muted">Nombre(s):</label>
                                        <input type="hidden" class="form-control" name="txtIdSolicitud" id="txtIdSolicitud" value="{{id_solicitud }}"/>
                                        <input type="hidden" class="form-control" name="txtIdSolicitante" id="txtIdSolicitante" value="{{ solicitante.id_solicitante }}"/>
                                        <input id="txtNombre" name="txtNombre" class="form-control" value="{{ solicitante.NOMBRE }}" type="text" disabled>

                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted">Apellido Paterno:</label>
                                        <input class="form-control" name="txtApellidoP" id="txtApellidoP" value="{{ solicitante.APELLIDO_PATERNO }}" type="text" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted">Apellido Materno:</label>
                                        <input class="form-control" name="txtApellidoM" id="txtApellidoM" value="{{ solicitante.APELLIDO_MATERNO }}" type="text" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 datos-solicitante">Persona Moral:</label>
                                        <div class="col-md-4">
                                            <label class="text-muted">Razón Social:</label>
                                            <input id="txtTelFijo" name="txtTelFijo" class="form-control" value="{{ solicitante.RAZON_SOCIAL }}" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 datos-solicitante">Representante legal:</label>
                                    <div class="col-md-4">
                                        <label class="text-muted">Nombre(s):</label>
                                        <input id="txtNombreR" name="txtNombreR" class="form-control" value="{{ solicitudes.NOMBRE_REPRESENTANTE }}" type="text" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted">Apellido Paterno:</label>
                                        <input class="form-control" name="txtApellidoPR" id="txtApellidoPR" value="{{ solicitudes.APELLIDO_P_REPRESENTANTE }}" type="text" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted">Apellido Materno:</label>
                                        <input class="form-control" name="txtApellidoMR" id="txtApellidoMR" value="{{ solicitudes.APELLIDO_M_REPRESENTANTE }}" type="text" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-md-2 datos-solicitante">Seudónimo:</label>
                                    <div class="col-md-4">
                                        <label class="text-muted">Seudónimo:</label>
                                        <input class="form-control" id="txtSeudonimo" name="txtSeudonimo" value="{{ solicitante.SEUDONIMO }}"type="text" disabled>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE O REPRESENTANTE LEGAL -
                                        PARA NOTIFICACIONES</h3>
                                </div>
                                <div class="panel-body">
                                    Autorizo a la Unidad de Transparencia del Poder Ejecutivo del Estado de Querétaro,
                                    para el uso de los datos que a continuación proporciono, para recibir notificaciones
                                    derivadas del trámite de la presente solicitud.
                                    <hr>

                                    <div class="form-group row">
                                        <label class="col-md-2 radio-notificaciones control-label"> Correo electrónico
                                        </label>
                                        <div class="col-sm-4 area-4 area-notificacion">
                                            <label class="text-muted"> Correo electrónico:</label>
                                            <input class="form-control" name="txtCorreo" id="txtCorreo" value="{{ solicitante.CORREO }}" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 radio-notificaciones control-label">
                                            Domicilio:
                                        </label>
                                        <div class="col-md-5 area-5 area-notificacion">
                                            <label class="text-muted"> Calle, número exterior y número interior:</label>
                                            <input class="form-control" id="txtCalle" name="txtCalle" value="{{solicitante.DOMICILIO }}"  type="text" disabled>
                                        </div>
                                        <div class="col-md-5 area-5 area-notificacion">
                                            <label class="text-muted"> Colonia o fraccionamiento:</label>
                                            <input class="form-control" id="txtColonia" name="txtColonia" value="{{ solicitante.COLONIA }}"  type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 col-md-offset-2  area-5 area-notificacion">
                                            <label class="text-muted"> Entidad Federativa / País:</label>
                                            <input class="form-control" id="txtEstado" name="txtEstado" value="{{ solicitante.ESTADO }}"  type="text" disabled>
                                        </div>
                                        <div class="col-md-4 area-5 area-notificacion">
                                            <label class="text-muted"> Delegación o municipio:</label>
                                            <input class="form-control" id="txtMunicipio" name="txtMunicipio" value="{{ solicitante.MUNICIPIO }}"  type="text" disabled>
                                        </div>
                                        <div class="col-md-2 area-5 area-notificacion">
                                            <label class="text-muted"> Código Postal:</label>
                                            <input class="form-control" id="txtCodigoP" name="txtCodigoP" value="{{ solicitante.CODIGO_POSTAL }}" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 col-md-offset-2 area-5 area-notificacion">
                                            <label class="text-muted"> Entre las calles:</label>
                                            <input class="form-control" id="txtDireccion" name="txtDireccion" value="{{ solicitante.ENTRE_CALLES }}"  type="text" disabled>
                                        </div>
                                        <div class="col-md-4 area-5 area-notificacion">
                                            <label class="text-muted"> Otras referencias para la ubicación del domicilio:</label>
                                            <input class="form-control" id="txtColonia" name="txtColonia" value="{{ solicitante.OTRA_REFERENCIA }}" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 radio-notificaciones control-label">Telefónos:
                                        </label>
                                        <div class="col-md-3">
                                            <label class="text-muted">Teléfono fijo:</label>
                                            <input id="txtTelFijo" name="txtTelFijo" class="form-control" value="{{ solicitante.TELEFONO_FIJO }}" type="text" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-muted">Teléfono celular:</label>
                                            <input class="form-control" name="txtTelCel" id="txtTelCel" value="{{ solicitante.TELEFONO_CELULAR }}" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 radio-notificaciones control-label">Persona autorizada:
                                        </label>
                                        <div class="col-md-3">
                                            <label class="text-muted">Apellido paterno:</label>
                                            <input class="form-control" id="txtApellidoPPA" name="txtApellidoPPA" type="text" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-muted"> Apellido Materno:</label>
                                            <input class="form-control" id="txtApellidoMPA" name="txtApellidoMPA" type="text" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-muted"> Nombre(s):</label>
                                            <input class="form-control" id="txtNombrePA" name="txtNombrePA" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    {% endif  %}
                    <!-- CATALOGO -->
                    <div class="tab-pane" id="prof_catalogo">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DATOS QUE FACILITEN LA BÚSQUEDA Y EVENTUAL LOCALIZACIÓN DE LA INFORMACIÓN</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <label class="col-md-2 text-right" style="padding-top: 20px;">
                                        Catálogo de temas
                                    </label>
                                    <div class="form-group col-md-3">
                                        <label class="text-muted datos-solicitante">Tema:</label>
                                        <input type="text" class="form-control" value="{{ tema }}" disabled/>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-muted datos-solicitante">Subtema:</label>
                                        <input type="text" class="form-control"  value="{{ subtema }}" disabled/>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class=" text-muted datos-solicitante">Título:</label>
                                        <input type="text" class="form-control"  value="{{ titulo }}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PREGUNTAS -->
                    <div class="tab-pane " id="prof_preguntas">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DESCRIPCIÓN DE LA INFORMACIÓN SOLICITADA </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-default collapsed-box">
                                            <div class="box-header with-border">
                                                <div class="pull-left">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i><h3 class="box-title"> &nbsp;Mostrar el antecedente de la solicitud</h3></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body" style="">
                                                <label>Antecedentes de la solicitud:</label>
                                                <textarea class="form-control" rows="6" id="txtAntecedentes" name="txtAntecedentes">{{ solicitud.ANTECEDENTE }}</textarea>
                                            </div><!-- /.box-body -->
                                        </div>
                                    </div>
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
                                                <th data-field="NUMROW" data-align="center" data-formatter="solicitud.numRowFormatter"  data-width="100">NO. PREGUNTA</th>
                                                <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCIÓN</th>
                                                <th data-field="OBSERVACIONES">OBSERVACIONES</th>
                                                <th data-field="FECHA_I" data-align="center" data-width="100">FECHA REGISTRO</th>
                                                <th data-sortable="false" data-align="center" data-width="100" data-formatter="solicitud.accionesFormatter">ACCIONES</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MEDIO DE RESPUESTA -->
                    <div class="tab-pane " id="prof_medio">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DESCRIPCIÓN DEL MEDIO DE RESPUESTA </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblMediosRespuesta"
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
                                            data-sort-name="ID_MEDIO_RESPUESTA"
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
                                                    <th data-field="MEDIO" data-sortable="true">MEDIO</th>
                                                    <th data-field="CANTIDAD" data-sortable="false">CANTIDAD</th>
                                                    <th data-field="COSTO" data-sortable="false"  data-formatter="general.formatoMoneda"  data-align="center">COSTO</th>
                                                    <th data-field="TOTAL" data-sortable="false"  data-formatter="general.formatoMoneda"  data-footer-formatter="general.totalFormatter">TOTAL</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- COMENTARIOS -->
                    <div class="tab-pane " id="prof_comentarios">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">HISTORIAL DE COMENTARIOS DE LA SOLICITUD </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblComentarios"
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
                                               data-sort-name="ID"
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
                                                    <th data-field="FECHA_I" data-align="center"  data-width="100" data-sortable="true">FECHA REGISTRO</th>
                                                    <th data-field="USUARIO" data-align="center" data-width="100" data-sortable="true">USUARIO</th>
                                                    <th data-field="COMENTARIO" data-sortable="true">COMENTARIO</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- HISTORIAL -->
                    <div class="tab-pane " id="prof_historial">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">HISTORIAL DE ACCIONES DE LA SOLICITUD </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblHistorial"
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
                                               data-sort-name="ID"
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
                                                <th data-field="FECHA_I" data-align="center" data-sortable="true">FECHA REGISTRO</th>
                                                <th data-field="TRANSACCION" data-sortable="true">TRANSACCION</th>
                                                <th data-field="ETAPA" data-align="center" data-sortable="true">ETAPA</th>
                                                <th data-field="ESTADO" data-align="center" data-sortable="true">ESTADO</th>
                                                <th data-field="N_ETAPA" data-align="center" data-sortable="true">PRÓXIMO ETAPA</th>
                                                <th data-field="N_ESTADO" data-align="center" data-sortable="true">PRÓXIMO ESTADO</th>
                                                <th data-field="USUARIO" data-align="center" data-width="100" data-sortable="true">USUARIO</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DOCUMENTOS ANEXOS-->
                    <div class="tab-pane " id="prof_documentos">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DOCUMENTOS ANEXOS</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                            <button id="btnAgregarDocumento" class="btn btn-success" data-toggle="tooltip"
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
                                               data-show-toggle="false"
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
                                               data-pagination-h-align="left"
                                               data-smart-display="true"
                                               data-cache="false"
                                               class="table table-bordered table-hover table-condensed"
                                               style="display: none;">
                                            <thead>
                                            <tr>
                                                <th data-field="NUMROW" data-align="center" data-sortable="true" data-formatter="solicitud.numRowFormatter"  data-width="100">NO.</th>
                                                <th data-field="NOMBRE" data-sortable="true" data-formatter="solicitud.nombreDocFormatter">NOMBRE</th>
                                                <th data-sortable="false" data-align="center" data-width="200" data-formatter="solicitud.documentoFormatter">ACCIONES</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DOCUMENTOS  PREVENCION-->
                    <div class="tab-pane " id="prof_prevencion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DOCUMENTOS PREVENCIÓN</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblPrevencion"
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
                                               data-sort-name="ID_DOCUMENTO"
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
                                                    <th data-field="NUMROW" data-align="center" data-sortable="true" data-formatter="solicitud.numRowFormatter"  data-width="100">NO.</th>
                                                    <th data-field="NOMBRE" data-sortable="true" data-formatter="solicitud.nombreDocFormatter">NOMBRE</th>
                                                    <th data-sortable="false" data-align="center" data-width="200" data-formatter="solicitud.prevencionFormatter">ACCIONES</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DERECHOS ARCO -->
                    <div class="tab-pane " id="prof_derechos">
                        <div class="rows">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panel-center">NOMBRE DE LA DEPENDENCIA Y ÁREA RESPONSABLE DE TRATAR LOS DATOS PERSONALES </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 text-right" style="padding-top: 25px;">
                                                Dependencia a la cual solicitar la información <span class="text-yellow">*</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <select class="form-control" style="width:100%" id="slDependencia" name="slDependencia" data-fv-notempty="true" lang="es"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panel-center">DERECHO QUE DESEA EJERCER</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-2 radio-arco">
                                                <input type="radio" name="radio-arco" id="radio-arco" value="1" class="option-input radio" checked>
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
                                                <input type="radio" name="radio-arco" value="2" class="option-input radio">
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
                                                <input type="radio" name="radio-arco" value="3" class="option-input radio">
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
                                                <input type="radio" name="radio-arco" value="4" class="option-input radio">
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
                    </div>
                </div>
                </div>
            </div>
        </section>
    </div>
{% endblock %}

{% block footer %}
    {{ javascript_include('js/jquery/select2/select2.min.js') }}
    {{ javascript_include('js/jquery/select2/language/es.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-datetimepicker.min.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/bootstrap/fileinput/fileinput.js') }}
    {{ javascript_include('js/bootstrap/fileinput/locales/es.js') }}
    {{ javascript_include('js/jquery/mask/jquery.mask.js') }}
    {{ javascript_include('js/jquery/jquery.fileDownload.js') }}
    {{ javascript_include('js/jquery/multi.min.js') }}
    {{ javascript_include('js/views/solicitudes/perfil.js') }}
{% endblock %}

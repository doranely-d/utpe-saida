{# solicitudesSai/perfil.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/bootstrap/select2.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <section class="content-header">
            <h1>
                <span>Perfil del Solicitante</span>
                <small>Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Perfil del Solicitante</li>
            </ol>
        </section>

        <section class="content">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            {{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,'style': 'opacity:0.3;width: 35%;') }}
                        </div>
                        <div class="col-md-3 pull-right">
                            <input type="hidden" class="form-control" name="txtIdSolicitante" id="txtIdSolicitante" value="{{ idSolicitante }}"/>
                            <table class="table table-bordered-title text-center" style="margin: 0px;">
                                <thead >
                                    <tr>
                                        <th>ID SOLICITANTE</th>
                                        <th>FECHA REGISTRO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>{{ idSolicitante }}</b></td>
                                        <td><b>{{ solicitante.FECHA_I }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active tab-blue"><a href="#prof_contacto" data-toggle="tab" aria-expanded="false"> Información de Solicitante</a></li>
                    <li class="tab-blue"><a href="#prof_sai" data-toggle="tab" aria-expanded="true">Solicitudes SAI</a></li>
                    <li class="tab-blue"><a href="#prof_arco" data-toggle="tab" aria-expanded="true">Solicitudes ARCO</a></li>
                    <li class="tab-blue"><a href="#prof_rrevision" data-toggle="tab" aria-expanded="false">Recursos de Revisión</a></li>
                    <li class="tab-blue"><a href="#prof_comentarios" data-toggle="tab" aria-expanded="true">Listado de Comentarios</a></li>
                    <li class="tab-blue"><a href="#prof_historial" data-toggle="tab" aria-expanded="true">Historial</a></li>
                    <li class="pull-right header">
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger" id="btnEliminarSolicitante" data-toggle="tooltip" data-placement="bottom" title="Eliminar Solicitante"><i class="fa fa-trash fa-2x"></i></button>
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
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
                                            <input class="form-control" value="{{ solicitante.APELLIDO_P_PERSONA_A }}" type="text" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-muted"> Apellido Materno:</label>
                                            <input class="form-control" value="{{ solicitante.APELLIDO_M_PERSONA_A }}" type="text" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-muted"> Nombre(s):</label>
                                            <input class="form-control" value="{{ solicitante.NOMBRE_PERSONA_A }}" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- SOLICITUDES SAI -->
                    <div class="tab-pane" id="prof_sai">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">SOLICITUDES DE ACCESO A LA INFORMACIÓN PÚBLICA DEL PODER EJECUTIVO</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblSolicitudesSai"
                                               data-mobile-responsive="true"
                                               data-show-export="true"
                                               data-click-to-select="true"
                                               data-locale="es-MX"
                                               data-height="500"
                                               data-pagination="true"
                                               data-side-pagination="server"
                                               data-page-size="20"
                                               data-search="true"
                                               data-show-toggle="true"
                                               data-striped="true"
                                               data-resizable="true"
                                               data-sort-name="ID_SOLICITUD"
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
                                               class="table table-bordered table-hover table-condensed"
                                               style="display: none;">
                                            <thead>
                                            <tr>
                                                <th data-field="ID_SOLICITUD" data-sortable="false" data-visible="false" data-align="center" data-width="20">ID</th>
                                                <th data-field="FOLIO" data-sortable="false"  data-align="center" data-width="40">FOLIO</th>
                                                <th data-field="FOLIO_EXTERNO" data-sortable="false"  data-align="center" data-width="40">EXTERNO</th>
                                                <th data-field="TIPO"  data-align="center" data-width="100">TIPO DE SOLICITUD</th>
                                                <th data-field="MEDIO" data-sortable="false"  data-align="center" data-width="80">RECEPCIÓN</th>
                                                <th data-field="FECHA_RECEPCION" data-sortable="false" data-align="center" data-width="30">RECEPCIÓN</th>
                                                <th data-field="FECHA_PREVENCION" data-sortable="false"  data-align="center" data-width="30">PREVENCIÓN</th>
                                                <th data-field="FECHA_TURNADO" data-sortable="false"  data-align="center" data-width="30">TURNADO</th>
                                                <th data-field="ETAPA" data-sortable="false"  data-align="center" data-width="50" data-formatter="solicitantePerfil.etapaFormatter">ETAPA ACTUAL</th>
                                                <th data-field="ESTADO" data-sortable="false" data-align="center" data-width="50" data-formatter="solicitantePerfil.estadoFormatter">ESTADO</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SOLICITUDES ARCO -->
                    <div class="tab-pane " id="prof_arco">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">SOLICITUDES PARA EL EJERCICIO DE LOS DERECHOS “ARCO” </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblSolicitudesArco"
                                               data-detail-view="true"
                                               data-detail-formatter="solicitudes.detailFormatter"
                                               data-mobile-responsive="true"
                                               data-show-export="true"
                                               data-click-to-select="true"
                                               data-locale="es-MX"
                                               data-height="500"
                                               data-pagination="true"
                                               data-side-pagination="server"
                                               data-page-size="20"
                                               data-search="true"
                                               data-show-toggle="true"
                                               data-striped="true"
                                               data-resizable="true"
                                               data-sort-name="ID_SOLICITUD"
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
                                               class="table table-bordered table-hover table-condensed"
                                               style="display: none;">
                                            <thead>
                                            <tr>
                                                <th data-field="ID_SOLICITUD" data-sortable="false" data-visible="false" data-align="center" data-width="20">ID</th>
                                                <th data-field="FOLIO" data-sortable="false"  data-align="center" data-width="40">FOLIO</th>
                                                <th data-field="FOLIO_EXTERNO" data-sortable="false"  data-align="center" data-width="40">EXTERNO</th>
                                                <th data-field="TIPO"  data-align="center" data-width="100">TIPO DE SOLICITUD</th>
                                                <th data-field="MEDIO" data-sortable="false"  data-align="center" data-width="80">RECEPCIÓN</th>
                                                <th data-field="FECHA_RECEPCION" data-sortable="false" data-align="center" data-width="30">RECEPCIÓN</th>
                                                <th data-field="FECHA_PREVENCION" data-sortable="false"  data-align="center" data-width="30">PREVENCIÓN</th>
                                                <th data-field="FECHA_TURNADO" data-sortable="false"  data-align="center" data-width="30">TURNADO</th>
                                                <th data-field="ETAPA" data-sortable="false"  data-align="center" data-width="50" data-formatter="solicitantePerfil.etapaFormatter">ETAPA ACTUAL</th>
                                                <th data-field="ESTADO" data-sortable="false" data-align="center" data-width="50" data-formatter="solicitantePerfil.estadoFormatter">ESTADO</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RECURSOS DE REVISION -->
                    <div class="tab-pane " id="prof_rrevision">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">SOLICITUD EN RECURSO DE REVISIÓN</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblRecursosR"
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
                                               data-sort-name="ID_COMENTARIO"
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
                                               class="table table-bordered table-hover table-condensed"
                                               style="display: none;">
                                            <thead>
                                            <tr>
                                                <th data-field="FECHA_I" data-align="center"  data-width="100" data-sortable="true">FECHA REGISTRO</th>
                                                <th data-field="COMENTARIO" data-sortable="true">COMENTARIO</th>
                                                <th data-field="USUARIO" data-align="center" data-width="100" data-sortable="true">USUARIO</th>
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
                                <h3 class="panel-title panel-center">HISTORIAL DE COMENTARIOS </h3>
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
                                               data-show-toggle="true"
                                               data-striped="true"
                                               data-resizable="true"
                                               data-sort-name="ID_COMENTARIO"
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
                                               class="table table-bordered table-hover table-condensed"
                                               style="display: none;">
                                            <thead>
                                            <tr>
                                                <th data-field="FECHA_I" data-align="center"  data-width="100" data-sortable="true">FECHA REGISTRO</th>
                                                <th data-field="COMENTARIO" data-sortable="true">COMENTARIO</th>
                                                <th data-field="USUARIO" data-align="center" data-width="100" data-sortable="true">USUARIO</th>
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
                                <h3 class="panel-title panel-center">HISTORIAL DE ACCIONES </h3>
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
                                               data-show-toggle="true"
                                               data-striped="true"
                                               data-resizable="true"
                                               data-sort-name="ID_HISTORIAL"
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
                                               class="table table-bordered table-hover table-condensed"
                                               style="display: none;">
                                            <thead>
                                            <tr>
                                                <th data-field="FECHA_I" data-width="50" data-align="center" data-sortable="true">FECHA REGISTRO</th>
                                                <th data-field="MENSAJE" data-sortable="true">MENSAJE</th>
                                                <th data-field="USUARIO" data-align="center" data-width="100" data-sortable="true">USUARIO</th>
                                            </tr>
                                            </thead>
                                        </table>
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
    {{ javascript_include('js/views/solicitantes/perfil.js') }}
{% endblock %}

{# preguntas/perfil.volt #}

{% extends "templates/base_admin.volt" %}

{% block content %}
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <section class="content-header">
            <h1>
                <span>Perfil de la Pregunta</span>
                <small>Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Perfil de la Pregunta</li>
            </ol>
        </section>

        <section class="content">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            {{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,
                                'style': 'opacity:0.3;width: 35%;') }}
                        </div>
                        <div class="col-md-3 pull-right">
                            <input type="hidden" class="form-control" name="txtIdPregunta" id="txtIdPregunta" value="{{ idPregunta }}"/>
                            <table class="table table-bordered-title text-center" style="margin: 0px;">
                                <thead >
                                    <tr>
                                        <th>ID PREGUNTA</th>
                                        <th>FECHA REGISTRO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>{{ pregunta.ID_PREGUNTA }}</b></td>
                                        <td><b>{{ pregunta.FECHA_I }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active tab-blue"><a href="#prof_pregunta" data-toggle="tab" aria-expanded="false"> Información de la pregunta</a></li>
                    <li class="tab-blue"><a href="#prof_dependendencias" data-toggle="tab" aria-expanded="true">Dependencias turnadas</a></li>
                    <li class="tab-blue"><a href="#prof_comentarios" data-toggle="tab" aria-expanded="true">Comentarios</a></li>
                    <li class="tab-blue"><a href="#prof_historial" data-toggle="tab" aria-expanded="true">Historial</a></li>
                </ul>
                <div class="tab-content">
                    <!-- PREGUNTA -->
                    <div class="tab-pane active" id="prof_pregunta">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DATOS DE LA PREGUNTA</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-12">
                                    <h4 class="text-muted">¿Cuál es la pregunta del solicitante?</h4>
                                    <textarea class="form-control" rows="6" disabled>{{ pregunta.DESCRIPCION }}</textarea>
                                    <h4 class="text-muted">Observaciones de la pregunta descrita anteriormente para ayudar con el turnado</h4>
                                    <textarea class="form-control" rows="6" disabled>{{ pregunta.OBSERVACIONES }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DEPENDENCIAS -->
                    <div class="tab-pane" id="prof_dependendencias">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title panel-center">DEPENDENCIAS TURNADAS</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblDependencias"
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
                                               data-sort-name="ID_DEPENDENCIA"
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
                                                <th data-field="ID_DEPENDENCIA"  data-width="40" data-sortable="true">FLEX_VALUE_ID</th>
                                                <th data-field="FLEX_VALUE"  data-width="40" data-sortable="true">FLEX_VALUE</th>
                                                <th data-field="DEPENDENCIA" data-width="150" data-sortable="true">DEPENDENCIA</th>
                                                <th data-field="FECHA_I" data-align="center"  data-width="100" data-sortable="true">FECHA TURNADO</th>
                                                <th data-field="USUARIO" data-align="center"  data-width="100" data-sortable="true">TURNADO POR</th>
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
                                                <th data-field="FECHA_I" data-width="40" data-sortable="true">FECHA REGISTRO</th>
                                                <th data-field="FLEX_VALUE" data-sortable="true"  data-width="40">FLEX_VALUE</th>
                                                <th data-field="DEPENDENCIA" data-sortable="true" data-width="150">DEPENDENCIA</th>
                                                <th data-field="COMENTARIO" data-sortable="true"  data-width="150">COMENTARIO</th>
                                                <th data-field="USUARIO" data-width="150" data-sortable="true">USUARIO</th>
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
    {{ javascript_include('js/views/preguntas/perfil.js') }}
{% endblock %}

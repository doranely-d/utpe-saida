{# preguntas/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('js/bootstrap/bootstrap-table/extensions/group-by/bootstrap-table-group-by.css') }}
    {{ stylesheet_link('css/jquery/multi.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Peticiones de acceso a información</span>
                <small>Crear, Modificar, Eliminar, Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Peticiones de acceso a información</li>
            </ol>
        </section>

        <section class="content">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            {{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,
                                'style': 'opacity:0.3;width: 100%;') }}
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-center"><b> ADMINISTRACIÓN DE PREGUNTAS TURNADAS</b></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-header">
                <div class="box-body">
                    <div class="rows">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" name="txtTipoSolicitud" id="txtTipoSolicitud" value="{{ tipo }}"/>
                                <table id="tblPreguntas"
                                       data-toggle="tblPreguntas"
                                       data-group-by="true"
                                       data-group-by-field="FOLIO"
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
                                       data-sort-name="FOLIO"
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
                                            <th data-field="FOLIO" data-sortable="true" data-align="center"  data-width="100">FOLIO</th>
                                            <th data-field="ID_PREGUNTA" data-sortable="true" data-align="center"  data-width="100">ID PREGUNTA</th>
                                            <th data-field="DESCRIPCION" >DESCRIPCIÓN</th>
                                            <th data-sortable="false" data-align="center" data-width="120" data-formatter="preguntas.accionesFormatter">ACCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
{% endblock %}

{% block footer %}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/group-by/bootstrap-table-group-by.js') }}
    {{ javascript_include('js/jquery/multi.min.js') }}
    {{ javascript_include('js/views/preguntas/preguntas.js') }}
{% endblock %}
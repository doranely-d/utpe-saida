{# medios/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Medios de Respuesta</span>
                <small>Crear, Modificar, Eliminar, Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active"> Medios de Respuesta</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Administración de Medios de Respuesta</h3>
                </div>
                <div class="box-body">
                    <div class="rows">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                    <button id="btnAgregarMedio" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Agregar Medio de Respuesta">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar Medio
                                    </button>
                                </div>
                                <table id="tblMedios"
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
                                       data-show-refresh="false"
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
                                            <th data-field="MEDIO"  data-align="center" data-sortable="true">MEDIO RESPUESTA</th>
                                            <th data-field="COSTO" data-sortable="false"  data-formatter="general.formatoMoneda"  data-align="center">COSTO</th>
                                            <th data-sortable="false" data-align="center" data-width="100" data-formatter="medios.actionFormatter">ACCIONES</th>
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
    {{ javascript_include('js/views/administracion/medios.js') }}
{% endblock %}
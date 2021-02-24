{# diasinhabiles/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/bootstrap/bootstrap-datetimepicker.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Días Inhábiles
                <small>Crear, Modificar, Eliminar, Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active"> Días Inhábiles</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Administración de  Días Inhábiles</h3>
                </div>
                <div class="box-body">
                    <div class="rows">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                    <button id="btnAgregarCalendario" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Agregar día Inhábil">
                                        <span class="fa fa-calendar-plus-o"></span>&nbsp; Agregar día Inhábil
                                    </button>
                                </div>
                                <table id="tblDiasInhabiles"
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
                                       data-sort-name="FECHA"
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
                                            <th data-field="ID" data-align="center" data-sortable="true">ID</th>
                                            <th data-field="FECHA" data-align="center" data-sortable="true">FECHA</th>
                                            <th data-field="DESCRIPCION" data-align="center" data-sortable="true">DESCRIPCION</th>
                                            <th data-field="DIA" data-align="center" data-sortable="true" data-width="150" data-formatter="diasInhabiles.inhabilitadoFormatter">ESTATUS</th>
                                            <th data-sortable="false" data-align="center" data-width="150" data-formatter="diasInhabiles.actionFormatter">ACCIONES</th>
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
    {{ javascript_include('js/bootstrap/bootstrap-datetimepicker.min.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/views/administracion/dias-inhabiles.js') }}
{% endblock %}
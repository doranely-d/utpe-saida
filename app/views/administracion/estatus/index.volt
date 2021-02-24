{# estatus/pregunta/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Estatus de preguntas</span>
                <small>Crear, Modificar, Eliminar, Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('login/inicio') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Estatus de preguntas</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-header">
                <div class="box-header with-border">
                    <h3 class="box-title"> Administración de Estatus</h3>
                </div>
                <div class="box-body">
                    <div class="rows">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group well well-sm">
                                    <button id="btnAgregarEstatus" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Agregar estatus">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar Estatus
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" class="form-control" name="opt" id="opt" value="{{ opt }}"/>
                                <table id="tblEstatus"
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
                                       data-sort-name="ID"
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
                                            <th data-field="ID" data-sortable="true">ID</th>
                                            <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                                            <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCIÓN</th>
                                            <th data-field="COLOR" data-sortable="true" data-width="100" data-formatter="estatus.colorFormatter">COLOR</th>
                                            <th data-sortable="false" data-align="center" data-width="100" data-formatter="estatus.actionFormatter">ACCIONES</th>
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
    {{ javascript_include('css/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/views/administracion/estatus.js') }}
{% endblock %}
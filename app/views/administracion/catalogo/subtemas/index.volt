{# subtemas/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/bootstrap/select2.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Subtemas</span>
                <small>Crear, Modificar, Eliminar, Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Subtemas</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Administración de Subtemas</h3>
                </div>
                <div class="box-body">
                    <div class="rows">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                    <button id="btnAgregarSubtema" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Agregar Subtema">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar Subtema
                                    </button>
                                </div>
                                <table id="tblSubtemas"
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
                                       data-sort-name="ID_SUBTEMA"
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
                                            <th data-field="SUBTEMA" data-sortable="true">SUBTEMA</th>
                                            <th data-field="DESCRIPCION" data-sortable="true">DESCRIPCIÓN</th>
                                            <th data-field="TEMA" data-sortable="true">TEMA</th>
                                            <th data-sortable="false" data-align="center" data-width="100" data-formatter="subtemas.actionFormatter">ACCIONES</th>
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
    {{ javascript_include('js/jquery/select2/select2.min.js') }}
    {{ javascript_include('js/jquery/select2/language/es.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/views/administracion/catalogo/subtemas.js') }}
{% endblock %}
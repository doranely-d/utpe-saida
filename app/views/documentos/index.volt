{# documentos/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/bootstrap/fileinput.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Documentos</span>
                <small>Crear, Modificar, Eliminar, Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Documentos</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Administración de Documentos</h3>
                </div>
                <div class="box-body">
                    <div class="rows">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                    <button id="btnAgregarDocumento" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Agregar Documentos">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Agregar Documentos
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
                                       data-show-refresh="false"
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
                                            <th data-field="NUMROW" data-align="center" data-sortable="true" data-formatter="documentos.numRowFormatter"  data-width="100">NO.</th>
                                            <th data-field="NOMBRE" data-sortable="true" data-formatter="documentos.nombreDocFormatter">NOMBRE</th>
                                            <th data-sortable="false" data-align="center" data-width="200" data-formatter="documentos.actionFormatter">ACCIONES</th>
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
    {{ javascript_include('js/bootstrap/fileinput/fileinput.js') }}
    {{ javascript_include('js/bootstrap/fileinput/locales/es.js') }}
    {{ javascript_include('js/jquery/jquery.fileDownload.js') }}
    {{ javascript_include('js/views/documentos/documentos.js') }}
{% endblock %}
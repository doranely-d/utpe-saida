{# workflow/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('js/extra/js-graph-it/css/js-graph-it.css') }}
    {{ stylesheet_link('css/bootstrap/select2.min.css') }}
    {{ stylesheet_link('css/bootstrap/bootstrap-datetimepicker.min.css') }}
    {{ stylesheet_link('css/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Flujo de trabajo</span>
                <small>Crear, Modificar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Flujo de trabajo</li>
            </ol>
        </section>

        <section class="content">
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title text-center">Etapas</h4>
                            </div>
                            <div class="box-body">
                                <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                    <button id="btnEtapa" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Agregar Etapa">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp Agregar Etapa
                                    </button>
                                </div>
                                <table id="tblEtapas"
                                       data-mobile-responsive="true"
                                       data-locale="es-MX"
                                       data-height="500"
                                       data-pagination="false"
                                       data-side-pagination="server"
                                       data-page-size="100"
                                       data-search="true"
                                       data-show-toggle="false"
                                       data-striped="true"
                                       data-resizable="true"
                                       data-sort-name="ID"
                                       data-sort-order="asc"
                                       data-show-refresh="false"
                                       data-fixed-columns="false"
                                       data-fixed-number="0"
                                       data-advanced-search="false"
                                       data-search-on-enter-key="false"
                                       data-pagination-v-align="both"
                                       data-smart-display="true"
                                       data-cache="false"
                                       class="table table-bordered table-hover table-condensed"
                                       style="display: none;">
                                    <thead>
                                    <tr>
                                        <th data-field="ID" data-visible="false" data-sortable="true">ID</th>
                                        <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                                        <th data-field="DESCRIPCION" data-visible="false" data-sortable="true">DESCRIPCION</th>
                                        <th data-field="PRINCIPAL" data-visible="false" data-align="center">INICIA</th>
                                        <th data-sortable="false" data-align="center" data-formatter="workflowP.etapasFormatter" data-width="150">ACCIONES</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Workflow - {{ FLUJO }}</h3>
                                <input type="hidden" class="form-control" name="txtIdFlujo" id="txtIdFlujo" value="{{ ID }}"/>
                                <button type="button" class="btn btn-link  pull-right" onclick="history.go(-1);">
                                    <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDYxMiA2MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA2MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0iX3gzN19fMzJfIj4KCQk8Zz4KCQkJPHBhdGggZD0iTTQ5Ny4yNSw0OTcuMjVjMCwyMS4xMTQtMTcuMTE3LDM4LjI1LTM4LjI1LDM4LjI1SDc2LjVjLTIxLjEzMywwLTM4LjI1LTE3LjEzNi0zOC4yNS0zOC4yNXYtMzgyLjUgICAgIGMwLTIxLjEzMywxNy4xMTctMzguMjUsMzguMjUtMzguMjVINDU5YzIxLjEzMywwLDM4LjI1LDE3LjExNywzOC4yNSwzOC4yNXY1Ny4zNzVoMzguMjVWMTE0Ljc1YzAtNDIuMjQ3LTM0LjI1My03Ni41LTc2LjUtNzYuNSAgICAgSDc2LjVDMzQuMjUzLDM4LjI1LDAsNzIuNTAzLDAsMTE0Ljc1djM4Mi41YzAsNDIuMjQ3LDM0LjI1Myw3Ni41LDc2LjUsNzYuNUg0NTljNDIuMjQ3LDAsNzYuNS0zNC4yNTMsNzYuNS03Ni41di01Ny4zNzVoLTM4LjI1ICAgICBWNDk3LjI1eiBNNTkyLjg3NSwyODYuODc1SDE4MC4wNDNsMTAwLjI3Mi0xMDAuMjcyYzcuNDc4LTcuNDU4LDcuNDc4LTE5LjU4NCwwLTI3LjA0MmMtNy40NzgtNy40NzgtMTkuNTg0LTcuNDc4LTI3LjA0MiwwICAgICBMMTIxLjMyOSwyOTEuNTIyYy0zLjk5NywzLjk3OC01LjY5OSw5LjI1Ni01LjQzMiwxNC40NzhjLTAuMjY4LDUuMjIxLDEuNDM1LDEwLjUsNS40MTMsMTQuNDc4bDEzMS45NDMsMTMxLjk0MyAgICAgYzcuNDU4LDcuNDc4LDE5LjU4NCw3LjQ3OCwyNy4wNDIsMGM3LjQ3OC03LjQ1OSw3LjQ3OC0xOS41ODQsMC0yNy4wNDNMMTgwLjA0MywzMjUuMTI1aDQxMi44MzIgICAgIGMxMC41NTcsMCwxOS4xMjUtOC41NjgsMTkuMTI1LTE5LjEyNUM2MTIsMjk1LjQ0Myw2MDMuNDMyLDI4Ni44NzUsNTkyLjg3NSwyODYuODc1eiIgZmlsbD0iI2Q1MGY2NyIvPgoJCTwvZz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K">
                                    &nbsp;Regresar a página anterior
                                </button>
                            </div>
                            <div class="box-body no-padding">
                                <div  id="mainC">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>
{% endblock %}

{% block footer %}
    {{ javascript_include('css/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}
    {{ javascript_include('js/jquery/select2/select2.min.js') }}
    {{ javascript_include('js/jquery/select2/language/es.js') }}
    {{ javascript_include('js/extra/js-graph-it/js/js-graph-it.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/jquery/mask/jquery.mask.js') }}
    {{ javascript_include('js/views/workflow/perfil.js') }}
{% endblock %}
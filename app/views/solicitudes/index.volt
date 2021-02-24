{# solicitudes/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/jquery/multi.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>
                     {% if tipo=== 'ARCO' %}Solicitud para el ejercicio de los derechos "ARCO"
                     {% else %}Solicitud de acceso a la información pública del poder ejecutivo{% endif  %}
                  </span>
                <small>Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">
                    {% if tipo=== 'ARCO' %}SOLICITUD PARA EL EJERCICIO DE LOS DERECHOS “ARCO”
                    {% else %}SOLICITUD DE ACCESO A LA INFORMACIÓN PÚBLICA DEL PODER EJECUTIVO{% endif  %}
                </li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-header">
                <div class="box-body">
                    <div class="rows">
                        <input type="hidden" class="form-control" name="txtTipoSolicitud" id="txtTipoSolicitud" value="{{ tipo }}"/>
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="tblSolicitudes"
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
                                        <th data-field="ETAPA" data-sortable="false"  data-align="center" data-width="50" data-formatter="solicitudes.etapaFormatter">ETAPA ACTUAL</th>
                                        <th data-field="ESTADO" data-sortable="false" data-align="center" data-width="50" data-formatter="solicitudes.estadoFormatter">ESTADO</th>
                                        <th data-field="N_ETAPA" data-sortable="false"  data-align="center" data-width="50" data-formatter="solicitudes.nEtapaFormatter">ETAPA SIGUIENTE</th>
                                        <th data-sortable="false" data-align="center" data-width="100" data-formatter="solicitudes.actionSolicitudFormatter">ACCIONES</th>
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
    {{ javascript_include('js/jquery/jquery.fileDownload.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/jquery/multi.min.js') }}
    {{ javascript_include('js/views/solicitudes/index.js') }}
{% endblock %}

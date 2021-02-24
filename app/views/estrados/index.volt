{% extends "templates/base_portal.volt" %}

{% block content %}
    <div class="content-wrapper" style="padding-top: 70px;">
        <div class="container">
            <section class="content-header"></section>
            <section class="content">
                <div class="box box-primary">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h1 class="text-center">NOTIFICACIONES POR ESTRADOS <br>UNIDAD DE TRANSPARENCIA DEL PODER EJECUTIVO</h1>
                            </div>
                        </div>
                        <table id="tblSolicitudes"
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
                                <th data-field="FOLIO" data-align="center" data-width="50">FOLIO</th>
                                <th data-field="FOLIO_EXTERNO" data-align="center"  data-width="50" data-sortable="false">FOLIO EXTERNO</th>
                                <th data-field="TIPO" data-align="center" data-width="200">SOLICITUD</th>
                                <th data-field="ESTADO" data-sortable="false" data-align="center" data-width="50" data-formatter="solicitudes.estadoFormatter">ESTADO</th>
                                <th data-field="FECHA_RECEPCION" data-align="center" data-width="50">RECEPCIÓN</th>
                                <th data-field="DOCUMENTO" data-sortable="false" data-align="center"  data-formatter="solicitudes.documentoFormatter">ANEXOS</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
{% endblock %}

{% block footer %}
    {{ javascript_include('js/jquery/jquery.fileDownload.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/views/estrados.js') }}
{% endblock %}
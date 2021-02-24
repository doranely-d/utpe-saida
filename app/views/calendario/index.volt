{# calendario/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/fullcalendar/fullcalendar.min.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Calendario</span>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Calendario</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Estatus de solicitudes</h4>
                                    <input type="hidden" class="form-control" name="txtTipoSolicitud" id="txtTipoSolicitud" value="{{ tipo }}"/>
                                </div>
                                <div class="box-body scroll">
                                    <div id="external-events"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="box box-primary">
                                <div class="box-body no-padding">
                                    <!-- CALENDARIO -->
                                    <div id="calendar"></div>
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
    {{ javascript_include('js/fullcalendar/moment.js') }}
    {{ javascript_include('js/fullcalendar/fullcalendar.min.js') }}
    {{ javascript_include('js/fullcalendar/locale/es.js') }}
    {{ javascript_include('js/views/solicitudes/calendario.js') }}
{% endblock %}

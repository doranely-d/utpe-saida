{# workflow/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('js/extra/js-graph-it/css/js-graph-it.css') }}
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
                    <div class="col-md-12">
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
                                <div  id="mainC"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>
{% endblock %}

{% block footer %}
    {{ javascript_include('js/extra/js-graph-it/js/js-graph-it.js') }}
    {{ javascript_include('js/views/workflow/workflow.js') }}
{% endblock %}
{# errores/404.volt #}

{% extends "templates/base.volt" %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                404 Página de error
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('index/inicio') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">404 Página de error</li>
            </ol>
        </section>
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! La página solicitada no se encuentra.</h3>

                    <p>
                    </p>
                </div>
            </div>
        </section>
    </div>
{% endblock %}
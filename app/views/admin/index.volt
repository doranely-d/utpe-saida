{# login/inicio.volt #}
{% extends "templates/base_admin.volt" %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Inicio</span>
                <small>Página Principal</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Inicio</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Bienvenido(a) <span> {{ nombre }}</span></h3>
                </div>
                <div class="row" style="text-align: center;">
                    {{ image('img/SPF.png', 'alt': 'Imagen de unidad de transparencia' , 'style': 'opacity:0.3;   margin: 0 auto;','class': 'img-circle img-responsive') }}
                </div>
            </div>
        </section>
    </div>
{% endblock %}
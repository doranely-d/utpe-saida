{# perfil/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Mi perfil
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('login/inicio') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Perfil</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="register-box">
                    <div class="register-box-body">
                        <div class="container">
                            {{ image('img/user-128x128.png', 'alt': 'Imagen de usuario', 'class': 'profile-user-img img-responsive img-circle image') }}
                        </div>
                        <h3 class="profile-username text-center">{{ nombre }}</h3>

                        <p class="text-muted text-center">{{ dependencia }}</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Usuario:</b> <span class="pull-right text-muted"> {{ usuario }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Nombre:</b> <span class="pull-right text-muted">{{ nombre }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Correo electrónico:</b> <span class="pull-right text-muted">{{ correo }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Fecha de ingreso</b> <span class="pull-right text-muted">{{ fecha_i }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Dependencia</b> <span class="pull-right text-muted">{{ dependencia }}</span>
                            </li>
                        </ul>

                        <a href="#"  id="btnEditarPerfil" class="btn btn-warning btn-block"><b>Editar perfil</b></a>
                        <a href="#" id="btnEditarPassword" class="btn btn-warning btn-block"><b>Cambiar contraseña</b></a>
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
    {{ javascript_include('js/bootstrap/fileinput/fileinput.js') }}
    {{ javascript_include('js/bootstrap/fileinput/locales/es.js') }}
    {{ javascript_include('js/views/perfil/perfil.js') }}
{% endblock %}
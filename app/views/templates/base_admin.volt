<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-MX" lang="es-MX" prefix="og: http://ogp.me/ns#" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{ get_title() }}
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        {{ stylesheet_link('css/bootstrap/bootstrap.min.css') }}
        {{ stylesheet_link('css/fa/font-awesome.min.css') }}
        {{ stylesheet_link('css/ionicons/ionicons.min.css') }}
        {{ stylesheet_link('css/AdminLTE.min.css') }}
        {{ stylesheet_link('css/skins/_all-skins.min.css') }}
        {{ stylesheet_link('css/bootstrap/bootbox.css') }}
        {{ stylesheet_link('css/style.css') }}
        {{ stylesheet_link('css/jquery/formValidation.min.css') }}
        {{ stylesheet_link('css/bootstrap/bootstrap-table.min.css') }}
        {% block head %} {% endblock %}
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('img/favicon.png') }}" />
    </head>
    <body id="body" class="skin-blue fixed sidebar-mini sidebar-mini-expand-feature">
        <div class="wrapper">
            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown notifications-menu">
                                <ul class="dropdown-menu">
                                    <li class="header text-center">NOTIFICACIONES</li>
                                    <li>
                                        <ul class="menu" id="menu-notificaciones">
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    {{ image('img/user-128x128.png', 'alt': 'Imagen de usuario', 'class': 'user-image') }}
                                    <span class="hidden-xs">{{ nombre }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        {{ image('img/user-128x128.png', 'alt': 'Imagen de usuario', 'class': 'img-circle') }}
                                        <p>{{ nombre }}</p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{ url('perfil/login') }}" class="btn btn-default btn-flat">Perfil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ url('login/logout') }}" class="btn btn-default btn-flat">Cerrar sesión</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <a href="{{ url('admin') }}">
                            {{ image('img/logo-transparencia.png', 'alt': 'Imagen de usuario', 'style': 'width:200px') }}
                        </a>
                    </div>
                    <ul class="sidebar-menu tree" data-widget="tree">
                        {{ elements.getMenu() }}
                    </ul>
                </section>
            </aside>

            {% block content %} {% endblock %}

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Versi&#243;n</b> 1.0
                </div>
                <strong>Copyright &#64; <span>{{today }}</span> <a href="http://www.queretaro.gob.mx/transparencia" target="_blank">Unidad de Transparencia del Poder Ejecutivo del Estado de Quer&#233;taro</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>

        <!-- jQuery, plugins and Bootstrap JS -->
        {{ javascript_include('js/jquery/jquery-2.2.4.min.js') }}
        {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
        {{ javascript_include('js/bootstrap/bootstrap-notify.min.js') }}
        {{ javascript_include('js/bootstrap/bootbox.min.js') }}
        {{ javascript_include('js/jquery/jquery.base64.min.js') }}
        {{ javascript_include('js/jquery/jquery.blockUI.js') }}
        {{ javascript_include('js/jquery/jquery.slimscroll.min.js') }}
        {{ javascript_include('js/adminlte.min.js') }}
        {{ javascript_include('js/extra/fastclick.js') }}
        {{ javascript_include('js/extra/moment-with-locales.js') }}
        {{ javascript_include('js/app.min.js') }}
        {{ javascript_include('js/adminlte.js') }}
        {{ javascript_include('js/general.js') }}
        {% block footer %}{% endblock %}
    </body>
</html>
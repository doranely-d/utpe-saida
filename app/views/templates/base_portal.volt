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
    {{ stylesheet_link('css/bootstrap/bootbox.css') }}
    {{ stylesheet_link('css/bootstrap/bootstrap-table.min.css') }}
    {{ stylesheet_link('css/main.css') }}
    {% block head %} {% endblock %}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('img/favicon.png') }}" />
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-6 col-sm-3">
                    <a href="{{ url('index') }}" class="logo">
                        <img src="{{ url('img/logo-transparencia.png') }}" alt="" style="width: 200px">
                    </a>
                </div>
                <div class="col-md-9 col-xs-9 col-sm-9">
                    <div class="menu">
                        <nav class="navbar navbar-default" role="navigation">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>

                                <div class="collapse navbar-collapse ">
                                    <ul class="nav navbar-nav">
                                        <li><a href="{{ url('formularios') }}">Solicitudes</a></li>
                                        <li><a href="{{ url('estrados') }}">Estrados</a></li>
                                        <li><a href="{{ url('login') }}">Ingresar</a></li>
                                        <li><a href="{{ url('registrar') }}">Registrarse</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    {% block content %} {% endblock %}
    <footer>
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <a class="footer-logo" href="#">
                        <img class="img-responsive" src="{{ url('logo-transparencia.png') }}" alt="">
                    </a>
                    <strong>Copyright @ <span>2021</span>
                        <a href="http://www.queretaro.gob.mx/" target="_blank">Poder Ejecutivo del Estado de Querétaro</a>.</strong> Todos los derechos reservados.
                </div>
            </div>
        </div>
    </footer>
    {% block content %} {% endblock %}
    {{ javascript_include('js/jquery/jquery-2.2.4.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-notify.min.js') }}
    {{ javascript_include('js/bootstrap/bootbox.min.js') }}
    {{ javascript_include('js/jquery/jquery.base64.min.js') }}
    {{ javascript_include('js/jquery/jquery.blockUI.js') }}
    {{ javascript_include('js/jquery/jquery.slimscroll.min.js') }}
    {{ javascript_include('js/extra/fastclick.js') }}
    {{ javascript_include('js/extra/moment-with-locales.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/general.js') }}
    {{ javascript_include('js/views/login.js') }}
    {% block footer %}{% endblock %}
</body>
</html>
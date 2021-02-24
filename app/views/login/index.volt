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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('img/favicon.png') }}" />
</head>
    <body id="body" class="login-page">
        <div class="login-box">
            <div class="login-logo">
                {{ image('img/logos.png', 'alt': 'Imagen de unidad de transparencia y del estado de Queretaro', 'style':'width: 99%;') }}
            </div>
            <div class="login-box-body">
                <p class="login-box-msg" style="font-size: 27px;"><b>Acceso a Usuarios</b></p>
                <form id="frmLogin" name="frmLogin" method="GET" action="#" data-fv-framework="bootstrap"
                      data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove"
                      data-fv-icon-validating="glyphicon glyphicon-refresh">
                    <div class="form-group has-feedback">
                        <div class="input-group ">
                            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                            <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
                                   value='<?php echo $this->security->getToken() ?>'/>
                            <input id="txtUsuario" name="txtUsuario" class="form-control" type="text"
                                   placeholder="Usuario" data-fv-notempty="true" data-fv-notempty-message="El usuario es requerido" />
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="txtPassword" name="txtPassword" class="form-control" type="password"
                                   placeholder="Contrase&#241;a" data-fv-notempty="true" data-fv-notempty-message="La contrase&#241;a es requerida" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-primary btn-block">ACCEDER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{ javascript_include('js/jquery/jquery-2.2.4.min.js') }}
        {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
        {{ javascript_include('js/bootstrap/bootstrap-notify.min.js') }}
        {{ javascript_include('js/bootstrap/bootbox.min.js') }}
        {{ javascript_include('js/jquery/jquery.base64.min.js') }}
        {{ javascript_include('js/jquery/jquery.blockUI.js') }}
        {{ javascript_include('js/jquery/jquery.slimscroll.min.js') }}
        {{ javascript_include('js/general.js') }}
        {{ javascript_include('js/jquery/formValidation.min.js') }}
        {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
        {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
        {{ javascript_include('js/views/login.js') }}
    </body>
</html>

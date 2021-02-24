<!DOCTYPE html>
<html>
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
    {{ stylesheet_link('css/style-portal.css') }}
    {{ stylesheet_link('css/jquery/formValidation.min.css') }}
    {{ stylesheet_link('css/bootstrap/bootstrap-table.min.css') }}
    {{ stylesheet_link('css/wizard/fuelux.min.css') }}
    {{ stylesheet_link('css/bootstrap/fileinput.css') }}
    {{ stylesheet_link('css/bootstrap/sweetalert.css') }}
    {{ stylesheet_link('css/bootstrap/bootstrap-datetimepicker.min.css') }}
    {{ stylesheet_link('css/bootstrap/select2.min.css') }}
    {{ stylesheet_link('css/bootstrap3-editable/css/bootstrap-editable.css') }}
    {{ stylesheet_link('css/jquery/multi.min.css') }}
    {{ stylesheet_link('js/extra/iCheck/all.css') }}
     <script src='https://www.google.com/recaptcha/api.js'></script>
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
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <header id="header">
                    <section id="top">
                        <div class="row">
                            <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4 pull-left">
                                <div id="topLogo" class="img-responsive text-center">
                                    <a href="#"> {{ image('img/logo-transparencia.png', 'alt': 'Imagen de unidad de transparencia y del estado de Queretaro', 'style':'width: 75%;') }}</a>
                                </div>
                            </div><!--/.col-lg-4-->
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                                <div class="img-responsive text-center">
                                    <a href="#"> {{ image('img/SPF.png', 'alt': 'Imagen de unidad de transparencia y del estado de Queretaro', 'style':'width: 75%;') }}</a>
                                </div>
                            </div><!--/.col-lg-4-->
                        </div><!--/.row-->
                    </section>
                </header><!--/header-->
            </div>
        </div>
        <div class="row">
            <!-- WIZARD -->
            <div class="fuelux">
                <div class="wizard" data-initialize="wizard" id="formularioWizard" data-restrict="previous">
                    <div class="steps-container">
                        <ul class="steps">
                            <li data-step="1" class="active">
                                <span class="badge">1</span>Informacion del solicitante<span class="chevron"></span>
                            </li>
                            <li data-step="2">
                                <span class="badge">2</span>Información de la Solicitud<span class="chevron"></span>
                            </li>
                        </ul>
                    </div>
                    <!-- FORMULARIO DE REGISTRO DE SOLICITUD -->
                    <form id="frmSolicitud" name="frmSolicitud" method="POST" action="#">
                        <!-- DATOS NECESARIOS PARA LA CAPTURA DE SOLICITUD -->
                        <input type="hidden" class="form-control" name="txtIdSolicitud" id="txtIdSolicitud"/>
                        <!-- / DATOS NECESARIOS PARA LA CAPTURA DE SOLICITUD -->

                        <div class="step-content">
                            <!-- INFORMACIÓN DEL SOLICITANTE -->
                            <div class="step-pane active" data-step="1">
                                <!-- ENCABEZADO SOLICITUD -->
                                <div class="panel panel-default panel-solicitud">
                                    <div class="panel-body ">
                                        <div class="rows">
                                            <div class="col-md-4">{{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,'style': 'opacity:0.3;width: 75%;') }}</div>
                                            <div class="col-md-8 pull-right">
                                                <h3 class="text-right solicitud-sai"><b> SOLICITUD DE ACCESO A LA INFORMACIÓN </br>PÚBLICA DEL PODER EJECUTIVO</b></h3>
                                                <h3 class="text-right solicitud-arco hidden"> <b>SOLICITUD PARA EL EJERCICIO DE LOS DERECHOS “ARCO” <br>(Acceso, Rectificación Cancelación y Oposición)</b></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">SOBRE EL AVISO DE PRIVACIDAD</h3>
                                    </div>
                                    <div class="panel-body">
                                        <b> La Unidad de Transparencia del Poder Ejecutivo del Estado de Querétaro es el organismo
                                            responsable del  tratamiento de los datos que nos proporcione, mismos que serán utilizados
                                            para efectuar el trámite de su solicitud de acceso a la información pública.
                                            Consulte nuestro aviso de privacidad en <a href="http://bit.ly/2zqyiGf" target="_blank">http://bit.ly/2zqyiGf</a> o en la oficina de atención de la Unidad.
                                        </b>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group col-md-6">
                                            <label for="slTema" class="text-right">Selecciona el tipo de solicitud: <span class="text-red">*</span></label>
                                            <select class="form-control" style="width:100%" id="slTipo" name="slTipo" lang="es">
                                                <option value="SAI">SOLICITUD DE ACCESO A LA INFORMACIÓN PÚBLICA</option>
                                                <option value="ARCO">SOLICITUD PARA EL EJERCICIO DE LOS DERECHOS “ARCO”</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 solicitud-arco hidden">
                                            <label for="slTema" class="text-right">Selecciona el tipo de gestion de los derechos ARCO: <span class="text-red">*</span></label>
                                            <select class="form-control" style="width:100%" id="slTGestion" name="slTGestion" lang="es">
                                                <option value="1">ACCESO - Derecho de ACCESO sobre sus datos de carácter personal</option>
                                                <option value="2">RECTIFICACIÓN - Derecho de RECTIFICACIÓN de los datos de carácter personal</option>
                                                <option value="3">CANCELACIÓN -Derecho de CANCELACIÓN de los datos de carácter personal</option>
                                                <option value="4">OPOSICIÓN - Derecho de OPOSICIÓN de los datos de carácter personal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default solicitud-sai">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE Y/O REPRESENTANTE LEGAL</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-2 texto-centrado">
                                                <input type="radio"  name="grupo-radio"  value="radio-solicitante" class="radio" checked> Solicitante
                                            </label>
                                        </div>
                                        <div class="row area-solicitud">
                                            <label class="col-md-2 text-right">
                                                <input type="radio"  name="grupo-radio-persona"  value="radio-pfisica" class="radio-persona" checked>Persona física:
                                            </label>
                                            <div class="radio-solicitante radio-pfisica">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Apellido Paterno</label>
                                                        <input class="form-control" name="txtApellidoP" id="txtApellidoP" placeholder="Apellido Paterno" type="text" data-fv-notempty="true" >
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Apellido Materno</label>
                                                        <input class="form-control" name="txtApellidoM" id="txtApellidoM" placeholder="Apellido Materno" type="text" data-fv-notempty="true" >
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Nombre(s)</label>
                                                        <input id="txtNombre" name="txtNombre" class="form-control" placeholder="Nombre(s)" type="text" data-fv-notempty="true" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row area-solicitud">
                                            <label class="col-md-2 text-right">
                                                <input type="radio" name="grupo-radio-persona" value="radio-pmoral" class="radio-persona">Persona moral:
                                            </label>
                                            <div class="col-md-6 radio-pmoral">
                                                <div class="form-group">
                                                    <label class="text-muted">Razón social</label>
                                                    <input class="form-control" id="txtRazonSocial" name="txtRazonSocial" placeholder="Razón social o denominación" type="text" data-fv-notempty="true" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-2 text-right">Representante legal: <span class="text-yellow">*</span></label>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Apellido Paterno (representante):</label>
                                                    <input class="form-control" name="txtApellidoPR" id="txtApellidoPR" placeholder="Apellido Paterno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Apellido Materno (representante):</label>
                                                    <input class="form-control" name="txtApellidoMR" id="txtApellidoMR" placeholder="Apellido Materno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Nombre(s) (representante):</label>
                                                    <input id="txtNombreR" name="txtNombreR" class="form-control" placeholder="Nombre(s)" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right"> <b><span class="text-yellow">*</span></b> Solamente con poder notarial (presentar original o copia certificada para cotejo)</p>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 texto-centrado">
                                                <input type="radio"  name="grupo-radio"  value="radio-seudonimo" class="radio"> Seudónimo
                                            </label>
                                            <div class="col-sm-4 radio-seudonimo">
                                                <div class="form-group">
                                                    <label class="text-muted">Seudónimo (indicar)</label>
                                                    <input class="form-control" id="txtSeudonimo" name="txtSeudonimo" type="text" placeholder="Seudónimo" data-fv-notempty="true">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 texto-centrado">
                                                <input type="radio" name="grupo-radio"  value="radio-anonimo" id="radio-anonimo" class="radio"> Anónimo
                                            </label>
                                            <div class="col-sm-8">
                                                Al representar su solicitud utilizando seudónimo  o de forma anónima, no es
                                                necesario completar la siguiente sección ni firmar la presente solicitud.
                                                <br>Sin embargo, debe considerar que la(s) notificación(es) que corresponda(n)
                                                a su trámites, se realizará en los ESTRADOS de la Unidad de Transparencia del Poder Ejecutivo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default solicitud-arco hidden">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DATOS DEL TITULAR</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-row">
                                            <label class="col-md-2 control-label">Titular de los datos personales:</label>
                                            <div class="form-group col-md-3">
                                                <label for="txtApellidoPT" class="text-muted"> Apellido Paterno: <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" name="txtApellidoPT" id="txtApellidoPT" placeholder="Apellido Paterno" data-fv-notempty="true">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="txtApellidoMT" class="text-muted"> Apellido Materno: <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" name="txtApellidoMT" id="txtApellidoMT" placeholder="Apellido Materno" data-fv-notempty="true">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="txtNombreT" class="text-muted"> Nombres(s): <span class="text-red">*</span></label>
                                                <input  type="text" class="form-control"  name="txtNombreT" id="txtNombreT" placeholder="Nombre(s)" data-fv-notempty="true">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3 col-md-offset-2">
                                                <label for="txtFechaNacimiento" class="text-muted"> Fecha de nacimiento: <span class="text-red">*</span></label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="txtFecha" id="txtFecha" value="{{ fecha_nacimiento }}"/>
                                                    <input class="form-control pull-right" id="txtFechaNacimiento" name="txtFechaNacimiento" type="text" data-fv-notempty="true"   data-fv-date-format="YYYY/MM/DD" data-fv-date-message="The value is not a valid date">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-md-2 text-muted" style="padding-top: 10px;"> Vive:<span class="text-red">*</span></label>
                                                <label class="col-md-2" style="padding-top: 10px;"><input type="radio" name="grupo-vive" value="SI" class="radio-vive" checked> Si</label>
                                                <label class="col-md-3" style="padding-top: 10px;"><input type="radio" name="grupo-vive" value="NO" class="radio-vive"> No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default solicitud-arco hidden">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">ACREDITACIÓN DE LA IDENTIDAD DEL TITULAR <span class="text-yellow"> *</span> </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-3">
                                                <input type="radio" name="checkbox-titular" value="radio-mayor" class="radio-acreditacion" checked> Si es mayor de edad
                                            </label>
                                            <div class="col-md-9 radio-mayor"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 checkbox-edad">
                                                <input type="radio" name="checkbox-titular" value="radio-menor" class="radio-acreditacion"> Si es menor de edad
                                            </label>
                                            <div class="col-md-9 radio-menor"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 checkbox-edad">
                                                <input type="radio" name="checkbox-titular" value="radio-fallecido" class="radio-acreditacion fallecido"> Si es fallecido
                                            </label>
                                            <div class="col-md-9 radio-fallecido"></div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 checkbox-edad">
                                                <input type="radio" name="checkbox-titular" value="radio-otro" class="radio-acreditacion">Otro (sólo validado por la UTPE)
                                            </label>
                                            <div class="col-md-4 radio-otro">
                                                <input id="txtOtro" name="txtOtro" class="form-control" placeholder="Escribe el nombre del documento" type="text" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default solicitud-arco hidden">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DATOS DEL REPRESENTANTE, TUTOR, INTERESADO <span>(si aplica)</span></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-row">
                                            <label class="col-md-2 text-right">Representante:</label>
                                            <div class="form-group col-md-3">
                                                <label for="txtApellidoPR2" class="text-muted">Apellido paterno:</label>
                                                <input type="text" class="form-control" id="txtApellidoPR2" name="txtApellidoPR2" placeholder="Apellido Paterno">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="txtApellidoMR2" class="text-muted"> Apellido Materno:</label>
                                                <input type="text" class="form-control" id="txtApellidoMR2" name="txtApellidoMR2" placeholder=" Apellido Materno">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="txtNombreR2" class="text-muted"> Nombre(s):</label>
                                                <input  type="text" class="form-control" id="txtNombreR2" name="txtNombreR2" placeholder="Nombre(s)">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <label class="col-md-2 text-right">Se acredita como:</label>
                                            <div class="col-md-10">
                                                <div class="col-md-2">
                                                    <label class="text-muted">
                                                        <input type="checkbox" class="minimal" name="checkRepresentante[]" value="Representante"> Representante
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="text-muted">
                                                        <input type="checkbox" class="minimal fallecido" name="checkRepresentante[]" value="Interesado"> Interesado por fallecimiento del titular
                                                    </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="text-muted">
                                                        <input type="checkbox" class="minimal" name="checkRepresentante[]" value="Padre o Madre"> Padre/Madre
                                                    </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="text-muted">
                                                        <input type="checkbox" class="minimal" name="checkRepresentante[]" value="Tutor"> Tutor
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default solicitud-arco hidden">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">ACREDITACIÓN DE LA IDENTIDAD DEL REPRESENTANTE O TUTOR <span>(si aplica)</span></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-row">
                                                <label class="col-md-3">Persona física. Representante, persona que ejerce la patria potestad, tutor, interesado</label>
                                                <div class="col-md-9 checkbox-persona" style="padding-top: 20px;"></div>
                                            </div>
                                            <div class="form-row">
                                                <label class="col-md-4">Acreditación como representante:</label>
                                                <div class="col-md-10 col-md-offset-2">
                                                    <label class=" col-md-2 text-muted text-right"> - Persona Física</label>
                                                    <div class="col-md-10 checkbox-fisica"></div>
                                                </div>
                                                <div class="col-md-10 col-md-offset-2">
                                                    <label class="col-md-2 text-muted text-right"> - Persona Moral</label>
                                                    <div class="col-md-10 checkbox-moral"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <label class="col-md-4">Persona que ejerce la patria potestad o tutor:</label>
                                                <div class="col-md-10 col-md-offset-2">
                                                    <label class=" col-md-2 text-muted text-right"> - Padre/Madre</label>
                                                    <div class="col-md-10 checkbox-padres"></div>
                                                </div>
                                                <div class="col-md-10 col-md-offset-2">
                                                    <label class="col-md-2 text-muted text-right"> - Tutor</label>
                                                    <div class="col-md-10 checkbox-tutor"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <label class="col-md-3">Persona interesada a causa del fallecimiento del titular:</label>
                                                <div class="col-md-9 checkbox-tutor-fallecido"></div>
                                            </div>
                                        </div>
                                        <p class="text-right text-muted"><span class="text-yellow">*</span> Presentar copia simple y original para cotejar.</p>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DATOS DEL SOLICITANTE O REPRESENTANTE LEGAL - PARA NOTIFICACIONES</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <label class="col-md-2 radio-notificaciones control-label text-right">
                                                <input type="checkbox" class="minimal" value="checkbox-correo" checked> Correo electrónico
                                            </label>
                                            <div class="col-md-4 checkbox-correo area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Correo electrónico:</label>
                                                    <input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Dirección de correo electrónico válida " type="email" data-fv-notempty="true" >
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 radio-notificaciones control-label text-right">
                                                <input type="checkbox" class="minimal" value="checkbox-domicilio" checked> Domicilio <span class="text-yellow">**</span>
                                            </label>
                                            <div  class="col-md-5 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Calle, número exterior y número interior:</label>
                                                    <input class="form-control" id="txtDireccion" name="txtDireccion" placeholder="Calle, número exterior y número interior" type="text" data-fv-notempty="true">
                                                </div>
                                            </div>
                                            <div class="col-md-5 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Colonia o fraccionamiento:</label>
                                                    <input class="form-control" id="txtColonia" name="txtColonia" placeholder="Colonia o fraccionamiento" type="text" data-fv-notempty="true" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-2 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Entidad Federativa / País:</label>
                                                    <select class="form-control" style="width:100%" id="slEstado" name="slEstado" lang="es" data-fv-notempty="true" ></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Delegación o municipio:</label>
                                                    <select class="form-control" style="width:100%" id="slMunicipio" name="slMunicipio" lang="es" data-fv-notempty="true"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Código Postal:</label>
                                                    <input class="form-control" id="txtCodigoP" name="txtCodigoP" placeholder="C.P " type="text" data-fv-notempty="true" data-mask="0#" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-2 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Entre las calles:</label>
                                                    <input class="form-control" id="txtEntreCalles" name="txtEntreCalles" type="text" data-fv-notempty="true" >
                                                </div>
                                            </div>
                                            <div class="col-md-5 checkbox-domicilio area-notificacion">
                                                <div class="form-group">
                                                    <label class="text-muted"> Otras referencias para la ubicación del domicilio:</label>
                                                    <input class="form-control" id="txtOtraReferencia" name="txtOtraReferencia" type="text" data-fv-notempty="true" >
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right text-muted"><b><span class="text-yellow">** </span></b>
                                            Todas las notificaciones fuera del Municipio de Querétaro y zona conurbada se efectuarán por correo certificado.</p>
                                        <hr>
                                        <div class="row">
                                            <label class="col-md-2 radio-notificaciones control-label text-right">
                                                <input type="checkbox" class="minimal" value="checkbox-telefono" checked> Telefóno
                                            </label>
                                            <div class="checkbox-telefono area-notificacion">
                                                <div class="col-md-3">
                                                    <div class="form-grouObservaciones de la pregunta descrita anteriormente para ayudar con el turnado *p">
                                                        <label class="text-muted">Telefóno Fijo:</label>
                                                        <input class="form-control" id="txtTelefonoFijo" name="txtTelefonoFijo" placeholder="Telefóno Fijo" type="text" data-mask="0#">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-muted">Telefóno Celular:</label>
                                                        <input class="form-control" id="txtTelefonoCel" name="txtTelefonoCel" placeholder="Telefóno Celular" type="text" data-mask="(00) 0000-0000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right text-muted">Únicamente para informarle sobre la existencia de notificación,
                                            misma que deberá recoger en la Unidad. <br>De no contar con otro dato
                                            para la debida notificación y/o si no es posible localizarlo por
                                            este medio, se efectuará la notificación en Estrados de la Unidad.</p>
                                        <hr class="solicitud-sai">
                                        <div class="row solicitud-sai">
                                            <label class="col-md-2 control-label text-right">Persona autorizada:</label>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted">Apellido paterno:</label>
                                                    <input class="form-control" id="txtApellidoPPA" name="txtApellidoPPA" placeholder="Apellido paterno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted"> Apellido Materno:</label>
                                                    <input class="form-control" id="txtApellidoMPA" name="txtApellidoMPA" placeholder=" Apellido Materno" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-muted"> Nombre(s):</label>
                                                    <input class="form-control" id="txtNombrePA" name="txtNombrePA" placeholder="Nombre(s)" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right text-muted solicitud-sai">Distinta al titular o representante legal. Deberá presentar carta poder al momento de ser notificado.</p>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <p><b>Notificación en ESTRADOS de la Unidad de Transparencia del Poder Ejecutivo del Estado de Querétaro.</b>
                                            Al no proporcionar datos que permitan la notificación a través de los medios antes señalados, esta unidad notificará en ESTRADOS a más tardar el
                                            día 20 y hasta el día hábil número 50, a partir de la recepción de la presente solicitud.
                                            Debe considerar además que, de ser necesaria la prevención (numeral 4 del apartado de Información General), se publicaría la
                                            notificación correspondiente, a más tardar el 5 día hábil, contado a partir de la recepción de su solicitud.</p>
                                    </div>
                                </div>
                                <div class="panel panel-default solicitud-sai">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">CONSENTIMIENTO PARA EL TRATAMIENTO DE DATOS PERSONALES</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <p><b>La información de la presente Solicitud debe ser registrada y capturada en la Plataforma
                                                    Nacional de Transparencia, administrada por el Instituto Nacional de Transparencia,
                                                    Acceso a la Información y Protección de Datos Personales, según lo establecido en el
                                                    artículo 118 de la Ley de Transparencia y Acceso a la Información Pública del Estado de Querétaro.
                                                </b></p>
                                            <p><b> Autorizo a la Unidad, para el uso de los datos personales proporcionados en la presente solicitud, para su registro y captura en la PNT:</b></p>
                                            <div class="form-group">
                                                <label style="margin: 10px"><input type="radio" name="radio-consentimiento" class="radio-consentimiento" value="1" checked="">Si</label>
                                                <label style="margin: 10px"><input type="radio" name="radio-consentimiento" class="radio-consentimiento"  value="0">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-pane" data-step="2">
                                <!-- ENCABEZADO SOLICITUD -->
                                <div class="panel panel-default panel-solicitud">
                                    <div class="panel-body ">
                                        <div class="rows">
                                            <div class="col-md-4">{{ image('img/SPF_min.png', 'alt': 'Heráldica del estado de Querétaro' ,'style': 'opacity:0.3;width: 75%;') }}</div>
                                            <div class="col-md-8 pull-right">
                                                <h3 class="text-right solicitud-sai"><b> SOLICITUD DE ACCESO A LA INFORMACIÓN </br>PÚBLICA DEL PODER EJECUTIVO</b></h3>
                                                <h3 class="text-right solicitud-arco hidden"> <b>SOLICITUD PARA EL EJERCICIO DE LOS DERECHOS “ARCO” <br>(Acceso, Rectificación Cancelación y Oposición)</b></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DESCRIPCIÓN DE LA INFORMACIÓN SOLICITADA </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <h4>Antecedentes de la solicitud:</h4>
                                                <textarea class="form-control" rows="6" id="txtAntecedentes" name="txtAntecedentes" placeholder="Redactar los antecedentes de la solicitud."></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <label class="col-md-3 control-label pull-right"><input type="checkbox" class="checkbox" value="checkbox-preguntas"> Dividir en varias preguntas</label>
                                                <div class="form-group checkbox-agrupar">
                                                    <h4>¿Cuál es la Información Solicitada?<span class="text-red">*</span></h4>
                                                    <textarea class="form-control" rows="6" id="txtPeticion" name="txtPeticion"
                                                              placeholder="Descripción de la información solicitada" data-fv-notempty="true"></textarea>
                                                </div>
                                                <div class="form-group checkbox-agrupar">
                                                    <h4>Proporciona datos adicionales para facilitar el entendimiento de la información</h4>
                                                    <textarea class="form-control" rows="6" id="txtObservaciones" name="txtObservaciones"
                                                              placeholder="Descripción de la información adicional"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1 checkbox-preguntas hidden">
                                                <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                                    <button id="btnAgregarPregunta" class="btn btn-success" data-toggle="tooltip"
                                                            data-placement="top" title="Agregar Pregunta">
                                                        <span class="fa fa-plus"></span>&nbsp; Agregar Pregunta
                                                    </button>
                                                </div>
                                                <table id="tblPreguntas"
                                                       data-mobile-responsive="true"
                                                       data-locale="es-MX"
                                                       data-height="500"
                                                       data-pagination="true"
                                                       data-side-pagination="server"
                                                       data-page-size="20"
                                                       data-search="false"
                                                       data-show-toggle="false"
                                                       data-striped="true"
                                                       data-resizable="true"
                                                       data-sort-name="ID_PREGUNTA"
                                                       data-sort-order="asc"
                                                       data-show-refresh="false"
                                                       data-fixed-columns="false"
                                                       data-fixed-number="0"
                                                       data-advanced-search="false"
                                                       data-search-on-enter-key="false"
                                                       data-show-pagination-switch="false"
                                                       data-pagination-h-align="left"
                                                       data-smart-display="true"
                                                       data-cache="false"
                                                       class="table table-bordered table-hover table-condensed"
                                                       style="display: none;">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="NUMROW" data-align="center" data-formatter="solicitudes.numRowFormatter"  data-width="100">NO. PREGUNTA</th>
                                                        <th data-field="DESCRIPCION" data-sortable="false">DESCRIPCIÓN</th>
                                                        <th data-field="OBSERVACIONES" data-sortable="false">OBSERVACIONES</th>
                                                        <th data-sortable="false" data-align="center" data-width="100" data-formatter="solicitudes.actionFormatter">ACCIONES</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dependencia -->
                                <div class="panel panel-default solicitud-arco hidden">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">NOMBRE DE LA DEPENDENCIA Y ÁREA RESPONSABLE DE TRATAR LOS DATOS PERSONALES</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Búsqueda de las dependencias a las cuales turnar la solicitud:  <span class="text-yellow">*</span></h4>
                                                <select multiple="multiple" name="slDependencias" id="slDependencias" lang="es"></select></br>
                                                <h4>Proporciona datos adicionales para facilitar la localización de la información:</h4>
                                                <textarea class="form-control" rows="3" id="txtComentario" name="txtComentario"></textarea><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">INDIQUE CÓMO DESEA RECIBIR LA INFORMACIÓN (Ver numeral 9 y 10 de la sección de Información General) </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <p>Para proceder a pagar es necesario que seleccione uno de los Trámites del siguiente listado y agregue el concepto.
                                                    Si necesita ayuda, llámenos al teléfono (442) 211 7070  o  al 01-800 237 2233 de lunes a viernes de 08:00 a 20:00 hrs. y sábados de 09:00 a 14:00 hrs.</p>
                                                <div class="form-group col-md-5">
                                                    <label for="slMedioR" class=" text-muted text-right">Medio de respuesta: <span class="text-red">*</span></label>
                                                    <select class="form-control" style="width:100%" id="slMedioR" name="slMedioR" lang="es"></select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-muted text-right">Cantidad: <span class="text-red">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-cart-plus"></i></div>
                                                        <input class="form-control" id="txtCantidad" name="txtCantidad" type="number">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-muted text-right">Importe: <span class="text-red">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                                                        <input class="form-control" id="txtImporte" name="txtImporte" type="text" >
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3" style="padding-top: 25px;">
                                                    <button id="btnAgregarMedio" type="button" class="btn btn-success" data-toggle="tooltip"
                                                            data-placement="top" title="Agregar medio de respuesta"><span class="fa fa-plus"></span>&nbsp; Agregar Medio
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <table id="tblMediosRespuesta"
                                                       data-toggle="tblMediosRespuesta"
                                                       data-show-footer="true"
                                                       data-mobile-responsive="true"
                                                       data-locale="es-MX"
                                                       data-show-export="false"
                                                       data-pagination="true"
                                                       data-side-pagination="server"
                                                       data-page-size="20"
                                                       data-search="false"
                                                       data-show-toggle="false"
                                                       data-striped="true"
                                                       data-resizable="true"
                                                       data-click-to-select="false"
                                                       data-sort-name="ID_MEDIO_RESPUESTA"
                                                       data-sort-order="asc"
                                                       data-show-refresh="false"
                                                       data-fixed-columns="false"
                                                       data-fixed-number="0"
                                                       data-advanced-search="false"
                                                       data-search-on-enter-key="false"
                                                       data-show-pagination-switch="false"
                                                       data-pagination-h-align="left"
                                                       data-smart-display="true"
                                                       data-cache="false"
                                                       class="table table-bordered table-hover table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="ID_MEDIO_RESPUESTA"  data-sortable="false">ID</th>
                                                        <th data-field="MEDIO" data-sortable="false">DESCRIPCIÓN</th>
                                                        <th data-field="CANTIDAD" data-sortable="false">CANTIDAD</th>
                                                        <th data-field="IMPORTE" data-sortable="false" data-formatter="general.formatoMoneda"  data-align="center" data-footer-formatter="solicitudes.totalFormatter">IMPORTE</th>
                                                        <th data-sortable="false" data-align="center" data-formatter="solicitudes.mediosFormatter" data-width="100">ACCIONES</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title panel-center">DOCUMENTOS ANEXOS </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <div class="form-group pull-left" style="margin-top: 10px; margin-bottom: 10px;">
                                                    <button id="btnAgregarDocumento" type="button" class="btn btn-success" data-toggle="tooltip"
                                                            data-placement="top" title="Agregar Documento"><span class="fa fa-plus"></span>&nbsp; Agregar Documento
                                                    </button>
                                                </div>
                                                <table id="tblDocumentos"
                                                       data-mobile-responsive="true"
                                                       data-locale="es-MX"
                                                       data-height="500"
                                                       data-pagination="true"
                                                       data-side-pagination="server"
                                                       data-page-size="20"
                                                       data-search="false"
                                                       data-show-toggle="false"
                                                       data-striped="true"
                                                       data-resizable="true"
                                                       data-sort-name="ID_DOCUMENTO"
                                                       data-sort-order="asc"
                                                       data-show-refresh="false"
                                                       data-fixed-columns="false"
                                                       data-fixed-number="0"
                                                       data-advanced-search="false"
                                                       data-search-on-enter-key="false"
                                                       data-show-pagination-switch="false"
                                                       data-pagination-h-align="left"
                                                       data-smart-display="true"
                                                       data-cache="false"
                                                       class="table table-bordered table-hover table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="NUMROW" data-align="center" data-sortable="true" data-formatter="solicitudes.numRowFormatter"  data-width="100">NO. DOCUMENTO</th>
                                                        <th data-field="NOMBRE" data-sortable="true">NOMBRE</th>
                                                        <th data-field="EXTENSION" data-sortable="true">EXTENSIÓN</th>
                                                        <th data-sortable="false" data-align="center" data-width="200" data-formatter="solicitudes.documentoActionFormatter">ACCIONES</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="checkbox-aviso" data-fv-not-empty="true"
                                                       data-fv-not-empty___message="The size is required" > He leído y acepto el
                                                <a href="http://www.queretaro.gob.mx/transparencia/detalledependencia.aspx?q=YhT5iDRJbDBFZgzkrdkbbB9QcGciZxDMaaDIWcNrtiH8U3m369oRtGHPavd+iRHIhYWJoMhwywBHDEO3vyd1YmbgKk9i3ppSEOhaBwZoGKs3xPnwIRatlunwZe0PqHg5EdVUJrnEq+qPZrmNcxTDugKvZkIusI6hbqdz8a1pEm6FaYp35jALpjzMu+D4e7xzYcggg3omeFwfJQCt6VZO8Z18EdHxAL8NAtXhsD1zzpW2+6A0Ex3AJ5n2mtH18ZAh" target="_blank">
                                                    Aviso de Privacidad </a><br> La Unidad de Transparencia del Poder Ejecutivo del Estado de Querétaro, con domicilio en 5 de mayo esq.
                                                Luis Pasteur, Centro Histórico, C.P. 76000, Santiago de Querétaro, Qro. es la responsable del tratamiento de los
                                                datos personales que nos proporcione en el formato de Solicitud para el ejercicio de los derechos ARCO (Acceso,
                                                Rectificación, Cancelación u Oposición), conforme a la Constitución Política de los Estados Unidos Mexicanos, la Ley de
                                                Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de Querétaro, los Lineamientos Generales
                                                de Protección de Datos Personales para el Sector Público y demás normatividad que resulte aplicable.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="6LcNuogUAAAAALzgsYbh2iuyvplMjl7DWbV8kQbD" data-fv-not-empty="true"></div>
                                    </div>
                                    </div>
                                    <div class="actions pull-right" style="padding-top: 20px;">
                                        <button type="button" class="btn btn-success btn-next btn-lg" data-last="Finalizar">&nbsp; Siguiente</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a id="scrolltop"></a><!-- ScrollTop -->
                </div>
            </div>
        </div> <!-- end row -->
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
    {{ javascript_include('js/jquery/select2/select2.min.js') }}
    {{ javascript_include('js/jquery/select2/language/es.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-datetimepicker.min.js') }}
    {{ javascript_include('js/bootstrap/sweetalert.js') }}
    {{ javascript_include('js/wizard/fuelux.min.js') }}
    {{ javascript_include('js/jquery/formValidation.min.js') }}
    {{ javascript_include('js/jquery/formValidation/framework/bootstrap.js') }}
    {{ javascript_include('js/jquery/formValidation/language/es_ES.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/editable/bootstrap-table-editable.js') }}
    {{ javascript_include('css/bootstrap3-editable/js/bootstrap-editable.min.js') }}
    {{ javascript_include('js/bootstrap/fileinput/fileinput.js') }}
    {{ javascript_include('js/bootstrap/fileinput/locales/es.js') }}
    {{ javascript_include('js/jquery/mask/jquery.mask.js') }}
    {{ javascript_include('js/jquery/jquery.fileDownload.js') }}
    {{ javascript_include('js/jquery/multi.min.js') }}
    {{ javascript_include('js/extra/iCheck/icheck.min.js') }}
    {{ javascript_include('js/views/registro.js') }}

</body>
</html>

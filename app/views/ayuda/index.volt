{# ayuda/login.volt #}

{% extends "templates/base_admin.volt" %}

{% block head %}
    {{ stylesheet_link('css/bootstrap/bootstrap.vertical-tabs.css') }}
{% endblock %}

{% block content %}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <span>Ayuda</span>
                <small>Consultar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}"><i class="fa fa-home"></i> SAIDA - Sistema de Gestión de Solicitudes</a></li>
                <li class="active">Ayuda</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div  class="col-md-12">
                            <div class="col-lg-3 col-md-2 col-xs-12">
                                <ul class="nav nav-tabs tabs-left" id="#accordion">
                                    <li class="active"><a href="#Tab-home" data-toggle="tab"><i class="fa fa-home"></i> &nbsp; Inicio</a></li>
                                    <li>
                                        <a data-toggle="collapse" data-parent="#collapse-solicitudes" href="#collapse-sol" aria-expanded="false" class="collapsed">
                                            <i class="fa fa-lock"></i> &nbsp; Solicitudes <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                        </a>
                                        <div id="collapse-sol" class="collapse">
                                            <ul class="nav nav-tabs tabs-left">
                                                <li><a href="#Tab-sai" data-toggle="tab"><i class="fa fa-circle-o"></i> &nbsp;Solicitudes SAI</a></li>
                                                <li><a href="#Tab-arco" data-toggle="tab"><i class="fa fa-circle-o"></i> &nbsp;Solicitudes ARCO</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="#Tab-solicitantes" data-toggle="tab"><i class="fa fa-users"></i> &nbsp; Solicitantes</a></li>
                                    <li><a href="#Tab-documentos" data-toggle="tab"> <i class="fa fa-folder"></i> &nbsp; Documentos</a></li>
                                    <li>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-admin" aria-expanded="false" class="collapsed tabs-disable">
                                            <i class="fa fa-cogs"></i> &nbsp; Administración <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                        </a>
                                        <div id="collapse-admin" class="collapse">
                                            <ul class="nav nav-tabs tabs-left">
                                                <li>
                                                    <a data-toggle="collapse" data-parent="#collapse-admin" href="#collapse-permisos" aria-expanded="false" class="collapsed">
                                                        <i class="fa fa-lock"></i> &nbsp;Permisos <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                    </a>
                                                    <div id="collapse-permisos" class="collapse">
                                                        <ul class="nav nav-tabs tabs-left">
                                                            <li><a href="#Tab-usuarios" data-toggle="tab"><i class="fa fa-users"></i> &nbsp;Usuarios</a></li>
                                                            <li><a href="#Tab-roles" data-toggle="tab"><i class="fa fa-address-card"></i> &nbsp;Roles</a></li>
                                                            <li><a href="#Tab-recursos" data-toggle="tab"><i class="fa fa-list-alt"></i> &nbsp;Recursos</a></li>
                                                            <li><a href="#Tab-acciones" data-toggle="tab"><i class="fa fa-tasks"></i> &nbsp;Acciones</a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li><a href="#Tab-dependencias" data-toggle="tab"><i class="fa fa-university"></i> &nbsp;Dependencias</a></li>
                                                <li>
                                                    <a data-toggle="collapse" data-parent="#collapse-admin" href="#collapse-catalogo" aria-expanded="false" class="collapsed">
                                                        <i class="fa fa-lock"></i> &nbsp; Catálogo <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                    </a>
                                                    <div id="collapse-catalogo" class="collapse">
                                                        <ul class="nav nav-tabs tabs-left">
                                                            <li><a href="#Tab-temas" data-toggle="tab"><i class="fa fa-circle-o"></i> &nbsp;Temas</a></li>
                                                            <li><a href="#Tab-subtemas" data-toggle="tab"><i class="fa fa-circle-o"></i> &nbsp;Subtemas</a></li>
                                                            <li><a href="#Tab-titulos" data-toggle="tab"><i class="fa fa-circle-o"></i> &nbsp;Títulos</a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li><a href="#Tab-dias" data-toggle="tab"><i class="fa fa-calendar-o"></i> &nbsp;Días Inhábiles</a></li>
                                                <li><a href="#Tab-parametros" data-toggle="tab"><i class="fa fa-cog"></i> &nbsp;Parámetros</a></li>
                                                <li>
                                                    <a data-toggle="collapse" data-parent="#collapse-admin" href="#collapse-flujo" aria-expanded="false" class="collapsed">
                                                        <i class="fa fa-sitemap"></i> &nbsp; Flujo de Solicitud <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                    </a>
                                                    <div id="collapse-flujo" class="collapse">
                                                        <ul class="nav nav-tabs tabs-left">
                                                            <li><a href="#Tab-flujos" data-toggle="tab"><i class="fa fa-sitemap"></i> &nbsp;Flujos</a></li>
                                                            <li><a href="#Tab-condiciones" data-toggle="tab"><i class="fa fa-code"></i> &nbsp;Condiciones</a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-lg-9 col-xs-12">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="Tab-home">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Bienvenido a <span class="text-blue">SAIDA</span></h2></div>
                                        <div class="content container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <section class="content-max-width">
                                                        <h3 class="subtitulo">Ingreso al sistema</h3>
                                                        <p>La pantalla de Login, debe mostrar un recuadro con los logos correspondientes a Gobierno del Estado de Querétaro,
                                                            y en la parte inferior los datos de inicio de sesión que son requeridos para entrar al sistema en cuestión: </p>
                                                            <ul>
                                                                <li>Usuario: Nombre de usuario dado de alta en base de datos con los permisos adecuados al usuario.</li>
                                                                <li>Contraseña: Contraseña que se dio de alta y se asoció al usuario, está se encuentra encriptada en hash.</li>
                                                            </ul>
                                                        <p>Se ingresan y validan los datos previamente mencionados, mediante la conexión al datasource de la base de datos
                                                            propia del sistema, si los datos son correctos nos envía a la pantalla de inicio.</p>
                                                        {{ image('img/manual/login.png', 'alt': 'Imagen principal del sistema' , 'style': ' margin: 0 auto;' ,'class': ' img-responsive') }}
                                                        <h3 class="subtitulo">Acceso al Sistema</h3>
                                                        <p>El ingreso a SAIDA se realizará desde la siguiente dirección electrónica http://10.16.8.62/saida/login/ en la cual, una
                                                            vez que usted se autentifique como usuario autorizado (director de dependencia y
                                                            responsable de la administración del sistema), podrá ingresar al sistema.</p>
                                                        <p> A continuación se muestra la página de inicio del sistema:</p>
                                                        {{ image('img/manual/home.png', 'alt': 'Imagen principal del sistema' , 'style': 'margin: 0 auto;','class': ' img-responsive') }}
                                                        <h3 class="subtitulo">Menú principal</h3>
                                                        <p>Una vez que ha ingresado al sistema, se muestra el Menú Principal que contiene
                                                            cinco opciones: Inicio, Solicitudes, Solicitantes, Documentosv y Ayuda.</p>
                                                        {{ image('img/manual/menu.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto; width: 20%;','class':' img-responsive') }}
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-sai">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">¿Cómo registrar una nueva solicitud SAI?</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder a las solicitudes de acceso a la información nos direccionamos en el menú lateral izquierdo, como se muestra a continuación.</p>
                                                {{ image('img/manual/menu_sai.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto; width: 20%;','class':' img-responsive') }}
                                                <p>Para poder agregar una nueva solicitud es importante seleccionar en el menú lateral la opción nueva solicitud.</p>
                                                {{ image('img/manual/nueva_sai.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto; width: 20%;','class':' img-responsive') }}
                                                <p>Una vez hecho clic en la opción de Nueva solicitud, se presenta una pantalla con el formulario de registro de información específica de su solicitud. </p>
                                                <p>En la parte inicial están los datos del solicitante donde validamos si se requiere los datos del solicitante o solo el seudónimo o se requiere anonimato en la solicitud.</p>
                                                {{ image('img/manual/modal_sai.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Cuando se desea que el solicitante tenga un seudónimo en lugar de mostrar su nombre se debe seleccionar la siguiente opción.</p>
                                                {{ image('img/manual/modal_sai_1.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Si se desea que el solicitante sea anónimo se debe seleccionar la opción de anónimo.</p>
                                                {{ image('img/manual/modal_sai_2.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Si se desea agregar datos de contacto como la dirección y teléfonos se debe seleccionar el campo.</p>
                                                {{ image('img/manual/modal_sai_3.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Cuando un ciudadano desea que su solicitud sea ocultos para las dependencias se llena el registro en la parte baja del registro.</p>
                                                {{ image('img/manual/modal_sai_4.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Para continuar con el registro de la solicitud se da clic en el botón siguiente en la parte top del formulario.</p>
                                                {{ image('img/manual/modal_sai_5.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Pasamos a la etapa siguiente del formulario donde se registra la información de la solicitud. </p>
                                                <p>Se puede o no agregar antecedente a la solicitud, también como marcar o desmarcar si se desea que se muestre el  antecedente a las dependencias.</p>
                                                {{ image('img/manual/modal_sai_6.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Cuando se desea agrupar las peticiones del ciudadano en solo un texto se registran los siguientes campos.</p>
                                                {{ image('img/manual/modal_sai_7.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Si se desea dividir la solicitud marcamos el campo para dividir las preguntas:</p>
                                                {{ image('img/manual/modal_sai_8.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Para agregar un tema se debe dar clic en el botón agregar para mostrar el modal de registro.</p>
                                                {{ image('img/manual/modal_sai_9.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Nos muestra el modal para registrar cada una de las preguntas, validamos que se puedan agregar, modificar y eliminar las preguntas.</p>
                                                {{ image('img/manual/modal_sai_10.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se puede o no agregar observaciones para la unidad de transparencia.</p>
                                                {{ image('img/manual/modal_sai_11.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Lo siguiente es agregar la relación de la solicitud con el catálogo de temas.</p>
                                                {{ image('img/manual/modal_sai_12.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Validamos que se agreguen los documentos anexos a la solicitud, se eliminen y se pueda actualizar el documento.</p>
                                                {{ image('img/manual/modal_sai_13.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Cuando se termina de llenar el formulario nos vamos a la parte top y le damos clic en el botón finalizar.</p>
                                                {{ image('img/manual/modal_sai_14.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p> Nos muestra el mensaje de que la solicitud ha sigo agregada correctamente.</p>
                                                {{ image('img/manual/modal_sai_15.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-arco">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">¿Cómo registrar una nueva solicitud ARCO?</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder a las solicitudes ARCO nos direccionamos en el menú lateral izquierdo, como se muestra a continuación.</p>
                                                {{ image('img/manual/menu_arco.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto; width: 20%;','class':' img-responsive') }}
                                                <p>Para poder agregar una nueva solicitud es importante seleccionar en el menú lateral la opción nueva solicitud.</p>
                                                {{ image('img/manual/nueva_arco.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto; width: 20%;','class':' img-responsive') }}
                                                <p>En la parte inicial están los datos personales del titular con el objetivo de saber a quién se aplicara los derechos.</p>
                                                {{ image('img/manual/modal_arco_1.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se agregan los datos de acreditación de la identidad del titular</p>
                                                {{ image('img/manual/modal_arco_2.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se agregan los datos del interesado en que se ejerza el derecho ARCO del titular.</p>
                                                {{ image('img/manual/modal_arco_3.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se agregan los documentos de acreditación del representante o tutor que realiza la solicitud.</p>
                                                {{ image('img/manual/modal_arco_4.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Si se desea agregar datos de contacto como la dirección y teléfonos se debe seleccionar el campo.</p>
                                                {{ image('img/manual/modal_arco_5.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Para continuar con el registro de la solicitud se da clic en el botón siguiente en la parte top del formulario.</p>
                                                {{ image('img/manual/modal_arco_6.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Pasamos a la etapa siguiente del formulario donde se registra la información de la solicitud. </p>
                                                <p>Se puede o no agregar antecedente a la solicitud, también como marcar o desmarcar si se desea que se muestre el  antecedente a las dependencias.</p>
                                                {{ image('img/manual/modal_arco_7.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Cuando se desea agrupar las peticiones del ciudadano en solo un texto se registran los siguientes campos.</p>
                                                {{ image('img/manual/modal_arco_8.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Si se desea dividir la solicitud marcamos el campo para dividir las preguntas:</p>
                                                {{ image('img/manual/modal_arco_9.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Para agregar un tema se debe dar clic en el botón agregar para mostrar el modal de registro.</p>
                                                {{ image('img/manual/modal_arco_10.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Nos muestra el modal para registrar cada una de las preguntas, validamos que se puedan agregar, modificar y eliminar las preguntas.</p>
                                                {{ image('img/manual/modal_arco_11.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se puede o no agregar observaciones para la unidad de transparencia.</p>
                                                {{ image('img/manual/modal_arco_12.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Seleccionamos el derecho ARCO que se desea ejercer.</p>
                                                {{ image('img/manual/modal_arco_13.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Lo siguiente es agregar la relación de la solicitud con el catálogo de temas.</p>
                                                {{ image('img/manual/modal_arco_14.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Validamos que se agreguen los documentos anexos a la solicitud, se eliminen y se pueda actualizar el documento.</p>
                                                {{ image('img/manual/modal_arco_15.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Cuando se termina de llenar el formulario nos vamos a la parte top y le damos clic en el botón finalizar.</p>
                                                {{ image('img/manual/modal_arco_16.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p> Nos muestra el mensaje de que la solicitud ha sigo agregada correctamente.</p>
                                                {{ image('img/manual/modal_arco_17.png', 'alt': 'Imagen donde se muestra el menú' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-solicitantes">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Solicitantes</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Administración del catálogo de solicitantes,
                                                    al igual que en los previos catálogos en esta administración se
                                                    permite visualizar datos personales, o eliminar los que ya no sean requeridos en base a las solicitudes ARCO. </p>
                                                {{ image('img/manual/solicitantes.png', 'alt': 'Tabla de solicitantes' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <h3 class="subtitulo">Visualizar Solicitante</h3>
                                                <p>Para visualizar la información rápida del solicitante es necesario dar
                                                    clic en el botón información rápida, donde se muestra toda la información relacionada con el solicitante seleccionado.</p>
                                                {{ image('img/manual/modal_solicitantes.png', 'alt': 'Registro de solicitantes' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <h3 class="subtitulo">Ver perfil Solicitante</h3>
                                                <p>Para ver el perfil completo del solicitante es necesario dar clic en
                                                    el botón perfil del solicitante, nos muestra una página con toda la información del solicitante.</p>
                                                {{ image('img/manual/solicitantes_datos.png', 'alt': 'Datos del solicitante' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se muestran las solicitudes de acceso a la información que el solicitante ha ingresado.</p>
                                                {{ image('img/manual/solicitantes_sai.png', 'alt': 'Solicitudes sai', 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se muestran las solicitudes ARCO que el solicitante ha ingresado.</p>
                                                {{ image('img/manual/solicitantes_arco.png', 'alt': 'Solicitudes arco', 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se muestra el listado de comentarios en base al solicitante.</p>
                                                {{ image('img/manual/solicitantes_comentarios.png', 'alt': 'Comentarios del solicitante' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Se muestra el historial de cambios en el solicitante.</p>
                                                {{ image('img/manual/solicitantes_historial.png', 'alt': 'Historial del solicitante' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <h3 class="subtitulo">Eliminar Solicitante</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta
                                                    acción se solicita se confirme que en realidad se desea eliminar los
                                                    datos personales del solicitante, nos abre una ventana emergente,
                                                    y en caso de requerir la eliminación de los datos personales del solicitante seleccionado, elegimos “SI”, en el caso contrario se selecciona “NO”</p>
                                                {{ image('img/manual/solicitantes_eliminar.png', 'alt': 'Eliminar solicitante' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                                <p>Es importante agregar la solicitud ARCO que se desea ejercer para eliminar los datos personales del solicitante, además de un comentario.</p>
                                                {{ image('img/manual/solicitantes_elimina.png', 'alt': 'Eliminar Datos solicitante' , 'style':'margin: 0 auto;','class':' img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-documentos">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Documentos</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Administración del catálogo de documentos (normativas y lineamientos),
                                                    al igual que en los previos catálogos en esta administración se permite
                                                    agregar documentos, modificar, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/menu_doc.png', 'alt':'Menus del documento' , 'style':'margin: 0 auto; width: 20%;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Documento</h3>
                                                <p>Para agregar/modificar un documento, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/agregar_doc.png', 'alt':'Imagen principal del sistema' , 'style':'margin: 0 auto; width: 20%;','class':'img-responsive') }}
                                                <p>Se hace la selección del documento en la búsqueda de los archivos del equipo.</p>
                                                {{ image('img/manual/documento.png', 'alt':'Imagen principal del sistema' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Se hace la selección del documento en la búsqueda de los archivos del equipo.</p>
                                                {{ image('img/manual/select_doc.png', 'alt':'Seleccionar archivos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}

                                                <h3 class="subtitulo">Eliminar Documento</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta acción se
                                                    solicita se confirme que en realidad se desea eliminar el documento,
                                                    nos abre una ventana emergente, y en caso de requerir la eliminación del documento seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_doc.png', 'alt':'Borrar el documento' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Descargar Documento</h3>
                                                <p>Para la descarga se da clic en el botón de Descargar documento,
                                                    nos muestra el modal de descarga para realizar la descarga o guardar documento</p>
                                                {{ image('img/manual/descarga_doc.png', 'alt':'Descargar el documento' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-usuarios">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Usuarios</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder a los usuarios nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_usuario.png', 'alt':'Menus de los usuarios' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de usuarios, al igual que en los previos
                                                    catálogos en esta administración se permite agregar nuevos usuarios, modifica, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/usuarios.png', 'alt':'Tabla con los usuarios','style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Usuarios</h3>
                                                <p>Para agregar/modificar un nuevo usuario, la información solicitada es la siguiente:</p>
                                                {{ image('img/manual/modal_usuario.png', 'alt':'Modal editar usuarios' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Usuario:</b>  Se requiere agregar el nombre de usuario.</li>
                                                    <li><b>Nombre:</b>  El nombre del usuario asignado al usuario</li>
                                                    <li><b>Correo:</b> Correo asignado al usuario, o bien algún correo de contacto.</li>
                                                    <li><b>Password:</b> Contraseña con la cual se hará la validación al inicio de sesión del sistema.</li>
                                                    <li><b>Roles:</b> Se muestra una tabla de roles, en la cual se van a enlistar
                                                        los roles asignados al usuario, para agregar un rol se requiere generar
                                                        una búsqueda por palabras clave, se enlistan las opciones, se selecciona
                                                        y se da clic en “Agregar”, para agregarse a la tabla de roles posterior.</li>
                                                </ol>
                                                {{ image('img/manual/modal_usuario_1.png', 'alt':'Modal editar usuario' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>En la tabla se enlista el rol seleccionado con los datos de su descripción,
                                                    y de lado derecho se muestra el botón de eliminar, está acción nos permite
                                                    desasociar el rol al usuario, y se elimina de la tabla.
                                                    De igual manera que con los usuarios, se tiene una administración del
                                                    catálogo de roles, por lo que si se requiere generar un nuevo rol
                                                    para asociarlo al usuario, primeramente se debe agregar en este catálogo,
                                                    para que se muestre en las opciones.
                                                </p>
                                                <ol>
                                                    <li><b>Dependencias.</b> Se muestra la tabla correspondiente a las dependencias,
                                                        en esta se van a enlistar las dependencias que estarán asociadas al usuario
                                                        que se va a generar, para agregar una dependencia se realiza una búsqueda
                                                        mediante caracteres con el nombre de la dependencia, con lo cual se van a
                                                        enlistar las opciones viables, se selecciona la opción deseada,
                                                        y esta se agrega a la tabla. Se podrá obtener y asignar cualquier nivel de la jerarquía.</li>
                                                    {{ image('img/manual/modal_usuario_2.png', 'alt':'Modal editar usuario' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                </ol>
                                                <p>En la tabla se enlistan las dependencias que se asociarán al usuario,
                                                    y al igual que con los roles se tiene la opción de eliminar alguna de estas, que no se requiere asociar al usuario.</p>
                                                <p>Para generar el nuevo usuario se da clic en “Guardar”, con esto el usuario se enlista en la tabla
                                                    que se muestra en la pantalla principal de administración del catálogo de usuarios, se agrega
                                                    el usuario en base de datos, y desde la pantalla se permite realizar modificaciones a la
                                                    información asociada a cada uno de los usuarios, para esto nos abre la ventana emergente
                                                    como  la que se muestra al agregar un nuevo usuario, con la información correspondiente a este,
                                                    se generan las modificaciones requeridas y se guardan al dar clic en el botón de “Guardar”.</p>
                                                {{ image('img/manual/guardar_usuario.png', 'alt':'Modal guardar el usuario' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Eliminar Usuarios</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar,
                                                    para esta acción se solicita se confirme que en realidad se
                                                    desea eliminar el usuario, nos abre una ventana emergente,
                                                    y en caso de requerir la eliminación del usuario seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_usuario.png', 'alt':'Modal borrar el usuario' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-roles">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Roles</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder a la administración de roles nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_rol.png', 'alt':'Menus de los roles' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de roles, al igual que en los previos
                                                    catálogos en esta administración se permite agregar nuevos roles, modifica, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/roles.png', 'alt':'Tabla con los roles','style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Roles</h3>
                                                <p>Para agregar/modificar un nuevo rol, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_rol.png', 'alt':'Modal editar recursos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Rol:</b>  El nombre con el cual se va a definir el nuevo rol a generar.</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción del nuevo rol, de acuerdo al rol que tendrá en el sistema.</li>
                                                    <li><b>Recurso:</b> Para generar un nuevo rol, se requiere se le asignen los recursos a los cuales tendrá acceso,
                                                        es decir las pantallas del sistema a las que va a poder acceder al tener asignado dicho rol,
                                                        para agregar un nuevo recurso se genera una búsqueda por caracteres clave, se enlistan las opciones y se selecciona el recurso deseado.</li>
                                                </ol>
                                                {{ image('img/manual/modal_rol_1.png', 'alt':'Modal editar recursos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Menú del sistema:</b>  Para generar un nuevo rol, se requiere se le asignen los ítems del menú a los cuales tendrá acceso,
                                                        es decir las pantallas del sistema a las que va a poder acceder al tener asignado dicho rol, para agregar un nuevo recurso
                                                        se genera una búsqueda por caracteres clave, se enlistan las opciones y se selecciona el recurso deseado.</li>
                                                </ol>
                                                {{ image('img/manual/modal_rol_2.png', 'alt':'Modal editar recursos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Eliminar Roles</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta acción
                                                    se solicita se confirme que en realidad se desea eliminar el rol,
                                                    nos abre una ventana emergente, y en caso de requerir la eliminación del rol seleccionado, elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_rol.png', 'alt':'Modal borrar el rol' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-recursos">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Recursos</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder a los recursos nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_recurso.png', 'alt':'Menus de los recursos' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>En la administración del catálogo de recursos se van a guardar todas las páginas o pantallas que van a formar parte del sistema. </p>
                                                {{ image('img/manual/recursos.png', 'alt':'Tabla con los recursos' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Recursos</h3>
                                                <p>Para agregar/modificar un nuevo recurso, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_recurso.png', 'alt':'Modal editar recursos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Recurso:</b> El nombre con el cual se va a definir el nuevo recurso a generar.</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción del recurso.</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar Recursos</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar,
                                                    para esta acción se solicita se confirme que en realidad se desea
                                                    eliminar la acción, nos abre una ventana emergente, y en caso de
                                                    requerir la eliminación de la acción seleccionado, elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_recurso.png', 'alt':'Modal borrar el recurso' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-acciones">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Acciones</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder a las acciones nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_accion.png', 'alt':'Menus de la accion' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de acciones, al igual que en los previos
                                                    catálogos en esta administración se permite agregar nuevas acciones,
                                                    modifica, consultar o eliminar las que ya no sean requeridas. </p>
                                                {{ image('img/manual/acciones.png', 'alt':'Tabla con las acciones' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Acciones</h3>
                                                <p>Para agregar/modificar una nueva acción, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_accion.png', 'alt':'Modal editar acciones' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Acción:</b> El nombre con el cual se va a definir la nueva acción a generar.</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción de la acción.</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar Acciones</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar,
                                                    para esta acción se solicita se confirme que en realidad se desea
                                                    eliminar la acción, nos abre una ventana emergente, y en caso de
                                                    requerir la eliminación de la acción seleccionado, elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_accion.png', 'alt':'Modal borrar la accion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-dependencias">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Dependencias</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder a la administración de las dependencias nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_dependencia.png', 'alt':'Menus del tema' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de dependencias, al igual que en los previos catálogos en esta administración se permite consultar todas las dependencias registradas. </p>
                                                {{ image('img/manual/dependencias.png', 'alt':'Menus del tema' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-temas">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Temas</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder al catálogo de temas nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_tema.png', 'alt':'Menus del tema' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de temas, al igual que en los previos
                                                    catálogos en esta administración se permite agregar nuevo tema, modifica, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/temas.png', 'alt':'Tabla con los temas' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Temas </h3>
                                                <p>Para agregar/modificar un nuevo tema, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_tema.png', 'alt':'Modal editar tema' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Tema:</b> El nombre con el cual se va a definir el nuevo tema a generar.</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción del tema.</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar Temas</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta acción se solicita se confirme que en realidad se
                                                    desea eliminar el tema, nos abre una ventana emergente, y en caso de requerir la eliminación del tema seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_tema.png', 'alt':'Modal borrar el tema' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-subtemas">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Subtemas</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder al catálogo de subtemas nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_subtema.png', 'alt':'Menus del subtema' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de subtemas, al igual que en los previos
                                                    catálogos en esta administración se permite agregar nuevo subtema, modifica, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/subtemas.png', 'alt':'Tabla con los subtema' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Subtemas </h3>
                                                <p>Para agregar/modificar un nuevo subtema, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_subtema.png', 'alt':'Modal editar subtema' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Subtema:</b> El nombre con el cual se va a definir el nuevo subtema a generar.</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción del subtema.</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar subtemas</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta acción se solicita se confirme que en realidad se
                                                    desea eliminar el subtema, nos abre una ventana emergente, y en caso de requerir la eliminación del subtema seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_subtema.png', 'alt':'Modal borrar el subtema' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-titulos">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Títulos</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder al catálogo de títulos nos direccionamos en el menú lateral y seleccionamos la siguiente opción:</p>
                                                {{ image('img/manual/menu_titulo.png', 'alt':'Menus del titulo' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de títulos, al igual que en los previos
                                                    catálogos en esta administración se permite agregar nuevo título, modifica, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/titulos.png', 'alt':'Tabla con los titulo' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar títulos </h3>
                                                <p>Para agregar/modificar un nuevo título, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_titulo.png', 'alt':'Modal editar titulo' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Titulo:</b> El nombre con el cual se va a definir el nuevo título a generar.</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción del título.</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar títulos</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta acción se solicita se confirme que en realidad se
                                                    desea eliminar el título, nos abre una ventana emergente, y en caso de requerir la eliminación del título seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_titulo.png', 'alt':'Modal borrar el subtema' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-dias">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Días Inhábiles</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder al catálogo de días inhábiles nos direccionamos en el menú lateral y seleccionamos lo siguiente:</p>
                                                {{ image('img/manual/menu_dia.png', 'alt':'Modal borrar el parametro' , 'style':'margin: 0 auto; width: 40%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de días inhábiles, al igual que en los
                                                    previos catálogos en esta administración se permite agregar nuevo día inhábil,
                                                    modifica, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/dias.png', 'alt':'Modal borrar el parametro' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Días Inhábiles </h3>
                                                <p>Para agregar/modificar un nuevo día inhábil, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_dia.png', 'alt':'Modal borrar el parametro' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Fecha:</b> Selección la fecha del día inhábil</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción del día inhábil</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar Días Inhábiles</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta acción se
                                                    solicita se confirme que en realidad se desea eliminar el día inhábil,
                                                    nos abre una ventana emergente, y en caso de requerir la eliminación del
                                                    día inhábil seleccionado, elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_dia.png', 'alt':'Modal borrar el parametro' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-parametros">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Parámetros</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder al catálogo de parámetros nos direccionamos en el menú lateral y seleccionamos lo siguiente:</p>
                                                {{ image('img/manual/menu_parametro.png', 'alt':'Menus del parametro' , 'style':'margin: 0 auto; width: 40%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de parámetros, al igual que en los previos
                                                    catálogos en esta administración se permite agregar nuevos parámetros,
                                                    modificar, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/parametros.png', 'alt':'Tabla donde se muestran los parametros' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Parámetro</h3>
                                                <p>Para agregar/modificar un nuevo parámetro, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/parametro.png', 'alt':'Modal de parametros' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Nombre:</b> Se agrega el nombre del parámetro</li>
                                                    <li><b>Valor:</b> Se agrega el valor del parámetro</li>
                                                    <li><b>Descripción:</b> Se agrega una breve descripción del parámetro.</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar Parámetro</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar,
                                                    para esta acción se solicita se confirme que en realidad se desea eliminar el parámetro,
                                                    nos abre una ventana emergente, y en caso de requerir la eliminación del parámetro seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_parametro.png', 'alt':'Modal borrar el parametro' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-flujos">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Flujos</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder al catálogo de flujos nos direccionamos en el menú lateral y seleccionamos lo siguiente:</p>
                                                {{ image('img/manual/menu_flujo.png', 'alt':'Menus del flujo' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de flujo, al igual que en los previos catálogos
                                                    en esta administración se permite agregar nuevos flujos, modificar, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/flujos.png', 'alt':'tabla de flujos' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Modificar Flujo</h3>
                                                <p>Para modificación de un flujo, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_flujo.png', 'alt':'Modal de flujos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Nombre:</b> Se agrega el nombre del flujo.</li>
                                                    <li><b>Descripción:</b>Se agrega una breve descripción del flujo.</li>
                                                </ol>
                                                <h3 class="subtitulo">Rechazar Flujo</h3>
                                                <p>Para rechazar se da clic en el botón de rechazar,
                                                    para esta acción se solicita se confirme que en realidad se desea rechazar el flujo,
                                                    nos abre una ventana emergente, y en caso de requerir la eliminación del parámetro seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_flujo.png', 'alt':'Rechazar el flujos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Visualizar Flujo</h3>
                                                <p>Para visualizar el mapa del flujo completo es necesario dar clic en el botón ver flujo, nos muestra el flujo completo seleccionado.</p>
                                                {{ image('img/manual/visualizar_flujo.png', 'alt':'Visualizar el flujos' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Actualizar Flujo</h3>
                                                <p>Para actualizar las etapas del flujo es necesario dar clic en el botón actualizar,
                                                    donde se podrá editar el flujo, para esta acción se solicita se confirme que en
                                                    realidad se desea actualizar el flujo, nos abre una ventana emergente,
                                                    y en caso de requerir la actualización del parámetro seleccionado, elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/actualizar_flujo.png', 'alt':'Visualizar el flujos' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <p>Si deseamos actualizar el flujo y este ha sido aprobado anteriormente, nos hace una copia completa para el nuevo flujo dejando el anterior obsoleto.</p>
                                                {{ image('img/manual/actualizar_flujo_1.png', 'alt':'Visualizar el flujos' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar Etapa</h3>
                                                <p>Para agregar/modificar una nueva etapa, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_flujo.png', 'alt':'Modificar el flujos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Cuando una etapa es una nueva condición se agregan dos transacciones, dos pasos entre un sí y un no. </p>
                                                {{ image('img/manual/agregar_flujo_1.png', 'alt':'Modificar el flujos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Se agregan los plazos de cada estado, los plazos son los encargados de administrar las alertas de correo electrónico.</p>
                                                {{ image('img/manual/agregar_flujo_2.png', 'alt':'Modificar el flujos' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar Conexión</h3>
                                                <p>Para agregar/modificar una nueva conexión entre las etapas, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_conexion.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Seleccionamos la acción a realizar en cada conexión dependiendo de la etapa en la que se encuentra.</p>
                                                {{ image('img/manual/modal_conexion_1.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Seleccionamos la notificación que se desea prepara en caso de que la opción anterior sea preparar o notificar </p>
                                                {{ image('img/manual/modal_conexion_2.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Seleccionamos la etapa a la cual se conectara, esto con el objetivo de pasar de etapa en etapa.</p>
                                                {{ image('img/manual/modal_conexion_3.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Cuando una etapa es una condición se debe agregar dos conexiones una cuando SI se cumple y otra cuando NO se cumple la condición.</p>
                                                {{ image('img/manual/modal_conexion_4.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Para decirle a la conexión que sea cuando Si se cumple la condición es importante seleccionar la acción.</p>
                                                {{ image('img/manual/modal_conexion_5.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>En la opción de condición seleccionamos si es que ya hay una condición establecida previa.</p>
                                                <p>Para agregar la conexión cuando NO se cumple la condición es la siguiente.</p>
                                                {{ image('img/manual/modal_conexion_6.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <p>Se hace la selección de roles que podrán ver las conexiones por medio de botones.
                                                    Es importante agregar los roles de usuarios para hacer la validación de permisos dentro del sistema.</p>
                                                {{ image('img/manual/modal_conexion_7.png', 'alt':'Modificar la conexion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Tab-condiciones">
                                        <div class="col-md-12"><h2 class="content-max-width titulo">Condiciones</h2></div>
                                        <div class="row content container-fluid">
                                            <div class="col-md-12 content-max-width">
                                                <p>Para acceder al catálogo de condiciones nos direccionamos en el menú lateral y seleccionamos lo siguiente:</p>
                                                {{ image('img/manual/menu_condicion.png', 'alt':'Menus de la condicion' , 'style':'margin: 0 auto; width: 30%;','class':'img-responsive') }}
                                                <p>Administración del catálogo de condiciones en el flujo, al igual que
                                                    en los previos catálogos en esta administración se permite agregar
                                                    nuevas condiciones, modificar, consultar o eliminar los que ya no sean requeridos. </p>
                                                {{ image('img/manual/condiciones.png', 'alt':'Modal de las condiciones' , 'style':'margin: 0 auto;','class':'img-responsive') }}
                                                <h3 class="subtitulo">Agregar/Modificar Condición</h3>
                                                <p>Para agregar/modificar una nueva condición, la información requerida es la siguiente:</p>
                                                {{ image('img/manual/modal_condicion.png', 'alt':'Modal de las condiciones' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                                <ol>
                                                    <li><b>Nombre:</b> Se agrega el nombre de la condición</li>
                                                    <li><b>Flujo:</b> Seleccionamos el flujo al cual asignar la condición</li>
                                                    <li><b>Valor:</b> Se agrega el valor de la condición</li>
                                                    <li><b>Descripción:</b>Se agrega una breve descripción del parámetro.</li>
                                                </ol>
                                                <h3 class="subtitulo">Eliminar Condición</h3>
                                                <p>Para la eliminación se da clic en el botón de eliminar, para esta acción se solicita
                                                    se confirme que en realidad se desea eliminar la condición, nos abre una ventana
                                                    emergente, y en caso de requerir la eliminación de la condición seleccionado,
                                                    elegimos “SI”, en el caso contrario se selecciona “NO”.</p>
                                                {{ image('img/manual/borrar_condicion.png', 'alt':'Modal borrar la condicion' , 'style':'margin: 0 auto; width: 60%;','class':'img-responsive') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
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
    {{ javascript_include('js/bootstrap/bootstrap-table.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/locale/bootstrap-table-es-MX.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js') }}
    {{ javascript_include('js/bootstrap/bootstrap3-typeahead.min.js') }}
    {{ javascript_include('js/views/ayuda/ayuda.js') }}
{% endblock %}

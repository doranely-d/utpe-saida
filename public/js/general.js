/*
 * COPYRIGHT © 2021. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * SAIDA IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

//Declaración de Objeto
var general = {
    tooltip: null,
    contenidoCuerpo: null,
    base_url: null,
    validate_session: null,
    activar_notificaciones: null,
    tblSolicitudes: null,

    init: function () {
        //Inicilización de propiedades del objeto
        this.base_url = window.location.protocol + '//' + window.location.host + window.location.pathname.substring(0, window.location.pathname.indexOf('/', 2));
        this.tooltip = $('[data-toggle="tooltip"]');
       // this.validate_session = setInterval(this.session, (10 * 60 * 5000)); //Timoutperiod, Minutes, Milli seconds Revisa Sesión
        this.activar_notificaciones = setInterval(this.notificaciones, (10 * 60 * 50)); //activa las notificaciones de usuario

        //Funcionalidad
        this.tooltip.tooltip({
            container: 'body'
        });

        // *********************************    ACTIVAR MENU    ********************************************
        var url = window.location.href.split('&id=')[0];

        $('ul.sidebar-menu a').filter(function() {
            if(url.indexOf("perfil") > -1) {
                return this.href.split('&id=')[0] == document.referrer.split('&id=')[0];
            }else {
                return this.href.split('&id=')[0] == url;
            }
        }).parents().addClass('active');
        $('ul.treeview-menu a').filter(function() {
            if(url.indexOf("perfil") > -1) {
                return this.href.split('&id=')[0] == document.referrer.split('&id=')[0];
            }else {
                return this.href.split('&id=')[0] == url;
            }
        }).closest('.treeview').addClass('active');
        if ($('#contenidoCuerpo')) {
            this.contenidoCuerpo = $('#contenidoCuerpo');
        }
        // *********************************    END MENU    ********************************************

        //bootstrapTable resetView
        $('body').on('expanded.pushMenu collapsed.pushMenu', function () {
            $(".table").each(function (index) {
                if (typeof ($(this)[0].id) !== 'undefined' && $.trim($(this)[0].id) !== '') {
                    var idTable = $.trim($(this)[0].id);

                    setTimeout(function () {
                        $('#' + idTable).bootstrapTable('resetView');
                    }, 350);
                }
            });
        });
    },
    notify: function (title, message, type, progress) {
        var showProgressbar = (progress !== undefined) ? progress : false;

        $.notify({
            title: title,
            icon: 'glyphicon glyphicon-warning-sign',
            message: message
        },
        {
            newest_on_top: true,
            pos: 'top-right',
            element: 'body',
            delay: 6000,
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            },
            placement: {
                from: 'top'
            },
            showProgressbar: showProgressbar,
            type: type,
            z_index: 9999,
        });
    },
    block: function () {
        $.blockUI({
            message: '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%"><b>Espera por favor….</b></div>',
            baseZ: 99999,
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
    },
    unblock: function () {
        $.unblockUI();
    },

    session: function () {
        if (($(location).attr('href') !== general.base_url + '/index/index' || $(location).attr('href') !== general.base_url + '/') && $(location).attr('href') !== general.base_url) {
            $.ajax({
                type: 'GET',
                url: general.base_url + '/index/islogin',
                contentType: 'application/json; charset=utf-8',
                success: function (resultado) {
                    try {
                        if (resultado.estatus === 'success') {
                            if (!resultado.datos) {
                                clearInterval(general.validate_session);
                                bootbox.hideAll();
                                bootbox.alert({
                                    size: 'medium',
                                    message: '<b>¡La sesión ha terminado! Iníciala nuevamente.</b>',
                                    callback: function () {
                                        window.location.href = general.base_url + '/index/index';
                                    }
                                });
                            }
                        }
                    } catch (e) {
                        general.notify('<strong>Ocurrió un error!</strong><br/><br/>', 'Ocurrió un error en la verificación de la sesión.', 'danger', true);
                    }
                },
                error: function () {
                    general.notify('<strong>Ocurrió un error!</strong><br/><br/>', 'Ocurrió un error en la petición al servidor en la verificación de la sesión.', 'danger', true);
                }
            });
        } else {
            clearInterval(general.validate_session);
        }
    },
    obtenerParametro: function (name, url) {
        //obtenemos los parametros de la url del navegador
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"), results = regex.exec(url);

        if (!results)
            return null;
        if (!results[2])
            return '';

        return decodeURIComponent(results[2].replace(/\+/g, " "));
    },
    formatoMoneda: function(value,row,index) {
        return general.formatoNumero2Decimales(value).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    },
    formatoMonedaSF: function (numero) {
        numero = parseFloat(numero);
        //  alert(numero);
        return numero.toFixed(3).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    },
    formatoNumero2Decimales: function (numero) {
        if (this.esNumero($.trim(numero))) {
            if ($.trim(numero).indexOf('.') !== -1) {
                var digitos = $.trim(numero).split('.');

                numero = (digitos[1].length > 1) ? $.trim(numero).toString().match(/^-?\d+(?:\.\d{0,2})?/)[0] : $.trim(numero).toString().match(/^-?\d+(?:\.\d{0,2})?/)[0] + '0';
            } else {
                 numero = numero + '.00';
            }

            return '$' + numero;
        } else {
            return '$0.00';
        }
    },
    esNumero: function (numero) {
        return !isNaN(parseFloat(numero)) && isFinite(numero);
    },
    obtenerExtensionDoc: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/documentos/buscar',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            success: function (resultado) {
                try {
                    if (resultado.estatus !== "success") {
                        return resultado.datos;
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al obtener la extensión: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    enviarComentario: function (idSolicitud, comentario, opt) {
        var mensaje= '';
            switch (opt) {
                case '1':
                    //COMENTARIO AL CANCELAR SOLICITUD
                    solicitud.url = general.base_url + '/solicitudes/borrar';
                    break;
            }
        $.ajax({
            type: 'POST',
            url:   solicitud.url,
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al enviar la solicitud: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al enviar la solicitud.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    //funcion para enviar a la url dependiendo el documento a descargar
    urlDocumento: function (id, opt) {
        $url = general.base_url + '/documentos/descargar?opt='+ opt+'&id='+ $.base64.decode(id);
        general.block();


       $.fileDownload($url, {
            successCallback: function (url) {
                general.unblock();
            },
            failCallback: function (responseHtml, url) {
                console.log($response);
                general.unblock();
                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al recuperar el archivo: ' + responseHtml, 'danger', true);
            }
        });
    },

    //formato para el nombre completo del solicitante / anonimo
    solicitanteFormatter: function (value, row, index) {
        var nombre = (row.NOMBRE !== null) ? row.NOMBRE : '';
        var paterno = (row.APELLIDO_PATERNO !== null) ? row.APELLIDO_PATERNO : '';
        var materno = (row.APELLIDO_MATERNO !== null) ? row.APELLIDO_MATERNO : '';
        var solicitante = (row.ANONIMO === 'SI') ? 'ANONIMO' :  nombre + ' ' + paterno + ' ' + materno;
        solicitante =  (row.SEUDONIMO !== null) ? row.SEUDONIMO: solicitante;

        return solicitante;
    },
    iconFormatter: function (value, row, index) {
        var fechauno = new Date('d/m/Y');
        var fechados = new Date(row.FECHA_PREVENSION);

        var resultado = row.FECHA_PREVENSION === '05/07/2018';
        return (resultado !== true) ? '<i class="fa fa-check text-green" aria-hidden="true"></i>' :  '<i class="fa fa-map text-green" aria-hidden="true"></i>';
    },
    flujoSolicitudFormatter: function (value, row, index) {
        return '<i class="fa fa-check text-green" aria-hidden="true"></i>';
    },
    medioSolicitudFormatter: function (value, row, index) {
        return '<span class="label label-default"> ' + value.toUpperCase() + '</span>';
    },
    tipoSolicitudFormatter: function (value, row, index) {
        return (value === 'ARCO') ? '<span class="label label-primary">ARCO</span>' : '<span class="label label-primary">SAI</span>';
    },
    estatusSolicitudFormatter: function (value, row, index) {
        return '<span class="label label-default" style="color: #fff;background: ' +row.COLOR_ESTADO + '">'+ row.ESTADO.toUpperCase() + '</span>';
    },
    etapaSolicitudFormatter: function (value, row, index) {
        return '<span class="label label-default" style="color: #fff;background: ' +row.COLOR_ETAPA+ '">'+ row.ETAPA.toUpperCase() + '</span>';
    },
};

//Se inicializa el objeto
general.init();
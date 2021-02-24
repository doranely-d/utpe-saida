/* global general, bootbox, e */

var solicitudes = {
    tblSolicitudes: null,
    tblPreguntas : null,
    modalPregunta : null,
    modalPreguntas : null,
    frmPregunta : null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblSolicitudes = $('#tblSolicitudes');

        //Funcionalidad
        this.tblSolicitudes.bootstrapTable({
            url: general.base_url + '/solicitudes/listar?opt=8',
        });

        this.tblSolicitudes.on('load-success.bs.table', function (e, data) {
            if (!solicitudes.tblSolicitudes.is(':visible')) {
                solicitudes.tblSolicitudes.show();
                solicitudes.tblSolicitudes.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblSolicitudes.on('sort.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.on('page-change.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.on('search.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las acciones ' + status, 'danger', true);
        });
    },
    cargaDependencias: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitudes/buscar?opt=1',
            contentType: 'application/json; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        $.each(resultado.datos,function(key,dependencias ) {
                            $("#slDependencias").append('<option value='+dependencias.FLEX_VALUE_ID+'>'+dependencias.DESCRIPTION+'</option>');
                        });
                    } else {
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }

                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error carga de los estatus: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar los estatus.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaFrmModal: function (datosIn, idIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        var id = (idIn !== undefined) ? $.parseJSON($.base64.decode(idIn)) : null;
        //Si el paso es directo
        if(datos.FORMULARIO === '0') {
            $.ajax({
                type: 'POST',
                url: general.base_url + '/solicitudes/cambiar',
                data: {idSolicitud: id, idTransaccion:datos.ID_TRANSACCION},
                contentType: 'application/x-www-form-urlencoded',
                dataType: 'json',
                beforeSend: function (xhr) {
                    general.block();
                },
                success: function (resultado) {
                    try {
                        if (resultado.estatus === 'success') {
                            window.location = general.base_url + '/solicitudes/perfil?id=' + id;
                        }else{
                            general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                        }
                    } catch (e) {
                        setTimeout(function () {
                            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el tipo: ' + e + '.', 'error', true);
                        }, 500);
                    }
                },
                error: function () {
                    general.unblock();
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el tipo.', 'error', true);
                    }, 500);
                },
                complete: function () {
                    general.unblock();
                }
            });
        }
        else if(datos.FORMULARIO === '2' ||  datos.FORMULARIO === '4' || datos.FORMULARIO === '5'){
            $.ajax({
                type: 'POST',
                url: general.base_url + '/solicitudes/cambiar',
                data: {idSolicitud: id,idTransaccion:datos.ID_TRANSACCION},
                contentType: 'application/x-www-form-urlencoded',
                dataType: 'json',
                beforeSend: function (xhr) {
                    general.block();
                },
                success: function (resultado) {
                    try {
                        if (resultado.estatus === 'success') {
                            solicitudes.tblSolicitudes.bootstrapTable('refresh');
                        }
                    } catch (e) {
                        setTimeout(function () {
                            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar catalogo: ' + e + '.', 'danger', true);
                        }, 500);
                    }
                },
                error: function () {
                    general.unblock();
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar la solicitud.', 'danger', true);
                    }, 500);
                    e.preventDefault();
                },
                complete: function () {
                    general.unblock();
                }
            });

        }else if( datos.FORMULARIO === '1' || datos.FORMULARIO === '6' ||
            datos.FORMULARIO === '7' || datos.FORMULARIO === '8'|| datos.FORMULARIO === '9' ) {

            $.ajax({
                type: 'GET',
                url: general.base_url + '/solicitudes/modal?opt=' + datos.FORMULARIO,
                data: datos,
                contentType: 'application/html; charset=utf-8',
                beforeSend: function (xhr) {
                    general.block();
                },
                success: function (resultado) {
                    try {
                        solicitudes.modalPreguntas = bootbox.dialog({
                            title: datos.NOMBRE,
                            onEscape: true,
                            animate: true,
                            size: 'large',
                            message: resultado,
                            buttons: {
                                cancel: {
                                    label: 'Cancelar',
                                    className: 'btn-default'
                                },
                                save: {
                                    label: 'Aceptar',
                                    className: 'btn-success',
                                    callback: function () {
                                        solicitudes.frmPreguntas.submit();
                                        return false;
                                    }
                                }
                            }
                        });

                        solicitudes.modalPreguntas.on('shown.bs.modal', function () {
                            $('.bootbox-close-button').focus();

                            setTimeout(function () {
                                $('.bootbox-close-button').focusout();
                            }, 100);

                            //Inicialización
                            solicitudes.frmPreguntas = $('#frmPreguntas');
                            solicitudes.cargaPreguntas(id);

                            //Funcionalidad
                            solicitudes.frmPreguntas.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                                .on('success.form.fv', function (e) {
                                    e.preventDefault();

                                    $.ajax({
                                        type: 'POST',
                                        url: general.base_url + '/solicitudes/cambiar',
                                        data: {idSolicitud: id, idTransaccion:datos.ID_TRANSACCION},
                                        contentType: 'application/x-www-form-urlencoded',
                                        dataType: 'json',
                                        beforeSend: function (xhr) {
                                            general.block();
                                        },
                                        success: function (resultado) {
                                            try {
                                                if (resultado.estatus === 'success') {
                                                    solicitudes.tblSolicitudes.bootstrapTable('refresh');
                                                }else{
                                                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                                                }
                                            } catch (e) {
                                                setTimeout(function () {
                                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el tipo: ' + e + '.', 'error', true);
                                                }, 500);
                                            }
                                        },
                                        error: function () {
                                            general.unblock();
                                            setTimeout(function () {
                                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el tipo.', 'error', true);
                                            }, 500);
                                        },
                                        complete: function () {
                                            general.unblock();
                                        }
                                    });
                                    solicitudes.modalPreguntas.modal('hide');
                                });
                        });
                    } catch (e) {
                        setTimeout(function () {
                            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar modal: ' + e + '.', 'error', true);
                        }, 500);
                    }
                },
                error: function () {
                    general.unblock();
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar el modal.', 'error', true);
                    }, 500);
                },
                complete: function () {
                    general.unblock();
                }
            });
        }
    },
    cargaPreguntas: function (idSolicitud) {
        //inicializamos variables
        solicitudes.tblPreguntas = $("#tblPreguntas");
        //cargamos la tabla de preguntas
        solicitudes.tblPreguntas.bootstrapTable({
            url: general.base_url + '/solicitudes/listar?opt=9&id_solicitud=' + idSolicitud,
        });
        solicitudes.tblPreguntas.on('load-success.bs.table', function (e, data) {
            if (!solicitudes.tblPreguntas.is(':visible')) {
                solicitudes.tblPreguntas.show();
                solicitudes.tblPreguntas.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitudes.tblPreguntas.on('sort.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.on('page-change.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.on('search.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las preguntas ' + status, 'danger', true);
        });
    },
    cargaFrmTurnado: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitudes/modal?opt=3',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            success: function (resultado) {
                try {
                    solicitudes.modalTurnado = bootbox.dialog({
                        title: ' <i class="fa fa-link prefix"></i> Realizar turnado',
                        onEscape: true,
                        animate: true,
                        size: 'large',
                        message: resultado,
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-default'
                            },
                            save: {
                                label: 'Guardar',
                                className: 'btn-success',
                                callback: function () {
                                    solicitudes.frmTurnado.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitudes.modalTurnado.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //inicialización
                        solicitudes.frmTurnado = $('#frmTurnado');
                        solicitudes.slDependencias = $('#slDependencias');
                        solicitudes.cargaDependencias();
                        var select = document.getElementById('slDependencias');
                        multi( select, {
                            dropdownParent: solicitudes.modalTurnado,
                            non_selected_header: 'DEPENDENCIAS',
                            selected_header: 'DEPENDENCIAS SELECCIONADAS',
                            search_placeholder: 'Buscar dependencia ...',
                        });
                        //Funcionalidad
                        solicitudes.frmTurnado.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                solicitudes.guardarTurnado(datos.ID_PREGUNTA);
                                solicitudes.modalTurnado.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de los documentos: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de los documentos.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarTurnado: function (id) {
        var data = {
            txtIdPregunta: id,
            slDependencias:  solicitudes.slDependencias.val(),
            txtComentario:  $("#txtComentario").val(),
        };
        $.ajax({
            type: 'POST',
            url: general.base_url + '/solicitudes/guardar?opt=3',
            data: data,
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitudes.tblPreguntas.bootstrapTable('refresh');
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al realizar el turnado: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al realizar el turnado.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaFrmPregunta: function (datosIn, contPregunta) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitudes/modal?opt=2',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitudes.modalPregunta = bootbox.dialog({
                        title: ' <i class="fa fa-pencil prefix"></i> Pregunta No.' + contPregunta,
                        onEscape: true,
                        animate: true,
                        size: 'large',
                        message: resultado,
                        buttons: {
                            cancel: {
                                label: 'Aceptar',
                                className: 'btn-success'
                            },}
                    });

                    solicitudes.modalPregunta.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        solicitudes.frmPregunta = $('#frmPregunta');

                        //Funcionalidad
                        solicitudes.frmPregunta.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                solicitudes.modalPregunta.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de la pregunta: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de la pregunta.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaFrmComentarios: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitudes/modal?opt=10', //Muestra el modal de historial de comentarios
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitudes.modalPregunta = bootbox.dialog({
                        title: " Historial de comentarios",
                        onEscape: true,
                        animate: true,
                        size: 'large',
                        message: resultado,
                        buttons: {
                            cancel: {
                                label: 'Aceptar',
                                className: 'btn-success'
                            },}
                    });

                    solicitudes.modalPregunta.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();
                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        if(datos.comentarios){
                            $.each(datos.comentarios ,function(key,comentario ) {
                                $("<div>", {'class': 'direct-chat-msg'}).append(
                                    $('<div class="direct-chat-info clearfix">').append(
                                        '<span class="direct-chat-name pull-left">'+comentario.DEPENDENCIA+'</span>\n' +
                                        '<span class="direct-chat-timestamp pull-right">'+comentario.FECHA_I+'</span>'),
                                    $('<div class="direct-chat-text">').append(comentario.COMENTARIO )).hide().appendTo('.direct-chat-messages').fadeIn('slow');
                            });
                        }
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de comentarios: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de comentarios.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    turnadoFormatter: function (value, row, index) {
        return (value === '1') ? 'Si' : '';
    },
    numRowFormatter: function (value, row, index) {
        return 1+index;
    },
    etapaFormatter: function (value, row, index) {
        return '<u style="color: ' +row.COLOR_ETAPA+ '">'+ value + '</u>';
    },
    nEtapaFormatter: function (value, row, index) {
        return '<u style="color: ' +row.COLOR_N_ETAPA+ '">'+ value + '</u>';
    },
    estadoFormatter: function (value, row, index) {
        return '<span class="label label-default" style="color: #fff;background: ' +row.COLOR_ESTADO + '">'+ row.ESTADO.toUpperCase() + '</span>';
    },
    accionesFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmPregunta(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Información rápida"><i class="glyphicon glyphicon-zoom-in"></i></a>',
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmTurnado(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Turnar Pregunta"><i class="glyphicon glyphicon-link"></i></a>',
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmComentarios(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Comentarios"><i class="glyphicon glyphicon-comment"></i></a>'
        ].join('');
    },
    preguntasFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmPregunta(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Información rápida"><i class="glyphicon glyphicon-zoom-in"></i></a>',
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmComentarios(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Comentarios"><i class="glyphicon glyphicon-comment"></i></a>'
        ].join('');
    },
    actionSolicitudFormatter: function (value, row, index) {
        var botones = [];

        $.each(row.transacciones,function(key,transaccion) {
            botones += '&nbsp;<a class="btn '+ transaccion.BOTON +' btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmModal(\'' + $.base64.encode(JSON.stringify(transaccion))+ '\',\''+ $.base64.encode(JSON.stringify(row.ID_SOLICITUD))+'\');" data-toggle="tooltip" ' +
                'data-placement="bottom" title="'+transaccion.NOMBRE+'"><i class="'+transaccion.ICONO+'"></i></a>';
        });

        botones += '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="' + general.base_url + '/solicitudes/perfil?id=' + row.ID_SOLICITUD + '" data-toggle="tooltip" data-placement="bottom" title="Ver Solicitud" target="_blank">' +
            '<i class="glyphicon glyphicon-info-sign"></i></a>';

        return botones;
    },
};

solicitudes.init();
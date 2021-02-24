/* global general, bootbox, e */

var solicitantes = {
    tblSolicitantes: null,
    modalSolicitante: null,
    frmSolicitante: null,
    txtIdSolicitud: null,
    modalComentario: null,
    slSolicitudArco: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblSolicitantes = $('#tblSolicitantes');

        //Funcionalidad
        this.tblSolicitantes.bootstrapTable({
            url: general.base_url + '/solicitantes/listar?opt=0', //Obtenemos los solicitantes activos
        });

        this.tblSolicitantes.on('load-success.bs.table', function (e, data) {
            if (!solicitantes.tblSolicitantes.is(':visible')) {
                solicitantes.tblSolicitantes.show();
                solicitantes.tblSolicitantes.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblSolicitantes.on('sort.bs.table', function (e, row) {
            if (solicitantes.tblSolicitantes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitantes.on('page-change.bs.table', function (e, row) {
            if (solicitantes.tblSolicitantes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitantes.on('search.bs.table', function (e, row) {
            if (solicitantes.tblSolicitantes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitantes.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitantes.tblSolicitantes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitantes.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los solicitantes ' + status, 'danger', true);
        });
    },
    cargaFrmSolicitante: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitantes/modal?opt=0',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitantes.modalSolicitante = bootbox.dialog({
                        title: 'Solicitante',
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
                                    solicitantes.modalSolicitante.modal('hide');
                                    return false;
                                }
                            }
                        }
                    });

                    solicitantes.modalSolicitante.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página del solicitante: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página del solicitante.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    eliminarSolicitante: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas eliminar todos los registros del solicitante seleccionado?",
            buttons: {
                confirm: {
                    label: 'Sí',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    solicitantes.cargaFrmComentario($.base64.encode(id));
                }
            }
        });
    },
    cargaFrmComentario: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitantes/modal?opt=1',
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitantes.modalComentario = bootbox.dialog({
                        title: 'Eliminación de los datos personales',
                        onEscape: true,
                        animate: true,
                        size: 'smmall',
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
                                    solicitantes.frmComentario.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitantes.modalComentario.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //inicialización
                        solicitantes.frmComentario = $('#frmComentario');
                        solicitantes.slSolicitudArco = $('#slSolicitudArco');

                        solicitantes.slSolicitudArco.select2({
                            placeholder: 'Selecciona solicitud ARCO a ejercer',
                            language: 'es',
                            dropdownParent: solicitantes.modalComentario,
                        });
                        solicitantes.cargaSolicitud();

                        //Funcionalidad
                        solicitantes.frmComentario.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                $.ajax({
                                    type: 'GET',
                                    url: general.base_url + '/solicitantes/borrar/?txtIdSolicitante=' + datos,
                                    contentType: 'application/json; charset=utf-8',
                                    data:{txtComentario: $('#txtComentario').val()},
                                    success: function (resultado) {
                                        try {
                                            if (resultado.estatus === 'success') {
                                                solicitantes.tblSolicitantes.bootstrapTable('refresh');
                                                solicitantes.modalComentario.modal('hide');
                                            }
                                            general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                                        } catch (e) {
                                            setTimeout(function () {
                                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al eliminar el solicitante: ' + e + '.', 'danger', true);
                                            }, 500);
                                        }
                                    },
                                    error: function () {
                                        general.unblock();
                                        setTimeout(function () {
                                            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al eliminar el solicitante.', 'danger', true);
                                        }, 500);
                                    },
                                    complete: function () {
                                        general.unblock();
                                    }
                                });
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al mostrar el modal de comentarios: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de los comentarios.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaSolicitud: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitantes/buscar?opt=0',//obtenemos las solicitudes ARCO activas
            contentType: 'application/json; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        solicitantes.slSolicitudArco.find('option').remove().end().append('<option value="">Selecciona la siguiente etapa</option>');
                        $.each(resultado.datos,function(key,solicitud ) {
                            solicitantes.slSolicitudArco.append('<option value='+solicitud.ID_SOLICITUD+'>'+solicitud.FOLIO+'</option>');
                        });
                    } else {
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }

                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    actionFormatter: function (value, row, index) {
        var url = general.base_url + '/solicitantes/perfil/';

        return [
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitantes.cargaFrmSolicitante(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Información rápida"><i class="glyphicon glyphicon-zoom-in"></i></a>',
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="' + url + '?idSolicitante=' + row.ID_SOLICITANTE + '" data-toggle="tooltip" data-placement="bottom" title="Ver Solicitante" target="_blank"><i class="glyphicon glyphicon-info-sign"></i></a>',
            (row.ESTATUS !== 'IN') ?  '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:solicitantes.eliminarSolicitante(\'' + $.base64.encode(row.ID_SOLICITANTE) + '\');" data-toggle="tooltip" data-placement="bottom" title="Eliminar Solicitante"><i class="glyphicon glyphicon-trash"></i></a>': ' '
        ].join('');
    }
};

solicitantes.init();
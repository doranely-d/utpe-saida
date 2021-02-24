/* global general, bootbox, e */

var solicitantePerfil = {
    tblSolicitudesSai: null,
    tblSolicitudesArco: null,
    tblHistorial:  null,
    tblComentarios:null,
    btnEliminarSolicitante: null,
    modalComentario: null,
    frmComentario: null,
    txtIdSolicitante:null,
    slSolicitudArco:null,

    init: function () {
        //Inicialización de propiedades
        this.tblSolicitudesSai = $('#tblSolicitudesSai');
        this.tblSolicitudesArco = $('#tblSolicitudesArco');
        this.tblHistorial = $('#tblHistorial');
        this.tblComentarios = $('#tblComentarios');
        this.btnEliminarSolicitante = $('#btnEliminarSolicitante');
        this.modalComentario = $('#modalComentario');
        this.frmComentario = $('#frmComentario');
        this.txtIdSolicitante = $('#txtIdSolicitante');

        //Cargamos el contenido de la página
        solicitantePerfil.cargaSolicitudesSai();

        //Cancelar la solicitud
        this.btnEliminarSolicitante.click(function () {
            solicitantePerfil.eliminarSolicitante(solicitantePerfil.txtIdSolicitante.val());
        });
    },
    cargaSolicitudesSai: function () {
        solicitantePerfil.tblSolicitudesSai = $('#tblSolicitudesSai');

        solicitantePerfil.tblSolicitudesSai.bootstrapTable({
            url: general.base_url + '/solicitantes/listar?opt=1&tipo=SAI&id=' + solicitantePerfil.txtIdSolicitante.val(),
        });

        solicitantePerfil.tblSolicitudesSai.on('load-success.bs.table', function (e, data) {
            if (!solicitantePerfil.tblSolicitudesSai.is(':visible')) {
                solicitantePerfil.tblSolicitudesSai.show();
                solicitantePerfil.tblSolicitudesSai.bootstrapTable('resetView');
            }
            general.unblock();
            solicitantePerfil.cargaSolicitudesArco();
        });

        solicitantePerfil.tblSolicitudesSai.on('sort.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesSai.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesSai.on('page-change.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesSai.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesSai.on('search.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesSai.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesSai.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesSai.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesSai.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las preguntas ' + status, 'danger', true);
        });
    },
    cargaSolicitudesArco: function () {
        solicitantePerfil.tblSolicitudesArco = $('#tblSolicitudesArco');

        solicitantePerfil.tblSolicitudesArco.bootstrapTable({
            url: general.base_url + '/solicitantes/listar?opt=1&tipo=ARCO&id=' + solicitantePerfil.txtIdSolicitante.val(),
        });
        solicitantePerfil.tblSolicitudesArco.on('load-success.bs.table', function (e, data) {
            if (!solicitantePerfil.tblSolicitudesArco.is(':visible')) {
                solicitantePerfil.tblSolicitudesArco.show();
                solicitantePerfil.tblSolicitudesArco.bootstrapTable('resetView');
            }
            general.unblock();
            solicitantePerfil.cargaHistorial();
        });

        solicitantePerfil.tblSolicitudesArco.on('sort.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesArco.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesArco.on('page-change.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesArco.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesArco.on('search.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesArco.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesArco.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitantePerfil.tblSolicitudesArco.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblSolicitudesArco.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las preguntas ' + status, 'danger', true);
        });
    },
    cargaHistorial: function () {
        solicitantePerfil.tblHistorial = $('#tblHistorial');

        solicitantePerfil.tblHistorial.bootstrapTable({
            url: general.base_url + '/solicitantes/listar?opt=3&id=' + solicitantePerfil.txtIdSolicitante.val(),
        });
        solicitantePerfil.tblHistorial.on('load-success.bs.table', function (e, data) {
            if (!solicitantePerfil.tblHistorial.is(':visible')) {
                solicitantePerfil.tblHistorial.show();
                solicitantePerfil.tblHistorial.bootstrapTable('resetView');
            }
            general.unblock();
            solicitantePerfil.cargaComentarios();
        });

        solicitantePerfil.tblHistorial.on('sort.bs.table', function (e, row) {
            if (solicitantePerfil.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblHistorial.on('page-change.bs.table', function (e, row) {
            if (solicitantePerfil.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblHistorial.on('search.bs.table', function (e, row) {
            if (solicitantePerfil.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblHistorial.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitantePerfil.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblHistorial.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información del historial ' + status, 'danger', true);
        });
    },

    cargaComentarios: function () {
        solicitantePerfil.tblComentarios = $('#tblComentarios');

        solicitantePerfil.tblComentarios.bootstrapTable({
            url: general.base_url + '/solicitantes/listar/?opt=2&id=' + solicitantePerfil.txtIdSolicitante.val(),
        });
        solicitantePerfil.tblComentarios.on('load-success.bs.table', function (e, data) {
            if (!solicitantePerfil.tblComentarios.is(':visible')) {
                solicitantePerfil.tblComentarios.show();
                solicitantePerfil.tblComentarios.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitantePerfil.tblComentarios.on('sort.bs.table', function (e, row) {
            if (solicitantePerfil.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblComentarios.on('page-change.bs.table', function (e, row) {
            if (solicitantePerfil.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblComentarios.on('search.bs.table', function (e, row) {
            if (solicitantePerfil.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblComentarios.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitantePerfil.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitantePerfil.tblComentarios.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los comentarios. ' + status, 'danger', true);
        });
    },
    eliminarSolicitante: function (idIn) {
        var id = (idIn !== undefined) ? idIn : null;
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
                    solicitantePerfil.cargaFrmComentario($.base64.encode(id));
                }
            }
        });
    },
    cargaFrmComentario: function (idIn) {
        var id = (idIn !== undefined) ? $.parseJSON($.base64.decode(idIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitantes/modal?opt=1',
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitantePerfil.modalComentario = bootbox.dialog({
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
                                    solicitantePerfil.frmComentario.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitantePerfil.modalComentario.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //inicialización
                        solicitantePerfil.frmComentario = $('#frmComentario');
                        solicitantePerfil.slSolicitudArco = $('#slSolicitudArco');

                        solicitantePerfil.slSolicitudArco.select2({
                            placeholder: 'Selecciona solicitud ARCO a ejercer',
                            language: 'es',
                            dropdownParent: solicitantePerfil.modalComentario,
                        });
                        solicitantePerfil.cargaSolicitud();

                        //Funcionalidad
                        solicitantePerfil.frmComentario.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                $.ajax({
                                    type: 'GET',
                                    url: general.base_url + '/solicitantes/borrar?txtIdSolicitante=' + id,
                                    contentType: 'application/json; charset=utf-8',
                                    data: solicitantePerfil.frmComentario.serialize(),
                                    success: function (resultado) {
                                        try {
                                            if (resultado.estatus === 'success') {
                                                solicitantePerfil.modalComentario.modal('hide');
                                                location.reload();
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
                        solicitantePerfil.slSolicitudArco.find('option').remove().end().append('<option value="">Selecciona la siguiente etapa</option>');
                        $.each(resultado.datos,function(key,solicitud ) {
                            solicitantePerfil.slSolicitudArco.append('<option value='+solicitud.ID_SOLICITUD+'>'+solicitud.FOLIO+'</option>');
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
    etapaFormatter: function (value, row, index) {
        return '<u style="color: ' +row.COLOR_ETAPA+ '">'+ value + '</u>';
    },
    estadoFormatter: function (value, row, index) {
        return '<span class="label label-default" style="color: #fff;background: ' +row.COLOR_ESTADO + '">'+ row.ESTADO.toUpperCase() + '</span>';
    },
    accionesFormatter: function (value, row, index) {
        console.log(index);
        return [
            '&nbsp;<a class="btn btn-info btn-lg btn-xs" role="button" href="javascript:solicitud.cargaFrmPregunta(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="top" title="Ver pregunta"><i class="glyphicon glyphicon-search"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:solicitud.borrarDocumento(\'' + $.base64.encode(row.ID_DOCUMENTO) + '\');" data-toggle="tooltip" data-placement="top" title="Borrar Documento"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
    numRowFormatter: function (value, row, index) {
        return 1 + index;
    },
    documentoActionFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:solicitud.cargaFrmDocumento(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="top" title="Editar Documento"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:solicitud.borrarDocumento(\'' + $.base64.encode(row.ID_DOCUMENTO) + '\');" data-toggle="tooltip" data-placement="top" title="Borrar Documento"><i class="glyphicon glyphicon-trash"></i></a>',
            '&nbsp;<a class="btn btn-info btn-lg btn-xs" role="button" href="javascript:general.descargaDocumento(\'' +general.base_url +'/solicitudes/descargardocumento/?id_documento='+ row.ID_DOCUMENTO +  '\');" data-toggle="tooltip" data-placement="top" title="Descargar Documento"><i class="glyphicon glyphicon-download-alt"></i></a>'
        ].join('');
    },
};

solicitantePerfil.init();
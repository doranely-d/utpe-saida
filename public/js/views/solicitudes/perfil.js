/* global general, bootbox, e */

var solicitud = {
    tblDocumentos: null,
    tblPrevencion: null,
    tblPreguntas: null,
    tblHistorial:  null,
    tblComentarios:null,
    tblMediosRespuesta:null,
    btnAgregarDocumento: null,
    btnRegresar: null,
    modalTurnado : null,
    modalDocumento: null,
    modalPregunta: null,
    modalComentario: null,
    frmTurnado: null,
    frmDocumento: null,
    frmPregunta: null,
    frmComentario: null,
    aPreguntas: null,
    aComentarios: null,
    aHistorial: null,
    aDocumentos: null,
    aPrevencion: null,
    aDerechosArco: null,
    aMediosRespuesta: null,
    txtIdSolicitud: null,
    slDependencias: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblDocumentos = $('#tblDocumentos');
        this.tblPrevencion = $('#tblPrevencion');
        this.btnAgregarDocumento = $('#btnAgregarDocumento');
        this.tblPreguntas = $('#tblPreguntas');
        this.tblHistorial = $('#tblHistorial');
        this.tblComentarios = $('#tblComentarios');
        this.tblMediosRespuesta = $('#tblMediosRespuesta');
        this.txtIdSolicitud = $("#txtIdSolicitud");
        this.aPreguntas = $('a[href="#prof_preguntas"]');
        this.aMediosRespuesta = $('a[href="#prof_medio"]');
        this.aDerechosArco = $('a[href="#prof_arco"]');
        this.aComentarios = $('a[href="#prof_comentarios"]');
        this.aHistorial =  $('a[href="#prof_historial"]');
        this.aDocumentos = $('a[href="#prof_documentos"]');
        this.aPrevencion = $('a[href="#prof_prevencion"]');

        this.aPreguntas.click(function () {
           solicitud.cargaPreguntas();
        });
        this.aDerechosArco.click(function () {
            solicitud.cargaDerechos();
        });
        this.aMediosRespuesta.click(function () {
            solicitud.cargaMediosRespuesta();
        });
        this.aComentarios.click(function () {
            solicitud.cargaComentarios();
        });
        this.aHistorial.click(function () {
          solicitud.cargaHistorial();
        });
        this.aDocumentos.click(function () {
            solicitud.cargaDocumentos();
        });
        this.aPrevencion.click(function () {
            solicitud.cargaPrevenciones();
        });
        //Muestra el modal de documentos
        this.btnAgregarDocumento.click(function () {
            solicitud.cargaFrmDocumento();
        });
    },
    cargaPreguntas: function () {
        solicitud.tblPreguntas = $('#tblPreguntas');

        solicitud.tblPreguntas.bootstrapTable({
            url: general.base_url + '/solicitudes/listar/?opt=1&id_solicitud=' + solicitud.txtIdSolicitud.val(),
        });
        solicitud.tblPreguntas.on('load-success.bs.table', function (e, data) {
            if (!solicitud.tblPreguntas.is(':visible')) {
                solicitud.tblPreguntas.show();
                solicitud.tblPreguntas.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitud.tblPreguntas.on('sort.bs.table', function (e, row) {
            if (solicitud.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPreguntas.on('page-change.bs.table', function (e, row) {
            if (solicitud.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPreguntas.on('search.bs.table', function (e, row) {
            if (solicitud.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPreguntas.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitud.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPreguntas.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las preguntas ' + status, 'danger', true);
        });
    },
    cargaMediosRespuesta: function () {
        //inicializamos variables
        solicitud.tblMediosRespuesta = $("#tblMediosRespuesta");
        //Cargamos la tabla de medios de respuesta
        solicitud.tblMediosRespuesta.bootstrapTable({
            url: general.base_url + '/solicitudes/listar/?opt=3&id_solicitud=' + solicitud.txtIdSolicitud.val(),
        });
        solicitud.tblMediosRespuesta.on('load-success.bs.table', function (e, data) {
            if (!solicitud.tblMediosRespuesta.is(':visible')) {
                solicitud.tblMediosRespuesta.show();
                solicitud.tblMediosRespuesta.bootstrapTable('resetView');
            }
        });

        solicitud.tblMediosRespuesta.on('sort.bs.table', function (e, row) {
            if (solicitud.tblMediosRespuesta.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblMediosRespuesta.on('page-change.bs.table', function (e, row) {
            if (solicitud.tblMediosRespuesta.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblMediosRespuesta.on('search.bs.table', function (e, row) {
            if (solicitud.tblMediosRespuesta.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblMediosRespuesta.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitud.tblMediosRespuesta.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblMediosRespuesta.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los medios de respuesta ' + status, 'danger', true);
        });
    },
    cargaHistorial: function () {
        solicitud.tblHistorial = $('#tblHistorial');

        solicitud.tblHistorial.bootstrapTable({
            url: general.base_url + '/solicitudes/listar/?opt=4&id_solicitud=' + solicitud.txtIdSolicitud.val(),
        });
        solicitud.tblHistorial.on('load-success.bs.table', function (e, data) {
            if (!solicitud.tblHistorial.is(':visible')) {
                solicitud.tblHistorial.show();
                solicitud.tblHistorial.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitud.tblHistorial.on('sort.bs.table', function (e, row) {
            if (solicitud.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblHistorial.on('page-change.bs.table', function (e, row) {
            if (solicitud.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblHistorial.on('search.bs.table', function (e, row) {
            if (solicitud.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblHistorial.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitud.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblHistorial.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información del historial ' + status, 'danger', true);
        });
    },
    cargaDocumentos: function () {
        solicitud.tblDocumentos = $('#tblDocumentos');

        solicitud.tblDocumentos.bootstrapTable({
            url: general.base_url + '/solicitudes/listar?opt=2&id_solicitud=' + solicitud.txtIdSolicitud.val(),
        });
        solicitud.tblDocumentos.on('load-success.bs.table', function (e, data) {
            if (!solicitud.tblDocumentos.is(':visible')) {
                solicitud.tblDocumentos.show();
                solicitud.tblDocumentos.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitud.tblDocumentos.on('sort.bs.table', function (e, row) {
            if (solicitud.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblDocumentos.on('page-change.bs.table', function (e, row) {
            if (solicitud.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblDocumentos.on('search.bs.table', function (e, row) {
            if (solicitud.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblDocumentos.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitud.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblDocumentos.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las preguntas ' + status, 'danger', true);
        });
    },
    cargaPrevenciones: function () {
        solicitud.tblPrevencion = $('#tblPrevencion');

        solicitud.tblPrevencion.bootstrapTable({
            url: general.base_url + '/solicitudes/listar?opt=10&id_solicitud=' + solicitud.txtIdSolicitud.val(),
        });
        solicitud.tblPrevencion.on('load-success.bs.table', function (e, data) {
            if (!solicitud.tblPrevencion.is(':visible')) {
                solicitud.tblPrevencion.show();
                solicitud.tblPrevencion.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitud.tblPrevencion.on('sort.bs.table', function (e, row) {
            if (solicitud.tblPrevencion.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPrevencion.on('page-change.bs.table', function (e, row) {
            if (solicitud.tblPrevencion.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPrevencion.on('search.bs.table', function (e, row) {
            if (solicitud.tblPrevencion.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPrevencion.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitud.tblPrevencion.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblPrevencion.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información ' + status, 'danger', true);
        });
    },
    cargaComentarios: function () {
        solicitud.tblComentarios = $('#tblComentarios');

        solicitud.tblComentarios.bootstrapTable({
            url: general.base_url + '/solicitudes/listar/?opt=5&id_solicitud=' + solicitud.txtIdSolicitud.val(),
        });
        solicitud.tblComentarios.on('load-success.bs.table', function (e, data) {
            if (!solicitud.tblComentarios.is(':visible')) {
                solicitud.tblComentarios.show();
                solicitud.tblComentarios.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitud.tblComentarios.on('sort.bs.table', function (e, row) {
            if (solicitud.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblComentarios.on('page-change.bs.table', function (e, row) {
            if (solicitud.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblComentarios.on('search.bs.table', function (e, row) {
            if (solicitud.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblComentarios.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitud.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitud.tblComentarios.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los comentarios. ' + status, 'danger', true);
        });
    },
    cargaFrmPregunta: function (datosIn, contPregunta) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitudes/modal?opt=2', //Modal para mostrar la información rapida de la pregunta
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitud.modalPregunta = bootbox.dialog({
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

                    solicitud.modalPregunta.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();
                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //Inicialización
                        solicitud.frmPregunta = $('#frmPregunta');
                        //Funcionalidad
                        solicitud.frmPregunta.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                solicitud.modalPregunta.modal('hide');
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
    cargaFrmDocumento: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/documentos/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitud.modalDocumento = bootbox.dialog({
                        title: '<i class="fa fa-upload" aria-hidden="true"></i> Anexo de documentos',
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
                                    solicitud.frmDocumento.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitud.modalDocumento.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //inicialización
                        solicitud.frmDocumento = $('#frmDocumento');
                        solicitud.inpDocumento = $("#inpDocumento");
                        //funcionalidad
                        solicitud.inpDocumento.fileinput({
                            showPreview: false,
                            showUpload: false,
                            language: "es",
                            elErrorContainer: '#kartik-file-errors',
                            allowedFileExtensions: general.obtenerExtensionDoc(),
                        });

                        //Funcionalidad
                        solicitud.frmDocumento.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                solicitud.guardarDocumento();
                                solicitud.modalDocumento.modal('hide');
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
    cargaFrmTurnado: function (datosIn , contP) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitudes/modal?opt=3',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
              //  general.block();
            },
            success: function (resultado) {
                try {
                    solicitud.modalTurnado = bootbox.dialog({
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
                                    solicitud.frmTurnado.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitud.modalTurnado.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //inicialización
                        solicitud.frmTurnado = $('#frmTurnado');
                        solicitud.slDependencias = $('#slDependencias');
                        solicitud.cargaDependencias();
                        var select = document.getElementById('slDependencias');
                        multi( select, {
                            dropdownParent: solicitud.modalTurnado,
                            non_selected_header: 'DEPENDENCIAS',
                            selected_header: 'DEPENDENCIAS SELECCIONADAS',
                            search_placeholder: 'Buscar dependencia ...',
                        });
                        //Funcionalidad
                        solicitud.frmTurnado.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                solicitud.guardarTurnado();
                                solicitud.modalTurnado.modal('hide');
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
    guardarDocumento: function () {
        var formData = new FormData();
        formData.append("inpDocumento", solicitudes.inpDocumento[0].files[0]);
        formData.append("idDocumento", $("#txtIdDocumento").val());
        formData.append("id", solicitudes.txtIdSolicitud.val());
        formData.append("txtNombre", $("#txtNombreDoc").val());
        formData.append("opt", '2'); //opción para almacenar los documentos anexos a la solicitud

        $.ajax({
            url: general.base_url + '/documentos/guardar',
            method: 'POST',
            contentType: false,
            dataType: 'json',
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            cache: false,
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        solicitudes.tblDocumentos.bootstrapTable('refresh', {
                            url: general.base_url + '/solicitudes/listar?opt=2&id_solicitud='+ solicitudes.txtIdSolicitud.val(),
                        });
                    }else{
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el documento: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el documento.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarTurnado: function () {
        var data = {
            txtIdPregunta: $("#txtIdPregunta").val(),
            txtComentario:  $("#txtComentario").val(),
            slDependencias:  solicitud.slDependencias.val(),
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
    borrarDocumento: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el documento?",
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
                    $.ajax({
                        type: 'PUT',
                        url: general.base_url + '/documentos/borrar?txtIdDocumento=' + id + '&opt=3',
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    solicitud.tblDocumentos.bootstrapTable('refresh');
                                    solicitud.contDocumento = solicitud.contDocumento - 1;
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el documento: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el documento.', 'danger', true);
                            }, 500);
                        },
                        complete: function () {
                            general.unblock();
                        }
                    });
                }
            }
        });
    },
    cargaFrmComentario: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/comentarios/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitud.modalComentario = bootbox.dialog({
                        title: '<i class="fa fa-comment" aria-hidden="true"></i> Comentarios',
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
                                    solicitud.frmComentario.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitud.modalComentario.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //inicialización
                        solicitud.frmComentario = $('#frmComentario');

                        //Funcionalidad
                        solicitud.frmComentario.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                general.enviarComentario(solicitud.txtIdSolicitud.val(), $('#txtComentario').val(), '1');
                                solicitud.modalComentario.modal('hide');
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
    accionesFormatter: function (value, row, index) {
        var url = general.base_url + '/preguntas/perfil/';
        return [
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitud.cargaFrmPregunta(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Información rápida"><i class="glyphicon glyphicon-zoom-in"></i></a>',
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitud.cargaFrmTurnado(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Turnar Pregunta"><i class="glyphicon glyphicon-link"></i></a>',
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="' + url + '?idPregunta=' + row.ID_PREGUNTA + '" data-toggle="tooltip" data-placement="bottom" title="Ver pregunta" target="_blank"><i class="glyphicon glyphicon-info-sign"></i></a>',
        ].join('');
    },
    documentoFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmDocumento(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Documento"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:solicitudes.borrarDocumento(\'' + $.base64.encode(row.ID_DOCUMENTO) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Documento"><i class="glyphicon glyphicon-trash"></i></a>',
            '&nbsp;<a class="btn btn-success btn-lg btn-xs" role="button" href="javascript:general.urlDocumento(\''+$.base64.encode(row.ID_DOCUMENTO)+'\',\'2\');" data-toggle="tooltip" data-placement="bottom" title="Descargar Documento"><i class="glyphicon glyphicon-download-alt"></i></a>'
        ].join('');
    },
    prevencionFormatter: function (value, row, index) {
        return '<a class="btn btn-success btn-lg btn-xs" role="button" href="javascript:general.urlDocumento(\''+$.base64.encode(row.ID_DOCUMENTO)+'\',\'2\');" data-toggle="tooltip" data-placement="bottom" title="Descargar Documento"><i class="glyphicon glyphicon-download-alt"></i></a>';
    },
    nombreDocFormatter: function (value, row, index) {
        return row.NOMBRE + '.' + row.EXTENSION;
    },
    numRowFormatter: function (value, row, index) {
        return 1+index;
    }
};

solicitud.init();
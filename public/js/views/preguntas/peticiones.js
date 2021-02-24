/* global general, bootbox, e */

var preguntas = {
    tblPreguntas: null,
    modalPreguntas: null,
    frmPreguntas: null,
    modalTurnado: null,
    frmTurnado: null,
    slDependencias: null,
    txtTipoSolicitud : null,
    txtIdPregunta : null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblPreguntas = $('#tblPreguntas');
        this.txtTipoSolicitud = $('#txtTipoSolicitud');
        this.txtIdPregunta = $('#txtIdPregunta');
        this.slDependencias = $('#slDependencias');
        //Funcionalidad
        this.tblPreguntas.bootstrapTable({
            url: general.base_url + '/preguntas/peticionesjson/?tipo='+preguntas.txtTipoSolicitud.val(),

        });

        this.tblPreguntas.on('load-success.bs.table', function (e, data) {
            if (!preguntas.tblPreguntas.is(':visible')) {
                preguntas.tblPreguntas.show();
                preguntas.tblPreguntas.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblPreguntas.on('sort.bs.table', function (e, row) {
            if (preguntas.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblPreguntas.on('page-change.bs.table', function (e, row) {
            if (preguntas.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblPreguntas.on('search.bs.table', function (e, row) {
            if (preguntas.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblPreguntas.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (preguntas.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblPreguntas.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las preguntas activas ' + status, 'danger', true);
        });

    },
    cargaFrmPregunta: function (datosIn, contPregunta) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/preguntas/preguntas',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    preguntas.modalPregunta = bootbox.dialog({
                        title: ' <i class="fa fa-search"></i> Pregunta solicitada',
                        onEscape: true,
                        animate: true,
                        size: 'smmall',
                        message: resultado,
                        buttons: {
                            cancel: {
                                label: 'Aceptar',
                                className: 'btn-primary'
                            },}
                    });

                    preguntas.modalPregunta.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();
                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //Inicialización
                        preguntas.frmPregunta = $('#frmPregunta');
                        //Funcionalidad
                        preguntas.frmPregunta.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                preguntas.modalPregunta.modal('hide');
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
    cargaFrmTurnado: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        $.ajax({
            type: 'GET',
            url: general.base_url + '/preguntas/turnado',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                //  general.block();
            },
            success: function (resultado) {
                try {
                    preguntas.modalTurnado = bootbox.dialog({
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
                                    preguntas.frmTurnado.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    preguntas.modalTurnado.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //inicialización
                        preguntas.frmTurnado = $('#frmTurnado');
                        preguntas.slDependencias = $('#slDependencias');
                        preguntas.cargaDependencias();
                        var select = document.getElementById('slDependencias');
                        multi( select, {
                            dropdownParent: preguntas.modalTurnado,
                            non_selected_header: 'DEPENDENCIAS',
                            selected_header: 'DEPENDENCIAS SELECCIONADAS',
                            search_placeholder: 'Buscar dependencia ...',
                        });
                        //Funcionalidad
                        preguntas.frmTurnado.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                preguntas.guardarTurnado();
                                preguntas.modalTurnado.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página del turnado: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página del turnado.', 'danger', true);
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
            url: general.base_url + '/preguntas/obtenersecretarias',
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
    guardarTurnado: function () {
        var data = {
            txtIdPregunta: $("#txtIdPregunta").val(),
            slDependencias:  preguntas.slDependencias.val(),
        };
        $.ajax({
            type: 'POST',
            url: general.base_url + '/preguntas/guardarturnado',
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
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al realizar el turnado.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    accionesFormatter: function (value, row, index) {
        var url = general.base_url + '/preguntas/perfil/';
        var solicitud = general.base_url + '/solicitudes/perfil/';
        return [
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:preguntas.cargaFrmPregunta(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Información rápida"><i class="glyphicon glyphicon-zoom-in"></i></a>',
           '&nbsp;<a class="btn btn-info btn-lg btn-xs" role="button" href="javascript:preguntas.cargaFrmTurnado(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Turnar Pregunta"><i class="glyphicon glyphicon-link"></i></a>',
        ].join('');
    }
};

preguntas.init();
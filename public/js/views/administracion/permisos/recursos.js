
var recursos = {
    tblRecursos: null,
    btnAgregarRecurso: null,
    modalRecurso: null,
    frmRecurso: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblRecursos = $('#tblRecursos');
        this.btnAgregarRecurso = $('#btnAgregarRecurso');

        //Funcionalidad
        this.tblRecursos.bootstrapTable({
            url: general.base_url + '/recursos/listar'
        });

        this.tblRecursos.on('load-success.bs.table', function (e, data) {
            if (!recursos.tblRecursos.is(':visible')) {
                recursos.tblRecursos.show();
                recursos.tblRecursos.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblRecursos.on('sort.bs.table', function (e, row) {
            if (recursos.tblRecursos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRecursos.on('page-change.bs.table', function (e, row) {
            if (recursos.tblRecursos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRecursos.on('search.bs.table', function (e, row) {
            if (recursos.tblRecursos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRecursos.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (recursos.tblRecursos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRecursos.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los recursos ' + status, 'error', true);
        });
        //Cargamos el modal para agregar/editar el recurso
        this.btnAgregarRecurso.click(function () {
            recursos.cargaFrmRecurso();
        });
    },
    cargaFrmRecurso: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/recursos/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    recursos.modalRecurso = bootbox.dialog({
                        title: 'Recursos',
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
                                    recursos.frmRecurso.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    recursos.modalRecurso.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        recursos.frmRecurso = $('#frmRecurso');

                        //Funcionalidad
                        recursos.frmRecurso.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                recursos.guardarRecurso();
                                recursos.modalRecurso.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página del recurso: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página del recurso.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarRecurso: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/recursos/guardar',
            data: recursos.frmRecurso.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        recursos.tblRecursos.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el recurso: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el recurso.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarRecurso: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el Recurso?",
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
                        url: general.base_url + '/recursos/borrar/?txtIdRecurso=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    recursos.tblRecursos.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el recurso: ' + e + '.', 'error', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el recurso.', 'error', true);
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
    actionFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:recursos.cargaFrmRecurso(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:recursos.borrarRecurso(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

recursos.init();
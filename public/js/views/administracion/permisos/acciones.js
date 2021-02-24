/* global general, bootbox, e */

var acciones = {
    tblAcciones: null,
    btnAgregarAccion: null,
    modalAccion: null,
    frmAccion: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblAcciones = $('#tblAcciones');
        this.btnAgregarAccion = $('#btnAgregarAccion');

        //Funcionalidad
        this.tblAcciones.bootstrapTable({
            url: general.base_url + '/acciones/listar'
        });

        this.tblAcciones.on('load-success.bs.table', function (e, data) {
            if (!acciones.tblAcciones.is(':visible')) {
                acciones.tblAcciones.show();
                acciones.tblAcciones.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblAcciones.on('sort.bs.table', function (e, row) {
            if (acciones.tblAcciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblAcciones.on('page-change.bs.table', function (e, row) {
            if (acciones.tblAcciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblAcciones.on('search.bs.table', function (e, row) {
            if (acciones.tblAcciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblAcciones.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (acciones.tblAcciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblAcciones.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las acciones ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar la acción
        this.btnAgregarAccion.click(function () {
            acciones.cargaFrmAccion();
        });
    },
    cargaFrmAccion: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/acciones/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    acciones.modalAccion = bootbox.dialog({
                        title: '<i class="fa fa-tasks"></i> Edición de Acciones',
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
                                    acciones.frmAccion.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    acciones.modalAccion.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        acciones.frmAccion = $('#frmAccion');

                        //Funcionalidad
                        acciones.frmAccion.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                acciones.guardarAccion();
                                acciones.modalAccion.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de la acción: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de la acción.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarAccion: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/acciones/guardar',
            data: acciones.frmAccion.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        acciones.tblAcciones.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar la acción: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar la acción.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarAccion: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar la acción?",
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
                        url: general.base_url + '/acciones/borrar/?txtIdAccion=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    acciones.tblAcciones.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar la acción: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar la acción.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:acciones.cargaFrmAccion(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Acción"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:acciones.borrarAccion(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Acción"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

acciones.init();
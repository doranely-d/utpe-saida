/* global general, bootbox, e */

var parametros = {
    tblParametros: null,
    btnAgregarParametro: null,
    modalParametro: null,
    frmParametro: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblParametros = $('#tblParametros');
        this.btnAgregarParametro = $('#btnAgregarParametro');

        //Funcionalidad
        this.tblParametros.bootstrapTable({
            url: general.base_url + '/parametros/listar'
        });

        this.tblParametros.on('load-success.bs.table', function (e, data) {
            if (!parametros.tblParametros.is(':visible')) {
                parametros.tblParametros.show();
                parametros.tblParametros.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblParametros.on('sort.bs.table', function (e, row) {
            if (parametros.tblParametros.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblParametros.on('page-change.bs.table', function (e, row) {
            if (parametros.tblParametros.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblParametros.on('search.bs.table', function (e, row) {
            if (parametros.tblParametros.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblParametros.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (parametros.tblParametros.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblParametros.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los parámetros ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar el parámetro
        this.btnAgregarParametro.click(function () {
            parametros.cargaFrmParametro();
        });
    },
    cargaFrmParametro: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/parametros/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    parametros.modalParametro = bootbox.dialog({
                        title: 'Parámetro',
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
                                    parametros.frmParametro.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    parametros.modalParametro.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        parametros.frmParametro = $('#frmParametro');

                        //Funcionalidad
                        parametros.frmParametro.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                parametros.guardarParametro();
                                parametros.modalParametro.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página del parámetro: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página del parámetro:', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarParametro: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/parametros/guardar',
            data: parametros.frmParametro.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        parametros.tblParametros.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el parámetro: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el parámetro.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarParametro: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el parámetro?",
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
                        url: general.base_url + '/parametros/borrar/?txtIdParametro=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    parametros.tblParametros.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el parámetro: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el parámetro.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:parametros.cargaFrmParametro(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Parámetro"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:parametros.borrarParametro(\'' + $.base64.encode(row.ID_PARAMETRO) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Parámetro"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

parametros.init();
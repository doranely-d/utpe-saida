/* global general, bootbox, e */

var temas = {
    tblTemas: null,
    btnAgregarTema: null,
    modalTema: null,
    frmTema: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblTemas = $('#tblTemas');
        this.btnAgregarTema = $('#btnAgregarTema');

        //Funcionalidad
        this.tblTemas.bootstrapTable({
            url: general.base_url + '/temas/listar'
        });

        this.tblTemas.bootstrapTable('resetView');

        this.tblTemas.on('load-success.bs.table', function (e, data) {
            if (!temas.tblTemas.is(':visible')) {
                temas.tblTemas.show();
                temas.tblTemas.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblTemas.on('sort.bs.table', function (e, row) {
            if (temas.tblTemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTemas.on('page-change.bs.table', function (e, row) {
            if (temas.tblTemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTemas.on('search.bs.table', function (e, row) {
            if (temas.tblTemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTemas.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (temas.tblTemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTemas.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los temas ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar el tema
        this.btnAgregarTema.click(function () {
            temas.cargaFrmTema();
        });
    },
    cargaFrmTema: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/temas/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    temas.modalTema = bootbox.dialog({
                        title: 'Temas',
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
                                    temas.frmTema.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    temas.modalTema.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        temas.frmTema = $('#frmTema');

                        //Funcionalidad
                        temas.frmTema.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                temas.guardarTema();
                                temas.modalTema.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de los temas: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de los temas.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarTema: function () {

        $.ajax({
            type: 'POST',
            url: general.base_url + '/temas/guardar',
            data: temas.frmTema.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        temas.tblTemas.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el tema: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el tema.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarTema: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el tema?",
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
                        url: general.base_url + '/temas/borrar/?txtIdTema=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    temas.tblTemas.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el tema: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el tema.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:temas.cargaFrmTema(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Tema"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:temas.borrarTema(\'' + $.base64.encode(row.ID_TEMA) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Tema"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

temas.init();
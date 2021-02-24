
/* MEDIOS DE RESPUESTA DE LAS SOLICITUDES*/

var medios = {
    tblMedios: null,
    btnAgregarMedio: null,
    modalMedio: null,
    frmMedio: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblMedios = $('#tblMedios');
        this.btnAgregarMedio = $('#btnAgregarMedio');

        //Funcionalidad
        this.tblMedios.bootstrapTable({
            url: general.base_url + '/medios/listar'
        });

        this.tblMedios.on('load-success.bs.table', function (e, data) {
            if (!medios.tblMedios.is(':visible')) {
                medios.tblMedios.show();
                medios.tblMedios.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblMedios.on('sort.bs.table', function (e, row) {
            if (medios.tblMedios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMedios.on('page-change.bs.table', function (e, row) {
            if (medios.tblMedios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMedios.on('search.bs.table', function (e, row) {
            if (medios.tblMedios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMedios.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (medios.tblMedios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMedios.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los medios de respuesta ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar el medio de respuesta
        this.btnAgregarMedio.click(function () {
            medios.cargaFrmMedio();
        });
    },
    cargaFrmMedio: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/medios/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    medios.modalMedio = bootbox.dialog({
                        title: '<i class="fa fa-send"></i> Medios de Respuesta',
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
                                    medios.frmMedio.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    medios.modalMedio.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        medios.frmMedio = $('#frmMedio');

                        //Funcionalidad
                        medios.frmMedio.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                medios.guardarMedio();
                                medios.modalMedio.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de los medios de respuesta: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de los medios de respuesta.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarMedio: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/medios/guardar',
            data: medios.frmMedio.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        medios.tblMedios.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el medio de respuesta: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el medio de respuesta.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarMedio: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el medio de respuesta?",
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
                        url: general.base_url + '/medios/borrar/?txtIdMedio=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    medios.tblMedios.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el medio de respuesta: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el medio de respuesta.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:medios.cargaFrmMedio(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Medio de Respuesta"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:medios.borrarMedio(\'' + $.base64.encode(row.ID_MEDIO_RESPUESTA) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Medio de Respuesta"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

medios.init();
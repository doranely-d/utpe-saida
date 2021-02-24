/* global general, bootbox, e */

var diasInhabiles = {
    tblDiasInhabiles: null,
    btnAgregarCalendario: null,
    modalCalendario: null,
    frmCalendario: null,
    dteFecha: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblDiasInhabiles = $('#tblDiasInhabiles');
        this.btnAgregarCalendario = $('#btnAgregarCalendario');

        this.tblDiasInhabiles.bootstrapTable({
            url: general.base_url + '/diasinhabiles/listar'
        });

        this.tblDiasInhabiles.on('load-success.bs.table', function (e, data) {
            if (!diasInhabiles.tblDiasInhabiles.is(':visible')) {
                diasInhabiles.tblDiasInhabiles.show();
                diasInhabiles.tblDiasInhabiles.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblDiasInhabiles.on('sort.bs.table', function (e, row) {
            if (calendario.tblDiasInhabiles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDiasInhabiles.on('page-change.bs.table', function (e, row) {
            if (diasInhabiles.tblDiasInhabiles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDiasInhabiles.on('search.bs.table', function (e, row) {
            if (diasInhabiles.tblDiasInhabiles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDiasInhabiles.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (diasInhabiles.tblDiasInhabiles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDiasInhabiles.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información del diasinhabiles ' + status, 'danger', true);
        });

        this.btnAgregarCalendario.click(function () {
            diasInhabiles.cargaFrmCalendario();
        });
    },
    cargaFrmCalendario: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/diasinhabiles/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    diasInhabiles.modalCalendario = bootbox.dialog({
                        title: 'Días inhábiles',
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
                                    diasInhabiles.frmCalendario.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    diasInhabiles.modalCalendario.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        diasInhabiles.frmCalendario = $('#frmCalendario');
                        diasInhabiles.dteFecha = $('#txtFecha');

                        //Funcionalidad
                        diasInhabiles.dteFecha.datetimepicker({
                            locale: 'es',
                            format: 'L',
                            showTodayButton: false,
                            showClear: true,
                            showClose: true,
                            ignoreReadonly: true,
                            allowInputToggle: false,
                            minDate: new Date(),
                            keepOpen: false,
                            widgetPositioning: {
                                horizontal: 'auto',
                                vertical: 'auto'
                            }
                        });
                        var txtDiaInhabil = $('#txtDiaInhabil').val();
                        var txtIdDiaInhabil = $('#txtIdDiaInhabil').val();

                        if (txtIdDiaInhabil){
                            diasInhabiles.dteFecha.attr('value',txtDiaInhabil);
                        }

                        //Funcionalidad
                        diasInhabiles.frmCalendario.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                diasInhabiles.guardarCalendario();
                                diasInhabiles.modalCalendario.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página del día inhábil: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página del día inhábi.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarCalendario: function () {

        $.ajax({
            type: 'POST',
            url: general.base_url + '/diasinhabiles/guardar',
            data: diasInhabiles.frmCalendario.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        diasInhabiles.tblDiasInhabiles.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el día inhábi: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el día inhábi.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarDiaInhabil: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el día hábil?",
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
                        url:  general.base_url + '/diasinhabiles/borrar/?txtIdDiaInhabil=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    diasInhabiles.tblDiasInhabiles.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el día inhábi: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el día inhábi.', 'danger', true);
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
    inhabilitadoFormatter: function (value, row, index) {
        return '<span class="label label-danger">INHABILITADO</span>';
    },
    actionFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:diasInhabiles.cargaFrmCalendario(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar día inhábil"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:diasInhabiles.borrarDiaInhabil(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar día inhábil"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

diasInhabiles.init();
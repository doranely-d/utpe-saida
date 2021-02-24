/* global general, bootbox, e */

var condiciones = {
    tblCondiciones: null,
    btnAgregarCondicion: null,
    modalCondicion: null,
    frmCondicion: null,
    slFlujo: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblCondiciones = $('#tblCondiciones');
        this.btnAgregarCondicion = $('#btnAgregarCondicion');

        //Funcionalidad
        this.tblCondiciones.bootstrapTable({
            url: general.base_url + '/condiciones/listar'
        });

        this.tblCondiciones.on('load-success.bs.table', function (e, data) {
            if (!condiciones.tblCondiciones.is(':visible')) {
                condiciones.tblCondiciones.show();
                condiciones.tblCondiciones.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblCondiciones.on('sort.bs.table', function (e, row) {
            if (condiciones.tblCondiciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblCondiciones.on('page-change.bs.table', function (e, row) {
            if (condiciones.tblCondiciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblCondiciones.on('search.bs.table', function (e, row) {
            if (condiciones.tblCondiciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblCondiciones.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (condiciones.tblCondiciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblCondiciones.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las condiciones ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar la condición
        this.btnAgregarCondicion.click(function () {
            condiciones.cargaFrmCondicion();
        });
    },
    cargaFrmCondicion: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/condiciones/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    condiciones.modalCondicion = bootbox.dialog({
                        title: '<i class="fa fa-code" aria-hidden="true"></i> Condición en código PHQL',
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
                                    condiciones.frmCondicion.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    condiciones.modalCondicion.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        condiciones.frmCondicion = $('#frmCondicion');
                        condiciones.slFlujo = $('#slFlujo');

                        condiciones.slFlujo.select2({
                            placeholder: 'Selecciona el flujo',
                            language: 'es',
                            dropdownParent: condiciones.modalCondicion,
                        });

                        condiciones.cargaFlujos();

                        var idFlujo = $('#txtIdFlujo').val();

                        if (idFlujo){
                            condiciones.slFlujo.append(new Option($('#txtFlujo').val(), idFlujo, false, false)).trigger('change');
                        }

                        //Funcionalidad
                        condiciones.frmCondicion.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                condiciones.guardarCondicion();
                                condiciones.modalCondicion.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de la condición: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de la condición.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaFlujos: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/condiciones/buscar',
            contentType: 'application/json; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        condiciones.slFlujo.find('option').remove().end().append('<option value="">Selecciona el flujo</option>');
                        //Llenamos slFlujo con los flujos
                        $.each(resultado.datos,function(key,flujo) {
                            condiciones.slFlujo.append('<option value='+flujo.ID_FLUJO+'>'+ flujo.NOMBRE +'</option>');
                        });
                    } else {
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }

                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error carga de los estados: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar los estados.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarCondicion: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/condiciones/guardar',
            data: condiciones.frmCondicion.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        condiciones.tblCondiciones.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar la condición: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar la condición.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarCondicion: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar la condición?",
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
                        url: general.base_url + '/condiciones/borrar/?txtIdCondicion=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    condiciones.tblCondiciones.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar la condición: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar la condición.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:condiciones.cargaFrmCondicion(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Condición"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:condiciones.borrarCondicion(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Condición"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

condiciones.init();
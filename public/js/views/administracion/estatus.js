/* global general, bootbox, e */

var estatus = {
    tblEstatus: null,
    btnAgregarEstatus: null,
    modalEstatus: null,
    frmEstatus: null,
    txtColor: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblEstatus = $('#tblEstatus');
        this.btnAgregarEstatus = $('#btnAgregarEstatus');

        //Funcionalidad
        this.tblEstatus.bootstrapTable({
            url: general.base_url + '/estatus/listar/?opt='+ estatus.urlParam('opt'),
        });

        this.tblEstatus.on('load-success.bs.table', function (e, data) {
            if (!estatus.tblEstatus.is(':visible')) {
                estatus.tblEstatus.show();
                estatus.tblEstatus.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblEstatus.on('sort.bs.table', function (e, row) {
            if (estatus.tblEstatus.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblEstatus.on('page-change.bs.table', function (e, row) {
            if (estatus.tblEstatus.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblEstatus.on('search.bs.table', function (e, row) {
            if (estatus.tblEstatus.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblEstatus.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (estatus.tblEstatus.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblEstatus.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los estatus ' + status, 'danger', true);
        });

        this.btnAgregarEstatus.click(function () {
            estatus.cargaFrmEstatus();
        });
    },

    cargaFrmEstatus: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        $.ajax({
            type: 'GET',
            url: general.base_url + '/estatus/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    estatus.modalEstatus = bootbox.dialog({
                        title: 'Estatus',
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
                                    estatus.frmEstatus.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    estatus.modalEstatus.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();
                        estatus.txtColor = $('#txtColor');
                        estatus.txtColor.colorpicker({
                            customClass: 'colorpicker-2x',
                            format: 'hex',
                            sliders: {
                                saturation: {
                                    maxLeft: 200,
                                    maxTop: 200
                                },
                                hue: {
                                    maxTop: 200
                                },
                                alpha: {
                                    maxTop: 200
                                }
                            }
                        });
                        estatus.txtColor.colorpicker().on('changeColor.colorpicker', function(event){
                            $('#iColor').css("background", event.color.toHex());
                        });

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        estatus.frmEstatus = $('#frmEstatus');

                        //Funcionalidad
                        estatus.frmEstatus.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                estatus.guardarEstatus();
                                estatus.modalEstatus.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página del estatus: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página del estatus.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarEstatus: function () {

        $.ajax({
            type: 'POST',
            url: general.base_url + '/estatus/guardar/?opt='+ estatus.urlParam('opt'),
            data: estatus.frmEstatus.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        estatus.tblEstatus.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el estatus: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el estatus.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarEstatus: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el estatus?",
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
                        url: general.base_url + '/estatus/borrar/?txtIdEstatus=' + id + '&opt=' +estatus.urlParam('opt'),
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    estatus.tblEstatus.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el estatus: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el estatus.', 'danger', true);
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
    urlParam : function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){
            return null;
        }
        else{
            return decodeURI(results[1]) || 0;
        }
    },
    colorFormatter: function (value, row, index) {
        return '<span class="label label-default" style="font-size: 14px; color: #fff; background: ' +row.COLOR + '">'+ row.COLOR + '</span>';
    },
    actionFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:estatus.cargaFrmEstatus(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Estatus"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:estatus.borrarEstatus(\'' + $.base64.encode(row.ID_ESTATUS) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Estatus"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

estatus.init();
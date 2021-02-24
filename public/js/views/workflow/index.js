var workflow = {
    tblFlujos: null,
    btnAgregarFlujo: null,
    modalFlujo: null,
    idFlujo: null,
    frmFlujo: null,
    txtColor: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblFlujos = $('#tblFlujos');
        this.btnAgregarFlujo = $('#btnAgregarFlujo');

        //Funcionalidad
        this.tblFlujos.bootstrapTable({
            url: general.base_url + '/workflow/listar?opt=0' // Cargamos los flujos del sistema
        });

        this.tblFlujos.on('load-success.bs.table', function (e, data) {
            if (!workflow.tblFlujos.is(':visible')) {
                workflow.tblFlujos.show();
                workflow.tblFlujos.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblFlujos.on('sort.bs.table', function (e, row) {
            if (workflow.tblFlujos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblFlujos.on('page-change.bs.table', function (e, row) {
            if (workflow.tblFlujos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblFlujos.on('search.bs.table', function (e, row) {
            if (workflow.tblFlujos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblFlujos.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (workflow.tblFlujos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblFlujos.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al recuperar los flujos ' + status, 'error', true);
        });

        //Cargamos el modal para agregar/editar flujos
        workflow.btnAgregarFlujo.click(function () {
            workflow.cargaFrmFlujo();
        });
    },
    cargaFrmFlujo: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        workflow.idFlujo = (datos !== null) ? parseInt($.trim(datos.ID)) : 0;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/modal/?opt=0', //modal para guardar el flujo
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    workflow.modalFlujo = bootbox.dialog({
                        title: ' Edición de flujo',
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
                                    workflow.frmFlujo.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    workflow.modalFlujo.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        workflow.frmFlujo = $('#frmFlujo');

                        //Funcionalidad
                        workflow.frmFlujo.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                workflow.guardarFlujo();
                                workflow.modalFlujo.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al cargar la página: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al cargar la página.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },

    guardarFlujo: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/workflow/guardar/?opt=0',
            data: workflow.frmFlujo.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        workflow.tblFlujos.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al guardar el flujo: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al guardar el flujo.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarFlujo: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas rechazar el flujo?",
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
                        url: general.base_url + '/workflow/borrar?opt=0&id=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    workflow.tblFlujos.bootstrapTable('refresh');
                                }
                                general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al rechazar el flujo: ' + e + '.', 'error', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al rechazar el flujo.', 'error', true);
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
    aprobarFlujo: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas aprobar el flujo?",
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
                        url: general.base_url + '/workflow/cambiar?txtId=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    workflow.tblFlujos.bootstrapTable('refresh');
                                }
                                general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al aprobar el flujo: ' + e + '.', 'error', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al aprobar el flujo.', 'error', true);
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
    actualizarFlujo: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas actualizar el flujo?",
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
                        type: 'POST',
                        url: general.base_url + '/workflow/guardar?opt=3',
                        data: {txtIdF: id},
                        contentType: 'application/x-www-form-urlencoded',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    console.log( resultado.datos);
                                    window.location = general.base_url + '/workflow/perfil?id=' +  resultado.datos['id_flujo'];
                                }else{
                                    general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                                }
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al rechazar el flujo: ' + e + '.', 'error', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al rechazar el flujo.', 'error', true);
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
    usuarioFormatter: function (value, row, index) {
        return '<span>'+ row.USUARIO_I + '</span> <br> <span> '+ row.FECHA_I + '</span>';
    },
    estadoFormatter: function (value, row, index) {
        if ((row.ESTATUS === 'IN' &&  row.APROBADO === '1')) {
            return '<span class="label label-default">OBSOLETO</span>';
        }else if((row.ESTATUS === 'IN' &&  row.APROBADO === '0')) {
            return '<span class="label label-danger">RECHAZADO</span>';
        }else{
            return (value === '1') ? '<span class="label label-success">APROBADO</span>' : '<span class="label label-danger">INACTIVO</span>';
        }
    },
    actionFormatter: function (value, row, index) {
        if ((row.ESTATUS !== 'IN')){
            return [
                '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:workflow.cargaFrmFlujo(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="top" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>',
                (row.APROBADO !== '1') ? '&nbsp;<a class="btn btn-success btn-lg btn-xs" role="button" href="javascript:workflow.aprobarFlujo(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="fa fa-check"></i></a>' : '',
                (row.APROBADO !== '0') ? '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:workflow.borrarFlujo(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="glyphicon glyphicon-ban-circle"></i></a>' : '',
                '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="' + general.base_url + '/workflow/workflow?id=' + row.ID + '" data-toggle="tooltip" data-placement="bottom" title="Ver flujo"><i class="fa fa-eye"></i></a>',
                (row.APROBADO === '1') ? '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:workflow.actualizarFlujo(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="top" title="Actualizar"><i class="fa fa-sitemap"></i></a>' : '',
                (row.APROBADO === '0') ? '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="' + general.base_url + '/workflow/perfil?id=' + row.ID + '" data-toggle="tooltip" data-placement="bottom" title="Actualizar"><i class="fa fa-sitemap"></i></a>': '',
            ].join('');
        } else if((row.ESTATUS === 'IN' &&  row.APROBADO === '0')){
            return [
                '&nbsp;<a class="btn btn-success btn-lg btn-xs" role="button" href="javascript:workflow.aprobarFlujo(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="fa fa-check"></i></a>',
                '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="' + general.base_url + '/workflow/workflow?id=' + row.ID + '" data-toggle="tooltip" data-placement="bottom" title="Ver flujo"><i class="fa fa-eye"></i></a>'].join('');
        } else if((row.ESTATUS === 'IN' &&  row.APROBADO === '1')){
            return '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="' + general.base_url + '/workflow/workflow?id=' + row.ID + '" data-toggle="tooltip" data-placement="bottom" title="Ver flujo"><i class="fa fa-eye"></i></a>';
        }
    }
};

workflow.init();
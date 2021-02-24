/* global general, bootbox, e */

var roles = {
    tblRoles: null,
    btnAgregarRol: null,
    modalRol: null,
    frmRol: null,
    idRol: null,
    txtRecurso: null,
    txtInfoRecurso: null,
    tblRecursos: null,
    frmRecurso: null,
    txtMenu: null,
    txtInfoMenu: null,
    tblMenu: null,
    frmMenu: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblRoles = $('#tblRoles');
        this.btnAgregarRol = $('#btnAgregarRol');

        //Funcionalidad
        this.tblRoles.bootstrapTable({
            url: general.base_url + '/roles/listar'
        });

        this.tblRoles.on('load-success.bs.table', function (e, data) {
            if (!roles.tblRoles.is(':visible')) {
                roles.tblRoles.show();
                roles.tblRoles.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblRoles.on('sort.bs.table', function (e, row) {
            if (roles.tblRoles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRoles.on('page-change.bs.table', function (e, row) {
            if (roles.tblRoles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRoles.on('search.bs.table', function (e, row) {
            if (roles.tblRoles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRoles.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (roles.tblRoles.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblRoles.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al recuperar la información de los roles ' + status, 'danger', true);
        });

        this.btnAgregarRol.click(function () {
            roles.cargaFrmRol();
        });
    },
    cargaFrmRol: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        roles.idRol = (datos !== null) ? parseInt($.trim(datos.ID)) : 0;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/roles/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    roles.modalRol = bootbox.dialog({
                        title: '<i class="fa fa-address-card"></i> Edición de Roles',
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
                                    roles.frmRol.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    roles.modalRol.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        roles.frmRol = $('#frmRol');
                        roles.txtRecurso = $('#txtRecurso');
                        roles.txtInfoRecurso = $('#txtInfoRecurso');
                        roles.tblRecursos = $('#tblRecursos');
                        roles.frmRecurso = $('#frmRecurso');
                        roles.txtMenu = $('#txtMenu');
                        roles.txtInfoMenu = $('#txtInfoMenu');
                        roles.tblMenu = $('#tblMenu');
                        roles.frmMenu = $('#frmMenu');

                        //Funcionalidad
                        roles.frmRol.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                if (roles.tblRecursos.bootstrapTable('getOptions').totalRows > 0 && roles.tblMenu.bootstrapTable('getOptions').totalRows > 0) {
                                    roles.guardarRol();
                                    roles.modalRol.modal('hide');
                                } else {
                                    general.notify('<strong>Alerta</strong><br />', 'Debes seleccionar los recursos y el menu del rol.', 'warning', true);
                                }
                            });

                        roles.txtRecurso.typeahead({
                            showHintOnFocus: true,
                            items: 50,
                            delay: 1000,
                            source: function (query, process) {
                                map = null;
                                roles.txtInfoRecurso.val('');

                                if ($.trim(query) !== '') {
                                    $.ajax({
                                        url: general.base_url + '/roles/buscar/?opt=0',
                                        type: 'GET',
                                        data: {txtNombre: query},
                                        contentType: 'application/json; charset=utf-8',
                                        success: function (result) {
                                            map = {};
                                            objects = [];

                                            $.each(result.datos, function (i, object) {
                                                map[$.trim(object.ID)] = object;
                                                objects.push($.trim(object.NOMBRE));
                                            });

                                            process(objects);
                                        }
                                    });
                                }
                            },
                            updater: function (item) {
                                if (map !== null) {
                                    $.each(map, function (key, value) {
                                        if (value.NOMBRE === item) {
                                            roles.txtInfoRecurso.val(key + '|' + $.trim(map[key].NOMBRE));
                                            roles.frmRecurso
                                                .formValidation('revalidateField', 'txtRecurso')
                                                .formValidation('revalidateField', 'txtInfoRecurso');
                                            return false;
                                        }
                                    });
                                } else {
                                    item = '';
                                }
                                return item;
                            }
                        });

                        roles.tblRecursos.bootstrapTable({
                            uniqueId: 'ID'
                        });
                        roles.tblRecursos.bootstrapTable('resetView');

                        roles.frmRecurso.formValidation({excluded: [':disabled'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                roles.agregarRecurso($.trim(roles.txtInfoRecurso.val()), $.trim(roles.txtRecurso.val()));
                            });

                        roles.txtMenu.typeahead({
                            showHintOnFocus: true,
                            items: 50,
                            delay: 1000,
                            source: function (query, process) {
                                map = null;
                                roles.txtInfoMenu.val('');

                                if ($.trim(query) !== '') {
                                    $.ajax({
                                        url: general.base_url + '/roles/buscar?opt=3',
                                        type: 'GET',
                                        data: {txtNombre: query},
                                        contentType: 'application/json; charset=utf-8',
                                        success: function (result) {
                                            map = {};
                                            objects = [];

                                            $.each(result.datos, function (i, object) {
                                                map[$.trim(object.ID_MENU)] = object;
                                                objects.push($.trim(object.NOMBRE));
                                            });

                                            process(objects);
                                        }
                                    });
                                }
                            },
                            updater: function (item) {
                                if (map !== null) {
                                    $.each(map, function (key, value) {
                                        if (value.NOMBRE === item) {
                                            roles.txtInfoMenu.val(key + '|' + $.trim(map[key].NOMBRE));
                                            roles.frmMenu
                                                .formValidation('revalidateField', 'txtMenu')
                                                .formValidation('revalidateField', 'txtInfoMenu');
                                            return false;
                                        }
                                    });
                                } else {
                                    item = '';
                                }
                                return item;
                            }
                        });

                        roles.tblMenu.bootstrapTable({
                            uniqueId: 'ID_MENU'
                        });
                        roles.tblMenu.bootstrapTable('resetView');

                        roles.frmMenu.formValidation({excluded: [':disabled'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                roles.agregarMenu($.trim(roles.txtInfoMenu.val()), $.trim(roles.txtMenu.val()));
                            });

                        if (roles.idRol > 0) {
                            roles.cargaTablaRecurso();
                        }
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al cargar la página de rol: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al cargar la página de rol.', 'danger', true);
                }, 500);
            },
            complete: function () {
                if (roles.idRol === 0) {
                    general.unblock();
                }
            }
        });
    },
    cargaTablaRecurso: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/roles/buscar?opt=1',
            data: {idRol: roles.idRol},
            contentType: 'application/json; charset=utf-8',
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        roles.tblRecursos.bootstrapTable({});
                        roles.tblRecursos.bootstrapTable('load', resultado.datos);
                        roles.tblRecursos.bootstrapTable('selectPage', 1);
                    } else {
                        roles.tblRecursos.bootstrapTable({});
                        general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                    }

                    roles.tblRecursos.bootstrapTable('resetView');
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error carga el recurso ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al cargar el recurso.', 'danger', true);
                }, 500);
            },
            complete: function () {
                roles.cargaTablaMenu();
            }
        });
    },
    cargaTablaMenu: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/roles/buscar?opt=4',
            data: {idRol: roles.idRol},
            contentType: 'application/json; charset=utf-8',
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        roles.tblMenu.bootstrapTable({});
                        roles.tblMenu.bootstrapTable('load', resultado.datos);
                        roles.tblMenu.bootstrapTable('selectPage', 1);
                    } else {
                        roles.tblMenu.bootstrapTable({});
                        general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                    }

                    roles.tblMenu.bootstrapTable('resetView');
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error carga de los items del menú: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al cargar los items del menú.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarRol: function () {
        var form = roles.frmRol.serializeArray();

        var data = {
            id: form[0]['value'],
            rol: form[1]['value'],
            descripcion: form[2]['value'],
            recursos: roles.tblRecursos.bootstrapTable('getData'),
            menu: roles.tblMenu.bootstrapTable('getData')
        };

        $.ajax({
            type: 'POST',
            url: general.base_url + '/roles/guardar',
            data: JSON.stringify(data),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        roles.tblRoles.bootstrapTable('refresh');
                    }

                    general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al guardar el rol: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al guardar el rol.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarRol: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el rol?",
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
                        url: general.base_url + '/roles/borrar/?txtIdRol=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    roles.tblRoles.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al borrar el rol: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al borrar el rol.', 'danger', true);
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
    agregarRecurso: function (datos, recurso) {
        var datosRecurso = datos.split("|");

        if (roles.tblRecursos.bootstrapTable('getRowByUniqueId', datosRecurso[0]) === null) {
            roles.tblRecursos.bootstrapTable('insertRow', {
                index: datosRecurso[0],
                row: {
                    ID: datosRecurso[0],
                    NOMBRE: recurso,
                    DESCRIPCION: datosRecurso[1]
                }
            });
        } else {
            general.notify('<strong>Alerta</strong><br />', 'El recurso seleccionado ya se ha agregado previamente.', 'warning', true);
        }

        roles.txtInfoRecurso.val('');
        roles.txtRecurso.val('');
        roles.frmRecurso.data('formValidation')
            .resetField('txtInfoRecurso', '')
            .resetField('txtRecurso', '');
    },
    quitarRecurso: function (id) {
        id = $.base64.decode(id);

        if (roles.tblRecursos.bootstrapTable('getRowByUniqueId', id) !== null) {
            roles.tblRecursos.bootstrapTable('removeByUniqueId', id);
        } else {
            general.notify('<strong>Alerta</strong><br />', 'El recurso seleccionado no se ha agregado.', 'warning', true);
        }
    },
    agregarMenu: function (datos, menu) {
        var datosMenu = datos.split("|");

        if (roles.tblMenu.bootstrapTable('getRowByUniqueId', datosMenu[0]) === null) {
            roles.tblMenu.bootstrapTable('insertRow', {
                index: datosMenu[0],
                row: {
                    ID_MENU: datosMenu[0],
                    NOMBRE: menu,
                    DESCRIPCION: datosMenu[1]
                }
            });
        } else {
            general.notify('<strong>Alerta</strong><br />', 'El menu seleccionado ya se ha agregado previamente.', 'warning', true);
        }

        roles.txtInfoMenu.val('');
        roles.txtMenu.val('');
        roles.frmMenu.data('formValidation')
            .resetField('txtInfoMenu', '')
            .resetField('txtMenu', '');
    },
    quitarMenu: function (id) {
        id = $.base64.decode(id);

        if (roles.tblMenu.bootstrapTable('getRowByUniqueId', id) !== null) {
            roles.tblMenu.bootstrapTable('removeByUniqueId', id);
        } else {
            general.notify('<strong>Alerta</strong><br />', 'El menu seleccionado no se ha agregado.', 'warning', true);
        }
    },
    actionFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:roles.cargaFrmRol(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="top" title="Editar Rol"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:roles.borrarRol(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="top" title="Borrar Rol"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
    menuFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:roles.quitarMenu(\'' + $.base64.encode(row.ID_MENU) + '\');" data-toggle="tooltip" data-placement="top" title="Borrar Menú"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
    recursoFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:roles.quitarRecurso(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="top" title="Borrar Recurso"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

roles.init();
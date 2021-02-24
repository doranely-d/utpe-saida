
var menu = {
    tblMenu: null,
    btnAgregarMenu: null,
    modalMenu: null,
    frmMenu: null,
    slPadre : null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblMenu = $('#tblMenu');
        this.btnAgregarMenu = $('#btnAgregarMenu');

        //Funcionalidad
        this.tblMenu.bootstrapTable({
            url: general.base_url + '/menus/listar'
        });

        this.tblMenu.on('load-success.bs.table', function (e, data) {
            if (!menu.tblMenu.is(':visible')) {
                menu.tblMenu.show();
                menu.tblMenu.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblMenu.on('sort.bs.table', function (e, row) {
            if (menu.tblMenu.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMenu.on('page-change.bs.table', function (e, row) {
            if (menu.tblMenu.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMenu.on('search.bs.table', function (e, row) {
            if (menu.tblMenu.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMenu.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (menu.tblMenu.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblMenu.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información del menú ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar el menú
        this.btnAgregarMenu.click(function () {
            menu.cargaFrmMenu();
        });
    },
    cargaFrmMenu: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/menus/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    menu.modalMenu = bootbox.dialog({
                        title: '<i class="fa fa-th-list"></i> Menú',
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
                                    menu.frmMenu.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    menu.modalMenu.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        menu.frmMenu = $('#frmMenu');
                        menu.slPadre = $('#slPadre');

                        //Carga de los items del menú
                        menu.slPadre.select2({
                            placeholder: 'Selecciona una opción',
                            language: 'es',
                            dropdownParent: menu.modalMenu,
                            ajax: {
                                url: general.base_url + '/menus/buscar',
                                type: 'GET',
                                contentType: 'application/json; charset=utf-8',
                                delay: 25,
                                data: function (params) {
                                    return {
                                        txtNombre: params.term
                                    };
                                },
                                processResults: function (data, params) {
                                    return {
                                        results: $.map(data.datos, function (item) {
                                            return {
                                                text: item.NOMBRE,
                                                id: item.ID_MENU
                                            };
                                        })
                                    };
                                },
                                cache: true
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            minimumInputLength: 2
                        });

                        //carga el valor del slTema
                        var idMenu = $('#txtIdPadre').val();
                        var nombre = $('#txtPadre').val();

                        if (idMenu){
                            menu.slPadre.append(new Option(nombre, idMenu, false, false)).trigger('change');
                        }

                        //Funcionalidad
                        menu.frmMenu.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                menu.guardarMenu();
                                menu.modalMenu.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página del menú: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página del menú.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarMenu: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/menus/guardar',
            data: menu.frmMenu.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        menu.tblMenu.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el menú: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el menú.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarMenu: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el items del menú?",
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
                        url: general.base_url + '/menus/borrar/?txtIdMenu=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    menu.tblMenu.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el item del menú: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el item del menú.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:menu.cargaFrmMenu(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Menú"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:menu.borrarMenu(\'' + $.base64.encode(row.ID_MENU) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Menú"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

menu.init();
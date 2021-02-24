/* global general, bootbox, e */

var titulos = {
    tblTitulo: null,
    btnAgregarTitulo: null,
    modalTitulo: null,
    frmTitulo: null,
    slSubtema: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblTitulo = $('#tblTitulo');
        this.btnAgregarTitulo = $('#btnAgregarTitulo');

        //Funcionalidad
        this.tblTitulo.bootstrapTable({
            url: general.base_url + '/titulos/listar'
        });
        this.tblTitulo.bootstrapTable('resetView');

        this.tblTitulo.on('load-success.bs.table', function (e, data) {
            if (!titulos.tblTitulo.is(':visible')) {
                titulos.tblTitulo.show();
                titulos.tblTitulo.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblTitulo.on('sort.bs.table', function (e, row) {
            if (titulos.tblTitulo.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTitulo.on('page-change.bs.table', function (e, row) {
            if (titulos.tblTitulo.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTitulo.on('search.bs.table', function (e, row) {
            if (titulos.tblTitulo.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTitulo.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (titulos.tblTitulo.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblTitulo.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los títulos ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar el título
        this.btnAgregarTitulo.click(function () {
            titulos.cargaFrmTitulo();
        });
    },
    cargaFrmTitulo: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/titulos/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    titulos.modalTitulo = bootbox.dialog({
                        title: 'Títulos',
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
                                    titulos.frmTitulo.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    titulos.modalTitulo.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        titulos.frmTitulo = $('#frmTitulo');
                        titulos.slSubtema = $('#slSubtema');

                        //Carga de los subtemas en select
                        titulos.slSubtema.select2({
                            placeholder: 'Selecciona una opción',
                            language: 'es',
                            dropdownParent: titulos.modalTitulo,
                            ajax: {
                                url: general.base_url + '/titulos/buscar',
                                type: 'GET',
                                contentType: 'application/json; charset=utf-8',
                                delay: 25,
                                data: function (params) {
                                    return {
                                        txtSubtema: params.term
                                    };
                                },
                                processResults: function (data, params) {
                                    return {
                                        results: $.map(data.datos, function (item) {
                                            return {
                                                text: item.SUBTEMA,
                                                id: item.ID_SUBTEMA
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

                        //carga el valor del slSubtema
                        var idSubtema = $('#txtIdSubtema').val();
                        var subtema = $('#txtSubtema').val();

                        if (idSubtema){
                            titulos.slSubtema.append(new Option(subtema, idSubtema, false, false)).trigger('change');
                        }

                        //Funcionalidad
                        titulos.frmTitulo.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                titulos.guardarTitulo();
                                titulos.modalTitulo.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de los títulos: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de los títulos.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarTitulo: function () {

        $.ajax({
            type: 'POST',
            url: general.base_url + '/titulos/guardar',
            data: titulos.frmTitulo.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        titulos.tblTitulo.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el título: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el título.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarTitulo: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el título?",
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
                        url: general.base_url + '/titulos/borrar/?txtIdTitulo=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    titulos.tblTitulo.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el título: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el título.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:titulos.cargaFrmTitulo(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar título"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:titulos.borrarTitulo(\'' + $.base64.encode(row.ID_TITULO) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar título"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

titulos.init();
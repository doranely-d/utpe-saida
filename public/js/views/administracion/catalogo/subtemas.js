/* global general, bootbox, e */

var subtemas = {
    tblSubtemas: null,
    btnAgregarSubtema: null,
    modalSubtema: null,
    frmSubtema: null,
    slTema : null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblSubtemas = $('#tblSubtemas');
        this.btnAgregarSubtema = $('#btnAgregarSubtema');

        //Funcionalidad
        this.tblSubtemas.bootstrapTable({
            url: general.base_url + '/subtemas/listar'
        });

        this.tblSubtemas.on('load-success.bs.table', function (e, data) {
            if (!subtemas.tblSubtemas.is(':visible')) {
                subtemas.tblSubtemas.show();
                subtemas.tblSubtemas.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblSubtemas.on('sort.bs.table', function (e, row) {
            if (subtemas.tblSubtemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSubtemas.on('page-change.bs.table', function (e, row) {
            if (subtemas.tblSubtemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSubtemas.on('search.bs.table', function (e, row) {
            if (subtemas.tblSubtemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSubtemas.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (subtemas.tblSubtemas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSubtemas.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los subtemas ' + status, 'danger', true);
        });
        //Cargamos el modal para agregar/editar el subtema
        this.btnAgregarSubtema.click(function () {
            subtemas.cargaFrmSubtema();
        });
    },
    cargaFrmSubtema: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/subtemas/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    subtemas.modalSubtema = bootbox.dialog({
                        title: 'Subtemas',
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
                                    subtemas.frmSubtema.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    subtemas.modalSubtema.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        subtemas.frmSubtema = $('#frmSubtema');
                        subtemas.slTema = $('#slTema');

                        //Carga de los temas en select
                        subtemas.slTema.select2({
                            placeholder: 'Selecciona una opción',
                            language: 'es',
                            dropdownParent: subtemas.modalSubtema,
                            ajax: {
                                url: general.base_url + '/subtemas/buscar',
                                type: 'GET',
                                contentType: 'application/json; charset=utf-8',
                                delay: 25,
                                data: function (params) {
                                    return {
                                        txtTema: params.term
                                    };
                                },
                                processResults: function (data, params) {
                                    return {
                                        results: $.map(data.datos, function (item) {
                                            return {
                                                text: item.TEMA,
                                                id: item.ID_TEMA
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
                       var idTema = $('#txtIdTema').val();
                       var tema = $('#txtTema').val();

                       if (idTema){
                           subtemas.slTema.append(new Option(tema, idTema, false, false)).trigger('change');
                         }
                        //Funcionalidad
                        subtemas.frmSubtema.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                subtemas.guardarSubtema();
                                subtemas.modalSubtema.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de los subtemas: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de los subtemas.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarSubtema: function () {

        $.ajax({
            type: 'POST',
            url: general.base_url + '/subtemas/guardar',
            data: subtemas.frmSubtema.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        subtemas.tblSubtemas.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el subtema: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el subtema.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarSubtema: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el subtemas?",
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
                        url: general.base_url + '/subtemas/borrar/?txtIdSubtema=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    subtemas.tblSubtemas.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el subtema: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el subtema.', 'danger', true);
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
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:subtemas.cargaFrmSubtema(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Subtema"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:subtemas.borrarSubtema(\'' + $.base64.encode(row.ID_SUBTEMA) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Subtema"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    }
};

subtemas.init();
/* global general, bootbox, e */

var documentos = {
    tblDocumentos: null,
    btnAgregarDocumento: null,
    modalDocumento: null,
    frmDocumento: null,
    inpDocumento : null,
    txtIdDocumento: null,
    txtNombreDoc: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblDocumentos = $('#tblDocumentos');
        this.btnAgregarDocumento = $('#btnAgregarDocumento');

        //Funcionalidad
        this.tblDocumentos.bootstrapTable({
            url: general.base_url + '/documentos/listar'
        });

        this.tblDocumentos.on('load-success.bs.table', function (e, data) {
            if (!documentos.tblDocumentos.is(':visible')) {
                documentos.tblDocumentos.show();
                documentos.tblDocumentos.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblDocumentos.on('sort.bs.table', function (e, row) {
            if (documentos.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDocumentos.on('page-change.bs.table', function (e, row) {
            if (documentos.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDocumentos.on('search.bs.table', function (e, row) {
            if (documentos.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDocumentos.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (documentos.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDocumentos.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los documentos ' + status, 'danger', true);
        });

        this.btnAgregarDocumento.click(function () {
            documentos.cargaFrmDocumento();
        });
    },
    cargaFrmDocumento: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/documentos/modal',
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    documentos.modalDocumento = bootbox.dialog({
                        title:  '<i class="fa fa-upload" aria-hidden="true"></i> Anexo de documentos',
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
                                    documentos.frmDocumento.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    documentos.modalDocumento.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        documentos.frmDocumento = $('#frmDocumento');
                        documentos.inpDocumento = $("#inpDocumento");
                        documentos.txtIdDocumento = $("#txtIdDocumento");
                        documentos.txtNombreDoc = $("#txtNombreDoc");

                        documentos.inpDocumento.fileinput({
                            showPreview: false,
                            showUpload: false,
                            language: "es",
                            elErrorContainer: '#kartik-file-errors',
                            allowedFileExtensions: general.obtenerExtensionDoc(),
                            uploadUrl: '/documentos/guardar'
                        });

                        //Funcionalidad
                        documentos.frmDocumento.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();

                                documentos.guardarDocumento();
                                documentos.modalDocumento.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de los documentos: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de los documentos.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarDocumento: function () {

        var formData = new FormData();
        formData.append("inpDocumento", documentos.inpDocumento[0].files[0]);
        formData.append("idDocumento", documentos.txtIdDocumento.val());
        formData.append("txtNombre", documentos.txtNombreDoc.val());
        formData.append("opt", '1');

        $.ajax({
            url: general.base_url + '/documentos/guardar',
            method: 'POST',
            contentType: false,
            dataType: 'json',
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            cache: false,
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        documentos.tblDocumentos.bootstrapTable('refresh');
                    }
                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el documento: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el documento.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarDocumento: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el documento?",
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
                        url: general.base_url + '/documentos/borrar/?txtIdDocumento=' + id + '&opt=1', //Opción para borrar documento
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    documentos.tblDocumentos.bootstrapTable('refresh');
                                }

                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el documento: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el documento.', 'danger', true);
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
    nombreDocFormatter: function (value, row, index) {
        return row.NOMBRE + '.' + row.EXTENSION;
    },
    numRowFormatter: function (value, row, index) {
        return 1+index;
    },
    actionFormatter: function (value, row) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:documentos.cargaFrmDocumento(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Documento"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:documentos.borrarDocumento(\'' + $.base64.encode(row.ID_DOCUMENTO) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Documento"><i class="glyphicon glyphicon-trash"></i></a>',
            '&nbsp;<a class="btn btn-success btn-lg btn-xs" role="button" href="javascript:general.urlDocumento(\''+$.base64.encode(row.ID_DOCUMENTO)+'\',\'1\');" data-toggle="tooltip" data-placement="bottom" title="Descargar Documento"><i class="glyphicon glyphicon-download-alt"></i></a>'
        ].join('');
    }
};

documentos.init();
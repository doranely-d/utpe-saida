/* global general, bootbox, e */

var preguntas = {
    tblDependencias:null,
    tblHistorial:  null,
    tblComentarios:null,
    btnRegresar: null,
    modalComentario: null,
    frmComentario: null,
    txtIdPregunta:null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblDependencias = $('#tblDependencias');
        this.tblHistorial = $('#tblHistorial');
        this.tblComentarios = $('#tblComentarios');
        this.btnRegresar = $('#btnRegresar');
        this.modalComentario = $('#modalComentario');
        this.frmComentario = $('#frmComentario');
        this.txtIdPregunta = $('#txtIdPregunta');

        //Cargar las dependencias de la pregunta
        preguntas.cargaDependencias();

        //regresar a la página anterior
        this.btnRegresar.click(function () {
            window.history.back();
        });
    },
    cargaDependencias: function () {
        preguntas.tblDependencias = $('#tblDependencias');

        preguntas.tblDependencias.bootstrapTable({
            url: general.base_url + '/preguntas/listar?opt=4&id=' + preguntas.txtIdPregunta.val(),
        });
        preguntas.tblDependencias.on('load-success.bs.table', function (e, data) {
            if (!preguntas.tblDependencias.is(':visible')) {
                preguntas.tblDependencias.show();
                preguntas.tblDependencias.bootstrapTable('resetView');
            }
            general.unblock();
            preguntas.cargaHistorial();
        });

        preguntas.tblDependencias.on('sort.bs.table', function (e, row) {
            if (preguntas.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblDependencias.on('page-change.bs.table', function (e, row) {
            if (preguntas.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblDependencias.on('search.bs.table', function (e, row) {
            if (preguntas.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblDependencias.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (preguntas.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblDependencias.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las dependencias ' + status, 'danger', true);
        });
    },
    cargaHistorial: function () {
        preguntas.tblHistorial = $('#tblHistorial');

        preguntas.tblHistorial.bootstrapTable({
            url: general.base_url + '/preguntas/listar?opt=3&id=' + preguntas.txtIdPregunta.val(),
        });
        preguntas.tblHistorial.on('load-success.bs.table', function (e, data) {
            if (!preguntas.tblHistorial.is(':visible')) {
                preguntas.tblHistorial.show();
                preguntas.tblHistorial.bootstrapTable('resetView');
            }
            general.unblock();
            preguntas.cargaComentarios();
        });

        preguntas.tblHistorial.on('sort.bs.table', function (e, row) {
            if (preguntas.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblHistorial.on('page-change.bs.table', function (e, row) {
            if (preguntas.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblHistorial.on('search.bs.table', function (e, row) {
            if (preguntas.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblHistorial.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (preguntas.tblHistorial.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblHistorial.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información del historial ' + status, 'danger', true);
        });
    },
    cargaComentarios: function () {
        preguntas.tblComentarios = $('#tblComentarios');

        preguntas.tblComentarios.bootstrapTable({
            url: general.base_url + '/preguntas/listar?opt=2&id=' + preguntas.txtIdPregunta.val(),
        });
        preguntas.tblComentarios.on('load-success.bs.table', function (e, data) {
            if (!preguntas.tblComentarios.is(':visible')) {
                preguntas.tblComentarios.show();
                preguntas.tblComentarios.bootstrapTable('resetView');
            }
            general.unblock();
        });

        preguntas.tblComentarios.on('sort.bs.table', function (e, row) {
            if (preguntas.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblComentarios.on('page-change.bs.table', function (e, row) {
            if (preguntas.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblComentarios.on('search.bs.table', function (e, row) {
            if (preguntas.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblComentarios.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (preguntas.tblComentarios.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        preguntas.tblComentarios.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los comentarios. ' + status, 'danger', true);
        });
    },

};

preguntas.init();
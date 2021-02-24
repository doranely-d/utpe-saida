/* global general, bootbox, e */

var solicitudes = {
    tblSolicitudes: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblSolicitudes = $('#tblSolicitudes');

        //Funcionalidad
        this.tblSolicitudes.bootstrapTable({
            url: general.base_url + '/solicitudes/listar',
        });

        this.tblSolicitudes.on('load-success.bs.table', function (e, data) {
            if (!solicitudes.tblSolicitudes.is(':visible')) {
                solicitudes.tblSolicitudes.show();
                solicitudes.tblSolicitudes.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblSolicitudes.on('sort.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.on('page-change.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.on('search.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitudes.tblSolicitudes.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblSolicitudes.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error' + status, 'danger', true);
        });
    },
    accionesFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmPregunta(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Información rápida"><i class="glyphicon glyphicon-zoom-in"></i></a>',
            '&nbsp;<a class="btn btn-primary btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmTurnado(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Turnar Pregunta"><i class="glyphicon glyphicon-link"></i></a>',
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmComentarios(\'' + $.base64.encode(JSON.stringify(row))+'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Comentarios"><i class="glyphicon glyphicon-comment"></i></a>'
        ].join('');
    },
};

solicitudes.init();
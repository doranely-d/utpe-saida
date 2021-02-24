/* global general, bootbox, e */

var solicitudes = {
    tblSolicitudes: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblSolicitudes = $('#tblSolicitudes');

        //Funcionalidad
        this.tblSolicitudes.bootstrapTable({
            url: general.base_url + '/estrados/listar',
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
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las acciones ' + status, 'danger', true);
        });

    },
    estadoFormatter: function (value, row, index) {
        return '<span class="label label-default" style="color: #fff;background: ' +row.COLOR_ESTADO + '">'+ row.ESTADO.toUpperCase() + '</span>';
    },
    documentoFormatter: function (value, row, index) {
        return '<a class="btn btn-success btn-lg btn-xs" role="button" href="javascript:general.urlDocumento(\''+$.base64.encode(row.ID_DOCUMENTO)+'\',\'2\');" data-toggle="tooltip" ' +
            'data-placement="bottom" title="Descargar Documento">'+  value + ' <i class="glyphicon glyphicon-download-alt"></i></a>';
    },
};

solicitudes.init();
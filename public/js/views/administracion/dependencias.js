/* global general, bootbox, e */

var dependencias = {
    tblDependencias: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.tblDependencias = $('#tblDependencias');

        //Funcionalidad
        this.tblDependencias.bootstrapTable({
            url: general.base_url + '/dependencias/listar'
        });

        this.tblDependencias.on('load-success.bs.table', function (e, data) {
            if (!dependencias.tblDependencias.is(':visible')) {
                dependencias.tblDependencias.show();
                dependencias.tblDependencias.bootstrapTable('resetView');
            }
            general.unblock();
        });

        this.tblDependencias.on('sort.bs.table', function (e, row) {
            if (dependencias.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDependencias.on('page-change.bs.table', function (e, row) {
            if (dependencias.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDependencias.on('search.bs.table', function (e, row) {
            if (dependencias.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDependencias.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (dependencias.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        this.tblDependencias.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las dependencias ' + status, 'danger', true);
        });

    },
    jerarquiaFormatter:function (value, row, index) {
        //obtenemos el nombre de la jerarquia
        var valor = '';
        if(value === '50'){
            valor = 'DEPARTAMENTO';
        }else if(value === '14'){
            valor = 'DIRECCIÓN';
        }else if(value === '18'){
            valor = 'SUB SECRETARIA';
        } else if(value === '17'){
            valor = 'SECRETARIA';
        }else{
            valor = 'SECTOR';
        }
        return valor;
    }
};

dependencias.init();
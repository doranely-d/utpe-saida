var workflowP = {
    btnRegresar: null,
    txtIdFlujo: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.btnRegresar = $('#btnRegresar');
        this.txtIdFlujo = $('#txtIdFlujo');

        //iniciamos el flujo
        window.onload = function(){
            initPageObjects();
        };

        workflowP.cargaFlujo();

        //regresar a la página anterior
        this.btnRegresar.click(function () {
            window.history.back();
        });

    },
    cargaFlujo: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/buscar?opt=4&id=' + workflowP.txtIdFlujo.val(),
            contentType: 'application/json; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        $('#mainC').html('');

                        $("<div>", {'class': 'canvas', 'id': 'mainCanvas'}).append().hide().appendTo('#mainC').fadeIn('slow');

                        $('#mainCanvas').append('<div class="block draggable draggable-principal" id="eInicio" style="left: 50px; top:40px;">' +
                            '<div class="canvas-box-content text-center"><i class="fa fa-play-circle fa-2x text-green" aria-hidden="true"></i>' +
                            '<span class="canvas-box-text">Inicio</span></div></div>');

                        $.each(resultado.datos[0],function(key, etapa ) {
                            var left = Math.floor(Math.random() * (80-150));
                            $('#mainCanvas').append('<div class="block draggable draggable-etapa" id="'+etapa[0]+'" style="left: '+etapa[3]+'px; top:'+etapa[4]+'px; background:'+etapa[2]+';">' +
                                '<div class="canvas-box-content"><span class="canvas-box-text">'+etapa[1]+'</span></div></div>');
                        });
                        $.each(resultado.datos[1],function(key, transaccion ) {
                            $('#mainCanvas').append('<div class="connector '+transaccion.T1+' '+transaccion.T2+'"><label class="middle-label">'+transaccion.nombre+'</label></div>');
                        });

                        $.each(resultado.datos[2],function(key, etapa) {
                            $('#mainCanvas').append('<div class="connector '+etapa.ID+' eInicio"><label class="middle-label"></label></div>');
                        });

                        $.each(resultado.datos[3],function(key, etapa) {
                            $('#mainCanvas').append('<div class="block draggable draggable-condicion" id="'+etapa[0]+'" style="left: '+etapa[3]+'px; top:'+etapa[4]+'px; background:'+etapa[2]+';">' +
                                '<div class="canvas-box-content"><span class="canvas-box-text">'+etapa[1]+'</span></div></div>');
                        });

                        initPageObjects();
                    } else {
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }

                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
};

workflowP.init();
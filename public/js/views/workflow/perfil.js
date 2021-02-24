var workflowP = {
    btnEtapa: null,
    btnRegresar: null,
    idFlujo: null,
    modalEtapa: null,
    modalTransaccion: null,
    modalTransacciones: null,
    frmEtapa: null,
    frmTransaccion: null,
    frmTransacciones: null,
    frmRol: null,
    txtIdFlujo: null,
    txtIdEtapa: null,
    slEtapa: null,
    slAccion: null,
    slCondicion: null,
    slPrevencion: null,
    slNotificacion: null,
    tblEtapas: null,
    tblTransacciones:null,
    tblRoles:null,
    txtColor:null,
    txtColorEstado:null,
    txtRol: null,
    txtInfoRol: null,
    idTransaccion: null,
    txtDiasUtpe: null,
    txtDiasLey: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.btnRegresar = $('#btnRegresar');
        this.btnEtapa = $('#btnEtapa');
        this.txtIdFlujo = $('#txtIdFlujo');
        this.txtIdEtapa = $('#txtIdEtapa');
        this.tblEtapas = $('#tblEtapas');
        this.txtDiasUtpe = $('#txtDiasUtpe');
        this.txtDiasLey = $('#txtDiasLey');

        workflowP.cargaFlujo();

        //iniciamos el flujo
        window.onload = function(){
            initPageObjects();
        };

        //regresar a la página anterior
        this.btnRegresar.click(function () {
            window.history.back();
        });
        //Cargamos el modal para agregar/editar etapas al flujo
        workflowP.btnEtapa.click(function () {
            workflowP.cargaFrmEtapa();
        });
    },
    cargaTablaEtapas: function () {
        workflowP.tblEtapas.bootstrapTable({
            url: general.base_url +  '/workflow/listar?opt=2&id=' + workflowP.txtIdFlujo.val()+'&offset=0&limit=100',
        });

        workflowP.tblEtapas.on('load-success.bs.table', function (e, data) {
            if (!workflowP.tblEtapas.is(':visible')) {
                workflowP.tblEtapas.show();
                workflowP.tblEtapas.bootstrapTable('resetView');
            }
            general.unblock();
        });

        workflowP.tblEtapas.on('sort.bs.table', function (e, row) {
            if (workflowP.tblEtapas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblEtapas.on('page-change.bs.table', function (e, row) {
            if (workflowP.tblEtapas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblEtapas.on('search.bs.table', function (e, row) {
            if (workflowP.tblEtapas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblEtapas.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (workflowP.tblEtapas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblEtapas.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información ' + status, 'error', true);
        });
    },
    cargaFlujo: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/buscar?opt=4&id=' + workflowP.txtIdFlujo.val(),
            contentType: 'application/json; charset=utf-8',
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
                workflowP.cargaTablaEtapas();
            }
        });
    },
    cargaFrmEtapa: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/modal?opt=1',   //mostramos el modal de las etapas
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    workflowP.modalEtapa = bootbox.dialog({
                        title: ' Edición de la etapa en el flujo',
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
                                    workflowP.frmEtapa.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    workflowP.modalEtapa.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        workflowP.frmEtapa = $('#frmEtapa');
                        workflowP.txtIdFlujo = $('#txtIdFlujo');
                        workflowP.txtColor = $('#txtColor');
                        workflowP.txtColorEstado = $('#txtColorEstado');
                        workflowP.slCondicion = $('#slCondicion');
                        workflowP.txtDiasLey.mask("0#");
                        workflowP.txtDiasUtpe.mask("0#");

                        workflowP.slCondicion.select2({
                            language: 'es',
                            dropdownParent: workflowP.modalEtapa,
                        });

                        $('#txtIdFlujoA').val(workflowP.txtIdFlujo.val());

                        workflowP.txtColor.colorpicker({
                            customClass: 'colorpicker-2x',
                            format: 'hex',
                            sliders: {
                                saturation: {
                                    maxLeft: 200,
                                    maxTop: 200
                                },
                                hue: {
                                    maxTop: 200
                                },
                                alpha: {
                                    maxTop: 200
                                }
                            }
                        });

                        workflowP.txtColor.colorpicker().on('changeColor.colorpicker', function(event){
                            $('#iColor').css("background", event.color.toHex());
                        });

                        workflowP.txtColorEstado.colorpicker({
                            customClass: 'colorpicker-2x',
                            format: 'hex',
                            sliders: {
                                saturation: {
                                    maxLeft: 200,
                                    maxTop: 200
                                },
                                hue: {
                                    maxTop: 200
                                },
                                alpha: {
                                    maxTop: 200
                                }
                            }
                        });

                        workflowP.txtColorEstado.colorpicker().on('changeColor.colorpicker', function(event){
                            $('#iColor2').css("background", event.color.toHex());
                        });

                        if ($("#txtId").val() > 0) {
                            workflowP.slCondicion.val(datos.CONDICION).trigger('change');
                        }

                        //Funcionalidad
                        workflowP.frmEtapa.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                if($("#txtNombreEstado").val() !== '' && $('#txtDescripcionEstado').val() !== '' && $('#txtColorEstado').val() !== '') {
                                    if( $("#txtDiasLey").val() !== '' && $('#txtDiasUtpe').val()  !== '') {
                                        workflowP.guardarEtapa(); // guardamos la etapa
                                        workflowP.modalEtapa.modal('hide');
                                    }else{
                                        $('a[href="#tab_plazos"]').click();
                                    }
                                }else{
                                    $('a[href="#tab_estado"]').click();
                                }
                            });
                        workflowP.frmEtapa.formValidation({excluded: [':disabled'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al cargar la página: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al cargar la página', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaFrmTransacciones: function (datosIn, etapaId) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        var idEtapa = (etapaId !== undefined) ? $.parseJSON($.base64.decode(etapaId)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/modal?opt=2',  //muestra el modal para agregar transacciones
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    workflowP.modalTransacciones = bootbox.dialog({
                        title: ' Conexiones entre las etapas',
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
                                    workflowP.frmTransacciones.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    workflowP.modalTransacciones.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        workflowP.frmTransacciones = $('#frmTransacciones');
                        workflowP.txtIdEtapa = $('#txtIdEtapa');
                        workflowP.txtIdEtapa.val(idEtapa);

                        workflowP.cargaTablaTransacciones(datos.ID);

                        workflowP.tblTransacciones.on('load-success.bs.table', function (e, data) {
                            if((workflowP.tblTransacciones.bootstrapTable('getOptions').totalRows === 0 && datos.CONDICION === '0') ||
                                workflowP.tblTransacciones.bootstrapTable('getOptions').totalRows < 2 && datos.CONDICION === '1'){
                                $('#btnTransaccion').removeClass('hidden');
                            }
                        });

                        //Funcionalidad
                        workflowP.frmTransacciones.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                workflowP.modalTransacciones.modal('hide');
                                location.reload();
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/>', 'Ocurrió un error al cargar la página: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/>', 'Ocurrió un error en la petición al servidor al cargar la página.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaFrmTransaccion: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        workflowP.idTransaccion = (datos !== null) ? parseInt($.trim(datos.ID)) : 0;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/modal?opt=3',  //muestra el modal para agregar transacciones
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    workflowP.modalTransaccion = bootbox.dialog({
                        title: ' Edición de conexión',
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
                                    workflowP.frmTransaccion.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    workflowP.modalTransaccion.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        workflowP.frmTransaccion = $('#frmTransaccion');
                        workflowP.slEtapa = $('#slEtapa');
                        workflowP.slAccion = $('#slAccion');
                        workflowP.slCondicion = $('#slCondicion');
                        workflowP.slPrevencion = $('#slPrevencion');
                        workflowP.slNotificacion = $('#slNotificacion');
                        workflowP.frmRol = $('#frmRol');
                        workflowP.txtRol = $('#txtRol');
                        workflowP.txtInfoRol = $('#txtInfoRol');
                        workflowP.tblRoles = $('#tblRoles');

                        $('#txtIdFlujoA').val(workflowP.txtIdFlujo.val());
                        $('#txtIdEtapaA').val(workflowP.txtIdEtapa.val());

                        workflowP.slAccion.select2({
                            placeholder: 'Selecciona la Accion a Realizar',
                            language: 'es',
                            dropdownParent: workflowP.modalTransaccion,
                        });
                        workflowP.slEtapa.select2({
                            placeholder: 'Selecciona la etapa a conectar',
                            language: 'es',
                            dropdownParent: workflowP.modalTransaccion,
                        });
                        workflowP.slCondicion.select2({
                            placeholder: 'Selecciona la etapa a conectar',
                            language: 'es',
                            dropdownParent: workflowP.modalTransaccion,
                        });
                        workflowP.slPrevencion.select2({
                            placeholder: 'Selecciona el tipo de respuesta',
                            language: 'es',
                            dropdownParent: workflowP.modalTransaccion,
                        });
                        workflowP.slNotificacion.select2({
                            placeholder: 'Selecciona el tipo de notificación',
                            language: 'es',
                            dropdownParent: workflowP.modalTransaccion,
                        });

                        workflowP.cargaEtapas();

                        //Funcionalidad
                        workflowP.frmTransaccion.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                if (workflowP.tblRoles.bootstrapTable('getOptions').totalRows > 0) {
                                    workflowP.guardarTransaccion();
                                    workflowP.modalTransaccion.modal('hide');
                                } else {
                                    general.notify('<strong>Alerta</strong><br/><br/>', 'Debes seleccionar los roles.', 'warning', true);
                                }
                            });

                        workflowP.tblRoles.bootstrapTable({
                            uniqueId: 'ID'
                        });
                        workflowP.tblRoles.bootstrapTable('resetView');

                        //Hacemos el cambio de acción
                        workflowP.slAccion.change(function(){
                            var idAccion =  workflowP.slAccion.val();
                            $(".conexion").addClass("hidden");
                            switch(idAccion) {
                                case "1":
                                    $("#div-respuesta").removeClass("hidden");
                                    break;
                                case "2":
                                case "3":
                                    $("#div-respuesta").removeClass("hidden");
                                    break;
                                case "4":
                                    $("#div-condicion").removeClass("hidden");
                                    break;
                            }
                        });
                        if (workflowP.idTransaccion > 0) {
                            workflowP.slAccion.val(datos.FORMULARIO).trigger('change');

                            if(datos.ID_PREVENCION) {
                                workflowP.slPrevencion.append(new Option(datos.PREVENCION, datos.ID_PREVENCION, false, false)).trigger('change');
                            }
                            if(datos.ID_CONDICION){
                                workflowP.slCondicion.append(new Option(datos.CONDICION, datos.ID_CONDICION, false, false)).trigger('change');
                            }
                            workflowP.slEtapa.append(new Option(datos.N_ETAPA, datos.N_ETAPA_ID, false, false)).trigger('change');
                        }
                        workflowP.txtRol.typeahead({
                            showHintOnFocus: true,
                            items: 50,
                            delay: 1000,
                            source: function (query, process) {
                                map = null;
                                workflowP.txtInfoRol.val('');

                                if ($.trim(query) !== '') {
                                    $.ajax({
                                        url: general.base_url + '/usuarios/buscar?opt=0', //realiza la búsqueda de los roles activos
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
                                            workflowP.txtInfoRol.val(key + '|' + $.trim(map[key].DESCRIPCION));
                                            workflowP.frmRol.formValidation('revalidateField', 'txtRol').formValidation('revalidateField', 'txtInfoRol');
                                            return false;
                                        }
                                    });
                                } else {
                                    item = '';
                                }
                                return item;
                            }
                        });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/>', 'Ocurrió un error al cargar la página: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/>', 'Ocurrió un error en la petición al servidor al cargar la página.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    agregarTransaccion: function () {
        workflowP.cargaFrmTransaccion();
    },
    agregarRoles: function () {
        workflowP.frmRol = $('#frmRol');
        workflowP.txtRol = $('#txtRol');
        workflowP.txtInfoRol = $('#txtInfoRol');
        workflowP.tblRoles = $('#tblRoles');
        workflowP.agregarRol($.trim(workflowP.txtInfoRol.val()), $.trim(workflowP.txtRol.val()));
    },
    agregarRol: function (datos, rol) {
        var datosRol = datos.split("|");

        if (workflowP.tblRoles.bootstrapTable('getRowByUniqueId', datosRol[0]) === null) {
            workflowP.tblRoles.bootstrapTable('insertRow', {
                index: datosRol[0],
                row: {
                    ID: datosRol[0],
                    NOMBRE: rol,
                    DESCRIPCION: datosRol[1]
                }
            });
        } else {
            general.notify('<strong>Alerta</strong><br/><br/>', 'El rol seleccionado ya se ha agregado previamente.', 'warning', true);
        }
        workflowP.txtInfoRol.val('');
        workflowP.txtRol.val('');
    },
    quitarRol: function (id) {
        id = $.base64.decode(id);
        if (workflowP.tblRoles.bootstrapTable('getRowByUniqueId', id) !== null) {
            workflowP.tblRoles.bootstrapTable('removeByUniqueId', id);
        } else {
            general.notify('<strong>Alerta</strong><br/><br/>', 'El rol seleccionado no se ha agregado previamente.', 'warning', true);
        }
    },
    cargaTablaRoles: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/buscar?opt=3', //cargamos los roles de cada transacción
            data: {id: workflowP.idTransaccion},
            contentType: 'application/json; charset=utf-8',
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        workflowP.tblRoles.bootstrapTable({});
                        workflowP.tblRoles.bootstrapTable('load', resultado.datos);
                        workflowP.tblRoles.bootstrapTable('selectPage', 1);
                    } else {
                        workflowP.tblRoles.bootstrapTable({});
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }

                    workflowP.tblRoles.bootstrapTable('resetView');
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error carga de los roles: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar los roles.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaEtapas: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/buscar?opt=0&id=' + workflowP.txtIdFlujo.val(),
            contentType: 'application/json; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        workflowP.slEtapa.find('option').remove().end().append('<option value="">Selecciona la siguiente etapa</option>');
                        $.each(resultado.datos,function(key,etapa ) {
                            workflowP.slEtapa.append('<option value='+etapa.ID+'>'+etapa.NOMBRE+'</option>');
                        });
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
                workflowP.cargaPrevenciones();
            }
        });
    },
    cargaPrevenciones: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/buscar?opt=6', //Hacemos la búsqueda de las prevenciones
            contentType: 'application/json; charset=utf-8',
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        workflowP.slPrevencion.find('option').remove().end().append('<option value="">Selecciona la siguiente etapa</option>');
                        $.each(resultado.datos,function(key,condicion) {
                            workflowP.slPrevencion.append('<option value='+condicion.ID+'>'+condicion.DESCRIPCION+'</option>');
                        });
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
               workflowP.cargaCondiciones();
            }
        });
    },
    cargaCondiciones: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/workflow/buscar?opt=5&id=' + workflowP.txtIdFlujo.val(),
            contentType: 'application/json; charset=utf-8',
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        workflowP.slCondicion.find('option').remove().end().append('<option value="">Selecciona la siguiente etapa</option>');

                        $.each(resultado.datos,function(key,condicion) {
                            workflowP.slCondicion.append('<option value='+condicion.ID+'>'+condicion.NOMBRE+'</option>');
                        });
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
                if(workflowP.idTransaccion > 0){
                    workflowP.cargaTablaRoles();
                }
            }
        });
    },
    guardarTransaccion: function (opt) {
        var dataArray = workflowP.frmTransaccion.serializeArray(),
            dataObj = {};

        $(dataArray).each(function(i, field){
            dataObj[field.name] = field.value;
        });
        $.ajax({
            type: 'POST',
            url: general.base_url + '/workflow/guardar?opt=2',
            data: {
                txtId: dataObj['txtIdTransaccion'],
                txtIdFlujoA: dataObj['txtIdFlujoA'],
                txtNombre: dataObj['txtNombre'],
                txtDescripcion: dataObj['txtDescripcion'],
                slAccion: dataObj['slAccion'],
                slEtapa: (dataObj['slEtapa'] !== '' && dataObj['slEtapa'] !== null) ? dataObj['slEtapa'] : $("#txtIdNEtapa").val(),
                slCondicion: (dataObj['slCondicion'] !== '' && dataObj['slCondicion'] !== null) ? dataObj['slCondicion'] : $("#txtIdCondicion").val(),
                slPrevencion: (dataObj['slPrevencion'] !== '' && dataObj['slPrevencion'] !== null) ? dataObj['slPrevencion'] : $("#txtIdPrevencion").val(),
                txtIdEtapa: dataObj['txtIdEtapaA'],
                roles: workflowP.tblRoles.bootstrapTable('getData')
            },
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        workflowP.tblTransacciones.bootstrapTable('refresh');
                    }else{
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al guardar: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al guardar.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarEtapa: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/workflow/guardar?opt=1', //Guardamos la etapa
            data: workflowP.frmEtapa.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                      location.reload();
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al guardar: ' + e + '.', 'error', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al guardar.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrar: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el flujo de trabajo?",
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
                        url: general.base_url + '/workflow/borrar/?txtIdFlujo=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    workflow.tblFlujos.bootstrapTable('refresh');
                                }
                                general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al borrar el flujo: ' + e + '.', 'error', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al borrar el flujo.', 'error', true);
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
    borrarEtapa: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar la etapa?",
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
                        url: general.base_url + '/workflow/borrar/?opt=1&id=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    location.reload();
                                }
                                general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al borrar: ' + e + '.', 'error', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al borrar.', 'error', true);
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
    borrarTransaccion: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar el botón?",
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
                        url: general.base_url + '/workflow/borrar?opt=3&id=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    workflowP.tblTransacciones.bootstrapTable('refresh');
                                }
                                general.notify('<strong>Mensaje del Sistema</strong><br />', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al borrar: ' + e + '.', 'error', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error en la petición al servidor al borrar.', 'error', true);
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
    cargaTablaTransacciones: function (id) {
        workflowP.tblTransacciones = $('#tblTransacciones');

        workflowP.tblTransacciones.bootstrapTable({
            url: general.base_url +  '/workflow/listar?opt=4&id=' + id,
        });
        workflowP.tblTransacciones.on('load-success.bs.table', function (e, data) {
            if (!workflowP.tblTransacciones.is(':visible')) {
                workflowP.tblTransacciones.show();
                workflowP.tblTransacciones.bootstrapTable('resetView');
            }
            general.unblock();
        });

        workflowP.tblTransacciones.on('sort.bs.table', function (e, row) {
            if (workflowP.tblTransacciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblTransacciones.on('page-change.bs.table', function (e, row) {
            if (workflowP.tblTransacciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblTransacciones.on('search.bs.table', function (e, row) {
            if (workflowP.tblTransacciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblTransacciones.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (workflowP.tblTransacciones.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        workflowP.tblTransacciones.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en el historial ' + status, 'error', true);
        });
    },

    principalFormatter: function (value, row, index) {
        return  (row.PRINCIPAL === '1') ? '<i class="fa fa-play-circle fa-2x text-green" aria-hidden="true"></i>' :"";
    },
    botonFormatter: function (value, row, index) {
        return '<span class="label  '+ row.boton +'"><i class="'+ row.icono + '"></i></span>';
    },
    estadoFormater: function (value, row, index) {
        return '<div class="input-group-addon"><i style="background-color: '+ row.color +'"></i>&nbsp;<span>'+ row.ESTADO.toUpperCase() +'</span></div>';
    },
    aEstadoFormatter: function (value, row, index) {
        return '<div class="input-group-addon"><i style="background-color: '+ row.color_estado +'"></i>&nbsp;<span>'+ row.N_ESTADO.toUpperCase() +'</span></div>';
    },
    estadoFormatter: function (value, row, index) {
        return '<div class="input-group-addon"><i style="background-color: '+ row.color +'"></i>&nbsp;<span>'+ row.ESTADO.toUpperCase() +'</span></div>';
    },
    aEtapaFormatter: function (value, row, index) {
        return '<div class="input-group-addon"><span>'+ row.N_ETAPA.toUpperCase() +'</span></div>';
    },
    rolesFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:workflowP.quitarRol(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
    etapasFormatter: function (value, row, index) {
        return [
            (row.EDITAR === '1') ? '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:workflowP.cargaFrmEtapa(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>' : '',
            (row.EDITAR === '1') ? '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:workflowP.borrarEtapa(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="glyphicon glyphicon-trash"></i></a>' : '',
            '&nbsp;<a class="btn btn-dropbox btn-lg btn-xs" role="button" href="javascript:workflowP.cargaFrmTransacciones(\'' + $.base64.encode(JSON.stringify(row)) + '\',\''+  $.base64.encode(row.ID) +'\');" data-toggle="tooltip" data-placement="bottom" title="Conexiones"><i class="fa fa-arrows"></i></a>'
        ].join('');
    },
    transaccionesFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:workflowP.cargaFrmTransaccion(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:workflowP.borrarTransaccion(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
    actionFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:workflowP.cargaFrmFlujo(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="top" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:workflowP.borrarFlujo(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
};

workflowP.init();
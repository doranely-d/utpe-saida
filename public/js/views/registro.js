
var solicitudes = {
    tblPreguntas: null,
    tblDocumentos: null,
    tblMediosRespuesta: null,
    btnAgregarDocumento: null,
    btnAgregarPregunta: null,
    btnAgregarMedio: null,
    frmSolicitud: null,
    frmDocumento: null,
    modalPregunta: null,
    modalDocumento:null,
    slEstado: null,
    slMunicipio: null,
    slTipo: null,
    slTGestion: null,
    slMedioR :  null,
    slDependencias :  null,
    inpDocumento: null,
    txtIdDocumento: null,
    txtNombre: null,
    formularioWizard: null,
    txtIdSolicitud: null,
    txtFechaNacimiento: null,
    txtCantidad : null,
    txtImporte : null,
    contPreguntas: 1,
    scrolltop: null,

    //metodos
    init: function () {

        //Inicialización de propiedades
        this.tblPreguntas = $('#tblPreguntas');
        this.tblDocumentos = $('#tblDocumentos');
        this.tblMediosRespuesta = $('#tblMediosRespuesta');
        this.btnAgregarDocumento = $('#btnAgregarDocumento');
        this.btnAgregarPregunta = $('#btnAgregarPregunta');
        this.btnAgregarMedio = $('#btnAgregarMedio');
        this.slEstado = $('#slEstado');
        this.slMunicipio = $('#slMunicipio');
        this.slTipo = $('#slTipo');
        this.slTGestion = $('#slTGestion');
        this.slMedioR = $('#slMedioR');
        this.slDependencias = $('#slDependencias');
        this.frmSolicitud = $('#frmSolicitud');
        this.modalDocumento = $('#modalDocumento');
        this.txtIdDocumento = $("#txtIdDocumento");
        this.txtNombre = $("#txtNombre");
        this.txtIdSolicitud = $("#txtIdSolicitud");
        this.txtCantidad = $("#txtCantidad");
        this.txtImporte = $("#txtImporte");
        this.txtFechaNacimiento = $("#txtFechaNacimiento");
        this.scrolltop = $("#scrolltop");

        solicitudes.slEstado.select2({
            placeholder: 'Selecciona el estado',
            language: 'es',
        });
        solicitudes.slMunicipio.select2({
            placeholder: 'Selecciona el municipio',
            language: 'es',
        });

        solicitudes.txtFechaNacimiento.datetimepicker({
            locale: 'es',
            format: 'L',
            showTodayButton: false,
            showClear: true,
            showClose: true,
            ignoreReadonly: true,
            allowInputToggle: false,
            keepOpen: false,
            widgetPositioning: {
                horizontal: 'auto',
                vertical: 'auto'
            }
        });

        //hace las validaciones input radio
        solicitudes.validaRadio();

        //Carga wizard
        solicitudes.cargaWizard();

        //carga los checkbos con los titulos
        solicitudes.cargaCheckboxIdentidad();

        //Cargamos el select de  municipios
        solicitudes.slEstado.change(function(){
            solicitudes.cargaMunicipiosId(solicitudes.slEstado.val());
        });
        //Cargamos el importe del medio
        solicitudes.slMedioR.change(function(){
            solicitudes.cargarImporte(solicitudes.slMedioR.val(), solicitudes.txtCantidad.val());
        });
        //Cargamos el importe del medio
        solicitudes.txtCantidad.bind('input', function() {
            solicitudes.cargarImporte(solicitudes.slMedioR.val(), $(this).val());
        });

        //Muestra el modal de documentos
        solicitudes.btnAgregarDocumento.click(function () {
            solicitudes.cargaFrmDocumento();
        });

        //Muestra el modal de preguntas
        solicitudes.btnAgregarPregunta.click(function () {
            solicitudes.cargaFrmPregunta();
        });

        //Mostramos el formulario de registro en base al tipo de solicitud
        solicitudes.slTipo.change(function(){
           if(solicitudes.slTipo.val() === 'SAI'){
               $(".solicitud-arco").addClass('hidden');
               $(".solicitud-sai").removeClass('hidden');
           }else{
               $(".solicitud-sai").addClass('hidden');
               $(".solicitud-arco").removeClass('hidden');
               $('input[type="checkbox"].minimal').iCheck('uncheck');
           }
        });

        //Agrega medio a al matbla de medios
        solicitudes.btnAgregarMedio.click(function () {
            solicitudes.agregarMedio($.trim(solicitudes.slMedioR.val()),$.trim(solicitudes.slMedioR.text()), $.trim(solicitudes.txtCantidad.val()),  $.trim(solicitudes.txtImporte.val()));
        });

        //ScrollTop para regresar al top
        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                solicitudes.scrolltop.addClass('show');
            } else {
                solicitudes.scrolltop.removeClass('show');
            }
        });
        solicitudes.scrolltop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, '300');
        });
        solicitudes.tblMediosRespuesta.bootstrapTable({
            uniqueId: 'ID_MEDIO_RESPUESTA'
        });
        solicitudes.tblMediosRespuesta.bootstrapTable('resetView');
    },
    validaRadio: function () {
        $(".radio-seudonimo :input").prop("disabled", true);
        $(".radio-pmoral :input").prop("disabled", true);

        //Validamos si el solicitante vive o no
        $('input[type="radio"].radio-vive').iCheck({
            checkboxClass: 'icheckbox_square-blue', radioClass: 'iradio_square-blue'
        }).on('ifChecked', function(event){
            if(event.currentTarget.defaultValue === "NO"){
                $(".fallecido").iCheck('check');
                $(".checkbox-fallecido input[type='checkbox']").iCheck('check');
                $(".checkbox-tutor-fallecido input[type='checkbox']").iCheck('check');
            } else {
                $(".fallecido").attr('checked', '');
                $(".checkbox-area :input").prop("disabled", false);
                $("#area-3 :input").prop("disabled", true);
                $("#check-fallecido input[type='checkbox']").attr('checked', '');
            }
        }).on('ifUnchecked', function (event) {
            $("." + event.currentTarget.defaultValue + " :input").prop("disabled", true);
        });

        //validamos los checkbox
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue'
        }).on('ifChecked', function(event){
            $("." + event.currentTarget.defaultValue + " :input").prop("disabled", false);
        }).on('ifUnchecked', function (event) {
            $("." + event.currentTarget.defaultValue + " :input").prop("disabled", true);
        });
        //aviso de privacidad
        $('input[type="checkbox"].checkbox-aviso').iCheck({
            checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue'
        });
        //Validamos los radios del solicitante si es anonimo o no
        $('input[type="radio"].radio').iCheck({
            checkboxClass: 'icheckbox_square-blue', radioClass: 'iradio_square-blue'
        }).on('ifChecked', function(event){
            $("." + event.currentTarget.defaultValue + " :input").prop("disabled", false);
            if(event.currentTarget.defaultValue === "radio-solicitante"){
                $(".area-solicitud :input[type=\"radio\"].radio-persona").prop("disabled", false);
            }
            if(event.currentTarget.defaultValue === "radio-anonimo"){
                $(".area-notificacion :input").prop("disabled", true);
                $(".area-solicitud :input").prop("disabled", true);
                $(".radio-seudonimo :input").prop("disabled", true);
                $('input[type="checkbox"].minimal').iCheck('uncheck');
            }else{
                $(".area-notificacion :input").prop("disabled", false);
            }
            if(event.currentTarget.defaultValue === "radio-seudonimo") {
                $(".area-solicitud :input").prop("disabled", true);
            }
        }).on('ifUnchecked', function (event) {
            $("." + event.currentTarget.defaultValue + " :input").prop("disabled", true);
        });
        //Validamos si es una persona fisica o moral
        $('input[type="radio"].radio-persona').iCheck({
            checkboxClass: 'icheckbox_square-aero', radioClass: 'iradio_square-aero'
        }).on('ifChecked', function(event){
            $("." + event.currentTarget.defaultValue + " :input").prop("disabled", false);
        }).on('ifUnchecked', function (event) {
            $("." + event.currentTarget.defaultValue + " :input").prop("disabled", true);
        });

        //Validamos si es una persona fisica o moral
        $('input[type="radio"].radio-consentimiento').iCheck({
            checkboxClass: 'icheckbox_square-blue', radioClass: 'iradio_square-blue'
        });

        //Validamos los documentos de acreditación
        $('input[type="radio"].radio-acreditacion').iCheck({
            checkboxClass: 'icheckbox_square-blue', radioClass: 'iradio_square-blue'
        }).on('ifChecked', function(event){
            $("." + event.currentTarget.defaultValue + ' :input[type="text"]').prop("disabled", false);
            $("." + event.currentTarget.defaultValue + ' :input').iCheck('enable');
        }).on('ifUnchecked', function (event) {
            $("." + event.currentTarget.defaultValue + ' :input[type="text"]').prop("disabled", true);
            $("." + event.currentTarget.defaultValue + " :input").iCheck('disable');
        });

        //Validaciones para las peticiones de la solicitud
        $('input[type="checkbox"].checkbox').iCheck({
            checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue'
        }).on('ifChecked', function(event){
            $("." + event.currentTarget.defaultValue).removeClass('hidden');
            if(event.currentTarget.defaultValue === "checkbox-preguntas"){
                $(".checkbox-agrupar").addClass('hidden');
            }
        }).on('ifUnchecked', function (event) {
            $("." + event.currentTarget.defaultValue).addClass('hidden');
            if(event.currentTarget.defaultValue === "checkbox-preguntas"){
                $(".checkbox-agrupar").removeClass('hidden');
            }
        });
    },
    cargaWizard: function () {
        //inicializamos las variables
        solicitudes.frmSolicitud = $('#frmSolicitud');
        solicitudes.formularioWizard = $('#formularioWizard');
        solicitudes.frmSolicitud.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'});

        solicitudes.formularioWizard.wizard().on('actionclicked.fu.wizard', function(e, data) {
            //validacion del formulario
            var fv   = solicitudes.frmSolicitud.data('formValidation'), step = data.step, $container = solicitudes.formularioWizard.find('.step-pane[data-step="' + step +'"]');
            fv.validateContainer($container);
            var isValidStep = fv.isValidContainer($container);

            if (isValidStep === false || isValidStep === null) {
                e.preventDefault();
            }else {
                if (data.step === 1 && data.direction === 'next') {
                    e.preventDefault();

                    var acreditacionTitular = [],
                        acreditacionResponsable = [],
                        cadena = [],
                        representante;

                    $("input[name='checkAcreditacionTitular[]']:checked").each(function() {
                        acreditacionTitular.push($(this).val());
                    });
                    $("input[name='checkAcreditacionResponsable[]']:checked").each(function() {
                        acreditacionResponsable.push($(this).val());
                    });
                    $("input[name='checkRepresentante[]']:checked").each(function() {
                        cadena.push($(this).val());
                    });
                    representante = cadena.join(', ');

                    $.ajax({
                        type: 'POST',
                        url: general.base_url + '/solicitudes/guardar',
                        contentType: 'application/x-www-form-urlencoded',
                        data: {
                            opt:0,
                            tipo:solicitudes.slTipo.val(),
                            txtApellidoP: $("#txtApellidoP").val(),
                            txtApellidoM: $("#txtApellidoM").val(),
                            txtNombre: $("#txtNombre").val(),
                            txtRazonSocial: $("#txtRazonSocial").val(),
                            txtApellidoPT: $("#txtApellidoPT").val(),
                            txtApellidoMT: $("#txtApellidoMT").val(),
                            txtNombreT: $("#txtNombreT").val(),
                            acreditacionTitular: acreditacionTitular,
                            acreditacionResponsable: acreditacionResponsable,
                            representante: representante,
                            txtApellidoPR: ($("#txtApellidoPR").val()) ? $("#txtApellidoPR").val(): $("#txtApellidoPR2").val(),
                            txtApellidoMR: ($("#txtApellidoMR").val()) ? $("#txtApellidoMR").val(): $("#txtApellidoMR2").val(),
                            txtNombreR: ($("#txtNombreR").val()) ? $("#txtNombreR").val(): $("#txtNombreR2").val(),
                            txtSeudonimo: $("#txtSeudonimo").val(),
                            consentimiento: $('input[name=radio-consentimiento]:checked', '#frmSolicitud').val(),
                            anonimo: $("input[id='radio-anonimo']:checked").val(),
                            txtDireccion: $("#txtDireccion").val(),
                            txtCorreo: $("#txtCorreo").val(),
                            txtColonia: $("#txtColonia").val(),
                            slEstado: solicitudes.slEstado.val(),
                            slMunicipio: solicitudes.slMunicipio.val(),
                            txtCodigoP: $("#txtCodigoP").val(),
                            txtEntreCalles: $("#txtEntreCalles").val(),
                            txtOtraReferencia: $("#txtOtraReferencia").val(),
                            txtTelefonoFijo: $("#txtTelefonoFijo").val(),
                            txtTelefonoCel: $("#txtTelefonoCel").val(),
                            txtApellidoPPA: $("#txtApellidoPPA").val(),
                            txtApellidoMPA: $("#txtApellidoMPA").val(),
                            txtNombrePA: $("#txtNombrePA").val(),
                            txtOtro: $("#txtOtro").val(),
                            txtFechaNacimiento:$("#txtFechaNacimiento").val(),
                            rdVive: $('input:radio[name="grupo-vive"]:checked').val(),
                        },
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    if (resultado.estatus === 'success') {
                                        //asignamos el valor de id de la solicitud registrada
                                        solicitudes.txtIdSolicitud.val(resultado.datos);
                                        solicitudes.formularioWizard.wizard('selectedItem', { step: 2 });   //pasamos a la siguiente etapa
                                    } else {
                                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                                    }
                                }
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar la solicitud: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar la solicitud.', 'danger', true);
                            }, 500);
                        },
                        complete: function () {
                            general.unblock();
                        }
                    });
                }
            }
        }).on('finished.fu.wizard', function(e) {
            e.preventDefault();
            var avisoPrivacidad = $('.checkbox-aviso:checkbox:checked').length > 0;
            if(grecaptcha.getResponse().length !== 0 && avisoPrivacidad === true ) {
                $.ajax({
                    type: 'POST',
                    url: general.base_url + '/solicitudes/guardar',
                    data: {
                        opt:1, //opción para guardar infomacion de la petición
                        txtIdSolicitud: solicitudes.txtIdSolicitud.val(),
                        idDerechoArco: solicitudes.slTGestion.val(),
                        txtDerecho:$("input[name=radio-arco]:checked").val(),
                        slDependencias:  solicitudes.slDependencias.val(),
                        medios: solicitudes.tblMediosRespuesta.bootstrapTable('getSelections'),
                        txtAntecedentes: $("#txtAntecedentes").val(),
                        txtPeticion: $("#txtPeticion").val(),
                        txtObservaciones: $("#txtObservaciones").val(),
                    },
                    contentType: 'application/x-www-form-urlencoded',
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        general.block();
                    },
                    success: function (resultado) {
                        try {
                            if (resultado.estatus === 'success') {
                                setTimeout(function () {
                                    swal({
                                        title: "Solicitud Recibida!",
                                        text: "Solicitud registrada correctamente!",
                                        type: "success",
                                        confirmButtonText: 'Descargar folio'
                                    }, function() {
                                        // location.reload();
                                        var url = general.base_url + '/documentos/descargar?opt=2&id='+ solicitudes.txtIdSolicitud.val();
                                        $.fileDownload(url, {
                                            failCallback: function (responseHtml, url) {
                                                general.unblock();
                                                general.notify('<strong>Ocurrió un error</strong><br />', 'Ocurrió un error al descargar el archivo: ' + url + responseHtml, 'danger', true);
                                            }
                                        });
                                    });
                                    }, 1000);
                            }else{
                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            }
                        } catch (e) {
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar catalogo: ' + e + '.', 'danger', true);
                            }, 500);
                        }
                    },
                    error: function () {
                        general.unblock();
                        setTimeout(function () {
                            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar la solicitud.', 'danger', true);
                        }, 500);
                        e.preventDefault();
                    },
                    complete: function () {
                        general.unblock();
                    }
                });
            }
        });
    },
    checkboxAcreditacionIdentidad: function () {
        //hacemos el llenado de los checkbox
        $.ajax({
            url: general.base_url + '/public/json/campos.json',
            dataType: "json",
            success: function(datos){
                //se agregan el grupo de checkbox mayor edad
                $.each(datos['MAYOR_EDAD'] ,function(key,documento ) {
                    $("<div>", {'class': 'col-md-3'}).append(
                        $('<label class="text-muted">').append('<input type="checkbox" class="minimal-arco" name="checkAcreditacionTitular[]" value="'+documento.ID_DOCUMENTO+'" > ' + documento.DESCRIPCION)
                    ).hide().appendTo('.radio-mayor').fadeIn('slow');

                    $("<div>", {'class': 'col-md-4'}).append(
                        $('<label class="text-muted">').append('<input type="checkbox" class="minimal-arco" name="checkAcreditacionResponsable[]" value="'+documento.ID_DOCUMENTO+'"> '+ documento.DESCRIPCION)
                    ).hide().appendTo('.checkbox-persona').fadeIn('slow');
                });
                //se agregan el grupo de checkbox menor edad
                $.each(datos['MENOR_EDAD'],function(key,documento ) {
                    $("<div>",{'class': 'col-md-3'}).append(
                        $('<label class="text-muted">').append('<input type="checkbox" class="minimal-arco"  name="checkAcreditacionTitular[]" value="'+documento.ID_DOCUMENTO+'" disabled> '+ documento.DESCRIPCION)
                    ).hide().appendTo('.radio-menor').fadeIn('slow');
                });
                //se agregan el grupo de checkbox fallecido
                $.each(datos['FALLECIDO'],function(key,documento ) {
                    $("<div>", {'class': 'col-md-3'}).append(
                        $('<label class="text-muted">').append('<input type="checkbox" class="minimal-arco" name="checkAcreditacionTitular[]" value="'+documento.ID_DOCUMENTO+'" disabled> '+ documento.DESCRIPCION)
                    ).hide().appendTo('.radio-fallecido').fadeIn('slow');
                });
                //se agregan el grupo de checkbox persona fisica
                $.each(datos['PERSONA_FISICA'],function(key,documento ) {
                    $("<div>", {'class': 'col-md-4'}).append(
                        $('<label class="text-muted">').append('<input type="checkbox" class="minimal-arco" name="checkAcreditacionResponsable[]" value="'+documento.ID_DOCUMENTO+'"> '+ documento.DESCRIPCION)
                    ).hide().appendTo('.checkbox-fisica').fadeIn('slow');
                });
                //se agregan el grupo de checkbox persona moral
                $.each(datos['PERSONA_MORAL'],function(key,documento ) {
                    $("<div>", {'class': 'col-md-3'}).append($('<label class="text-muted">').append(
                        '<input type="checkbox" class="minimal-arco" name="checkAcreditacionResponsable[]" value="'+documento.ID_DOCUMENTO+'"> '+ documento.DESCRIPCION)
                    ).hide().appendTo('.checkbox-moral').fadeIn('slow');
                });
                //se agregan el grupo de checkbox tutor
                $.each(datos['TUTOR'],function(key,documento ) {
                    $("<div>", {'class': 'col-md-6'}).append($('<label class="text-muted">').append(
                        '<input type="checkbox" class="minimal-arco" name="checkAcreditacionResponsable[]" value="'+documento.ID_DOCUMENTO+'"> '+ documento.DESCRIPCION)
                    ).hide().appendTo('.checkbox-tutor').fadeIn('slow');
                });
                //se agregan el grupo de checkbox padres
                $.each(datos['PADRES'],function(key,documento ) {
                    $("<div>", {'class': 'col-md-8'}).append($('<label class="text-muted">').append(
                        '<input type="checkbox" class="minimal-arco" name="checkAcreditacionResponsable[]" value="'+documento.ID_DOCUMENTO+'"> '+ documento.DESCRIPCION)
                    ).hide().appendTo('.checkbox-padres').fadeIn('slow');
                });
                //se agregan el grupo de checkbox tutor_fallecido
                $.each(datos['TITULAR_FALLECIDO'],function(key,documento ) {
                    $("<div>", {'class': 'col-md-8'}).append($('<label class="text-muted">').append(
                        '<input type="checkbox" class="minimal-arco" name="checkAcreditacionResponsable[]" value="'+documento.ID_DOCUMENTO+'" > ' + documento.DESCRIPCION)
                    ).hide().appendTo('.checkbox-tutor-fallecido').fadeIn('slow');
                });
                $('input[type="checkbox"].minimal-arco').iCheck({checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue'});
            },
            complete: function () {
                solicitudes.cargaEstados();
            }
        });
    },
    cargaEstados: function () {
        $.ajax({
            url: general.base_url + '/public/json/estados.json',
            dataType: "json",
            success: function(data){
                $.each(data,function(key, registro) {
                    solicitudes.slEstado.append('<option value='+registro.ID_ESTADO+'>'+registro.ESTADO+'</option>');
                });
            },
            complete: function () {
                solicitudes.cargaMunicipios();
            }
        });
    },
    cargaMunicipios: function (id) {
        $.ajax({
            url: general.base_url + '/public/json/municipios.json',
            dataType: "json",
            success: function(data){
                $.each(data,function(key, registro) {
                    solicitudes.slMunicipio.append('<option value='+registro.ID_MUNICIPIO+'>'+registro.MUNICIPIO+'</option>');
                });
            },
            complete: function () {
                solicitudes.cargaMediosRespuesta();
            }
        });
    },
    cargaMediosRespuesta: function () {
        $.ajax({
            url: general.base_url + '/public/json/mediosRespuesta.json',
            dataType: "json",
            success: function(data){
                $.each(data,function(key, registro) {
                    solicitudes.slMedioR.append('<option value='+registro.ID_MEDIO_RESPUESTA+'>'+registro.MEDIO+'</option>');

                });
            },
            complete: function () {
                solicitudes.cargaDocumentos();
            }
        });
    },
    cargaFrmPregunta: function (datosIn, contP) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
        var contador = (contP !== undefined) ? contP : solicitudes.contPreguntas ;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/solicitudes/modal/?opt=0', //opción para mostrar el modal para agregar preguntas
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitudes.modalPregunta = bootbox.dialog({
                        title: ' <i class="fa fa-pencil prefix"></i> Pregunta No.' + contador,
                        onEscape: true,
                        animate: true,
                        size: 'large',
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
                                    solicitudes.frmPregunta.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitudes.modalPregunta.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();
                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);
                        //Inicialización
                        solicitudes.frmPregunta = $('#frmPregunta');
                        //Funcionalidad
                        solicitudes.frmPregunta.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                solicitudes.guardarPregunta();
                                if($("#txtIdPregunta").val()=== undefined){
                                    solicitudes.contPreguntas = solicitudes.contPreguntas + 1;
                                }
                                solicitudes.modalPregunta.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de la pregunta: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de la pregunta.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarPregunta: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/preguntas/guardar/',//Guardar la pregunta por solicitud
            data: {
                txtIdPregunta: $("#txtIdPregunta").val(),
                txtIdSolicitud: solicitudes.txtIdSolicitud.val(),
                txtDescripcion: $("#txtPregunta").val(),
                txtObservacion: $("#txtObservacion").val(),
            },
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        //inicializamos variables
                        solicitudes.tblPreguntas = $("#tblPreguntas");
                        //hacemos un refresh a la tabla de preguntas
                        solicitudes.tblPreguntas.bootstrapTable('refresh', {
                            url: general.base_url + '/solicitudes/listar/?opt=1&id_solicitud='+ solicitudes.txtIdSolicitud.val(),
                        });
                        //No permitimos cambiar el checkbox de las preguntas
                        $('input[type="checkbox"].checkbox').prop("disabled", true);
                    }else{
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar la pregunta: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar la pregunta.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    borrarPregunta: function (idIn) {
        var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
        bootbox.confirm({
            message: "¿Deseas borrar la pregunta?",
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
                        url: general.base_url + '/preguntas/borrar?txtIdPregunta=' + id,
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    //inicializamos variables
                                    solicitudes.tblPreguntas = $("#tblPreguntas");
                                    //hacemos un refresh a la tabla de preguntas
                                    solicitudes.tblPreguntas.bootstrapTable('refresh', {
                                        url: general.base_url + '/solicitudes/listar/?opt=1&id_solicitud='+ solicitudes.txtIdSolicitud.val(),
                                    });
                                    solicitudes.contPreguntas = solicitudes.contPreguntas - 1;
                                }
                                general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                            } catch (e) {
                                setTimeout(function () {
                                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar la pregunta: ' + e + '.', 'danger', true);
                                }, 500);
                            }
                        },
                        error: function () {
                            general.unblock();
                            setTimeout(function () {
                                general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar la pregunta.', 'danger', true);
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
    cargaFrmDocumento: function (datosIn) {
        var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;

        $.ajax({
            type: 'GET',
            url: general.base_url + '/documentos/modal', //mostramos el modal para agregar documento
            data: datos,
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    solicitudes.modalDocumento = bootbox.dialog({
                        title: '<i class="fa fa-upload" aria-hidden="true"></i> Anexo de documentos',
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
                                    solicitudes.frmDocumento.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    solicitudes.modalDocumento.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //inicialización
                        solicitudes.frmDocumento = $('#frmDocumento');
                        solicitudes.inpDocumento = $("#inpDocumento");

                        //funcionalidad
                        solicitudes.inpDocumento.fileinput({
                            showPreview: false,
                            showUpload: false,
                            language: "es",
                            elErrorContainer: '#kartik-file-errors',
                            allowedFileExtensions: general.obtenerExtensionDoc(),
                        });

                        solicitudes.frmDocumento.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                solicitudes.guardarDocumento();
                                solicitudes.modalDocumento.modal('hide');
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
        formData.append("inpDocumento", solicitudes.inpDocumento[0].files[0]);
        formData.append("idDocumento", $("#txtIdDocumento").val());
        formData.append("id", solicitudes.txtIdSolicitud.val());
        formData.append("txtNombre", $("#txtNombreDoc").val());
        formData.append("opt", '2'); //opción para almacenar los documentos anexos a la solicitud

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
                        solicitudes.tblDocumentos.bootstrapTable('refresh', {
                            url: general.base_url + '/solicitudes/listar/?opt=2&id_solicitud='+ solicitudes.txtIdSolicitud.val(),
                        });
                    }else{
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
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
                        url: general.base_url + '/documentos/borrar/?txtIdDocumento=' + id + '&opt=3',
                        contentType: 'application/json; charset=utf-8',
                        beforeSend: function (xhr) {
                            general.block();
                        },
                        success: function (resultado) {
                            try {
                                if (resultado.estatus === 'success') {
                                    solicitudes.tblDocumentos.bootstrapTable('refresh', {
                                        url: general.base_url + '/solicitudes/listar/?opt=2&id_solicitud='+ solicitudes.txtIdSolicitud.val(),
                                    });
                                }else{
                                    general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                                }
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
    cargaDocumentos: function () {
        //inicializamos variables
        solicitudes.tblDocumentos = $("#tblDocumentos");
        //cargamos la tabla de documentos
        solicitudes.tblDocumentos.bootstrapTable({
            url: general.base_url + '/solicitudes/listar/?opt=2&id_solicitud=' + solicitudes.txtIdSolicitud.val(),
        });
        solicitudes.tblDocumentos.on('load-success.bs.table', function (e, data) {
            if (!solicitudes.tblDocumentos.is(':visible')) {
                solicitudes.tblDocumentos.show();
                solicitudes.tblDocumentos.bootstrapTable('resetView');
            }
            solicitudes.cargaDependencias();
        });

        solicitudes.tblDocumentos.on('sort.bs.table', function (e, row) {
            if (solicitudes.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblDocumentos.on('page-change.bs.table', function (e, row) {
            if (solicitudes.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblDocumentos.on('search.bs.table', function (e, row) {
            if (solicitudes.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblDocumentos.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitudes.tblDocumentos.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblDocumentos.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los documentos ' + status, 'danger', true);
        });
    },
    cargaPreguntas: function () {
        //inicializamos variables
        solicitudes.tblPreguntas = $("#tblPreguntas");
        //cargamos la tabla de preguntas
        solicitudes.tblPreguntas.bootstrapTable({
            url: general.base_url + '/solicitudes/listar?opt=1&id_solicitud=' + solicitudes.txtIdSolicitud.val(),
        });
        solicitudes.tblPreguntas.on('load-success.bs.table', function (e, data) {
            if (!solicitudes.tblPreguntas.is(':visible')) {
                solicitudes.tblPreguntas.show();
                solicitudes.tblPreguntas.bootstrapTable('resetView');
            }
            general.unblock();
        });

        solicitudes.tblPreguntas.on('sort.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.on('page-change.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.on('search.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
            if (solicitudes.tblPreguntas.bootstrapTable('getOptions').totalRows > 0) {
                general.block();
            }
        });

        solicitudes.tblPreguntas.on('load-error.bs.table', function (e, status) {
            general.unblock();
            general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de las preguntas ' + status, 'danger', true);
        });
    },
    cargaMunicipiosId: function (id) {
        solicitudes.slMunicipio.find('option').remove().end().append('<option value="" selected="selected">- SELECCIONAR -</option>');
        $.ajax({
            url: general.base_url + '/public/json/municipios.json',
            dataType: "json",
            success: function(data){
                $.each(data,function(key, registro) {
                    if(registro.ID_ESTADO === id){
                        solicitudes.slMunicipio.append('<option value='+registro.ID_MUNICIPIO+'>'+registro.MUNICIPIO+'</option>');
                    }
                });
            },
        });
    },
    cargaDependencias: function () {
        solicitudes.slDependencias = $('#slDependencias');
        var select = document.getElementById('slDependencias');
        multi( select, {
            dropdownParent: solicitudes.modalTurnado,
            non_selected_header: 'DEPENDENCIAS',
            selected_header: 'DEPENDENCIAS SELECCIONADAS',
            search_placeholder: 'Buscar dependencia ...',
        });
        $.ajax({
            url: general.base_url + '/public/json/dependencias.json',
            dataType: "json",
            success: function(data){
                $.each(data,function(key, registro) {
                    $("#slDependencias").append('<option value='+registro.FLEX_VALUE_ID+'>'+registro.DESCRIPTION+'</option>');
                });
            },
            complete: function () {
                solicitudes.cargaPreguntas();
            }
        });
    },
    cargarImporte: function (id, cantidad) {
        $.ajax({
            url: general.base_url + '/public/json/mediosRespuesta.json',
            dataType: "json",
            success: function(data){
                $.each(data,function(key, registro) {
                    if(registro.ID_MEDIO_RESPUESTA === id){
                        solicitudes.txtImporte.val(registro.COSTO * cantidad);
                    }
                });
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor.', 'error', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    agregarMedio: function (idMedio,medio, cantidad, importe) {
        if (solicitudes.tblMediosRespuesta.bootstrapTable('getRowByUniqueId', idMedio) === null) {
            solicitudes.tblMediosRespuesta.bootstrapTable('insertRow', {
                index: idMedio,
                row: {
                    ID_MEDIO_RESPUESTA: idMedio,
                    MEDIO: medio,
                    CANTIDAD: cantidad,
                    IMPORTE: importe
                }
            });
        } else {
            general.notify('<strong>Alerta</strong><br/><br/>', 'El medio seleccionado ya se ha agregado previamente.', 'warning', true);
        }
    },
    quitarMedio: function (id) {
        id = $.base64.decode(id);
        if (solicitudes.tblMediosRespuesta.bootstrapTable('getRowByUniqueId', id) !== null) {
            solicitudes.tblMediosRespuesta.bootstrapTable('removeByUniqueId', id);
        } else {
            general.notify('<strong>Alerta</strong><br/><br/>', 'El medio seleccionado no se ha agregado previamente.', 'warning', true);
        }
    },
    mediosFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:solicitudes.quitarMedio(\'' + $.base64.encode(row.ID_MEDIO_RESPUESTA) + '\');" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
    totalFormatter: function (data) {
        var subtotal = 0;

        for (var x in data) {
            subtotal += (data[x].IMPORTE !== '') ? parseFloat(data[x].IMPORTE) : 0;
            console.log(data[x].IMPORTE );
        }
        return '<b>TOTAL: </b>' + general.formatoMoneda(parseFloat(subtotal));
    },
    actionFormatter: function (value, row, index) {
        return [
            '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:solicitudes.cargaFrmPregunta(\'' + $.base64.encode(JSON.stringify(row)) +'\','+(index+1)+');" data-toggle="tooltip" data-placement="bottom" title="Editar Pregunta"><i class="glyphicon glyphicon-pencil"></i></a>',
            '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:solicitudes.borrarPregunta(\'' + $.base64.encode(row.ID_PREGUNTA) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Pregunta"><i class="glyphicon glyphicon-trash"></i></a>'
        ].join('');
    },
    documentoActionFormatter: function (value, row, index) {
        return ['&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:solicitudes.borrarDocumento(\'' + $.base64.encode(row.ID_DOCUMENTO) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Documento"><i class="glyphicon glyphicon-trash"></i></a>'].join('');
    },
    numRowFormatter: function (value, row, index) {
        return 1 + index;
    },
};

solicitudes.init();
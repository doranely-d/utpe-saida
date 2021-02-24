
var calendar = {
    btnAgregarSolicitud: null,
    btnAgregarPregunta: null,
    frmSolicitud: null,
    modalSolicitud: null,
    frmPregunta: null,
    txtTipoSolicitud :  null,
    diasInhabiles : null,
    aSolicitudes: null,

    //metodos
    init: function () {
        this.txtTipoSolicitud = $('#txtTipoSolicitud');
        this.diasInhabiles = [];
        this.aSolicitudes = [];
        this.cont = 0;
        //Carga el input upload
        calendar.cargaEstatus();
    },

    cargaCalendario: function () {
        $('#external-events .fc-event').each(function() {
            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });

        /* initialize the calendar
        -----------------------------------------------------------------*/
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            businessHours: true, // display business hours
            editable: true,
            eventLimit: true,
            eventLimitText: "Más Solcitudes",
            displayEventTime: false,
            allDaySlot: true,
            enableViewState: true,
            eventSources: [
                {
                    events: function(start, end, timezone, callback) {
                        callback(calendar.aSolicitudes);
                    }
                }
            ],
            eventClick: function(calEvent, jsEvent, view) {
                //agregamos link para el perfil de la solicitud
                if (event.url) {
                    window.open(event.url);
                    return false;
                }
            },
            eventRender: function(event, element) {
                if(event.dias){
                    element.find(".fc-title").prepend('<small class="label pull-right bg-red">2</small>');
                }
            },
            dayRender: function (date, cell) {
                if ($.inArray(date.format("YYYY-MM-DD"), calendar.diasInhabiles) > -1) {
                    cell.css("background-color", "#e9e9e9");
                }
            }
        });
    },
    cargaEstatus: function () {
        $.ajax({
            url: general.base_url +  '/calendario/listar?opt=1&tipo='+calendar.txtTipoSolicitud.val(),
            type: 'GET',
            contentType: 'application/json; charset=utf-8',
            success: function(resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        //llenamos el div de estatus
                        $.each(resultado.datos, function (key, estatus) {
                            $("<div>", {
                                'class': 'external-event',
                                'style': 'color:#fff; background-color:' + estatus.COLOR
                            }).append(' ' + estatus.NOMBRE + ' ').hide().appendTo('#external-events').fadeIn('slow');
                        });
                    } else {
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar el calendario: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar los estatus de la solicitud.', 'danger', true);
                }, 500);
            },
            complete: function () {
                calendar.cargaSolicitudes();
            }
        });
    },
    cargaSolicitudes: function () {
        $.ajax({
            url: general.base_url +  '/calendario/listar?opt=0&tipo='+calendar.txtTipoSolicitud.val(),
            type: 'GET',
            contentType: 'application/json; charset=utf-8',
            success: function(resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        //llenamos el array de las solicitudes
                        $.each(resultado.datos,function(key,solicitud ) {
                            calendar.aSolicitudes.push({
                                id: solicitud.ID_SOLICITUD ,
                                title: solicitud.FOLIO + ' - ' + solicitud.ESTADO,
                                start: moment( solicitud.FECHA_PREVENCION, "DD/MM/YYYY").format('YYYY-MM-DD hh:mm'),
                                end: moment( solicitud.FECHA_PREVENCION, "DD/MM/YYYY").format('YYYY-MM-DD hh:mm'),
                                color: solicitud.COLOR_ESTADO,
                                url:  general.base_url +  '/solicitudes/perfil/?id=' + solicitud.ID_SOLICITUD ,
                            });
                        });
                    } else {
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar el calendario: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar los estatus de la solicitud.', 'danger', true);
                }, 500);
            },
            complete: function () {
                calendar.cargaDiasInhabiles()
            }
        });
    },
    cargaDiasInhabiles: function () {
        $.ajax({
            url: general.base_url +  '/calendario/listar?opt=2&tipo='+calendar.txtTipoSolicitud.val(),
            type: 'GET',
            contentType: 'application/json; charset=utf-8',
            success: function(resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        //llenamos el array de dias inhabiles
                        $.each(resultado.datos,function(key,dias ) {
                            calendar.diasInhabiles.push(moment(dias , "DD/MM/YYYY").format("YYYY-MM-DD"));
                        });
                    } else {
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar el calendario: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar los estatus de la solicitud.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
                calendar.cargaCalendario()
            }
        });
    },
};

calendar.init();
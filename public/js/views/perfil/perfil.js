/* global general, bootbox, e */

var perfil = {
    btnEditarPerfil: null,
    btnEditarPassword: null,
    modalUsuario: null,
    frmUsuario: null,

    //metodos
    init: function () {
        //Inicialización de propiedades
        this.btnEditarPerfil = $('#btnEditarPerfil');
        this.btnEditarPassword = $('#btnEditarPassword');

        this.btnEditarPerfil.click(function () {
            perfil.cargaFrmUsuario();
        });

        this.btnEditarPassword.click(function () {
            perfil.cargaFrmPassword();
        });
    },
    cargaFrmUsuario: function () {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/perfil/modal?opt=0',
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    perfil.modalUsuario = bootbox.dialog({
                        title: ' Editar datos personales',
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
                                    perfil.frmUsuario.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    perfil.modalUsuario.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function (){$('.bootbox-close-button').focusout();}, 100);

                        //Inicialización
                        perfil.frmUsuario = $('#frmUsuario');

                        //Funcionalidad
                        perfil.frmUsuario.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                perfil.guardarUsuario();
                                perfil.modalUsuario.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    cargaFrmPassword: function (id) {
        $.ajax({
            type: 'GET',
            url: general.base_url + '/perfil/modal?opt=1',
            data: {id:1},
            contentType: 'application/html; charset=utf-8',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    perfil.modalUsuario = bootbox.dialog({
                        title: 'Cambiar contraseña',
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
                                    perfil.frmUsuario.submit();
                                    return false;
                                }
                            }
                        }
                    });

                    perfil.modalUsuario.on('shown.bs.modal', function () {
                        $('.bootbox-close-button').focus();

                        setTimeout(function () {
                            $('.bootbox-close-button').focusout();
                        }, 100);

                        //Inicialización
                        perfil.frmUsuario = $('#frmUsuario');

                        //Funcionalidad
                        perfil.frmUsuario.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
                            .on('success.form.fv', function (e) {
                                e.preventDefault();
                                perfil.guardarPassword();
                                perfil.modalUsuario.modal('hide');
                            });
                    });
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarUsuario: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/perfil/guardar',
            data: perfil.frmUsuario.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        location.reload();
                    }else{
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
    guardarPassword: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/perfil/guardar',
            data: perfil.frmUsuario.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        window.location = general.base_url + '/login/logout';
                    }else{
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar: ' + e + '.', 'danger', true);
                    }, 500);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar.', 'danger', true);
                }, 500);
            },
            complete: function () {
                general.unblock();
            }
        });
    },
};

perfil.init();
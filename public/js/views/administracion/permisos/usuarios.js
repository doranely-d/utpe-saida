/* global general, bootbox, e */

var usuarios = {
    tblUsuarios: null,
    btnAgregarUsuario: null,
    modalUsuario: null,
    frmUsuario: null,
    idUsuario: null,
    txtRol: null,
    txtInfoRol: null,
    tblRoles: null,
    frmRol: null,

    //metodos
    init: function () {
	//Inicialización de propiedades
	this.tblUsuarios = $('#tblUsuarios');
	this.btnAgregarUsuario = $('#btnAgregarUsuario');

	//Funcionalidad
	this.tblUsuarios.bootstrapTable({
		url: general.base_url + '/usuarios/listar'
	});

	this.tblUsuarios.on('load-success.bs.table', function (e, data) {
	    if (!usuarios.tblUsuarios.is(':visible')) {
			usuarios.tblUsuarios.show();
            usuarios.tblUsuarios.bootstrapTable('resetView');
	    }
	    general.unblock();
	});

	this.tblUsuarios.on('sort.bs.table', function (e, row) {
	    if (usuarios.tblUsuarios.bootstrapTable('getOptions').totalRows > 0) {
		general.block();
	    }
	});

	this.tblUsuarios.on('page-change.bs.table', function (e, row) {
	    if (usuarios.tblUsuarios.bootstrapTable('getOptions').totalRows > 0) {
		general.block();
	    }
	});

	this.tblUsuarios.on('search.bs.table', function (e, row) {
	    if (usuarios.tblUsuarios.bootstrapTable('getOptions').totalRows > 0) {
		general.block();
	    }
	});

	this.tblUsuarios.bootstrapTable({}).on('refresh.bs.table', function (e, row) {
	    if (usuarios.tblUsuarios.bootstrapTable('getOptions').totalRows > 0) {
		general.block();
	    }
	});

	this.tblUsuarios.on('load-error.bs.table', function (e, status) {
	    general.unblock();
	    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al recuperar la información de los usuarios ' + status, 'danger', true);
	});

	this.btnAgregarUsuario.click(function () {
	    usuarios.cargaFrmUsuario();
	});
    },
    cargaFrmUsuario: function (datosIn) {
		var datos = (datosIn !== undefined) ? $.parseJSON($.base64.decode(datosIn)) : null;
		usuarios.idUsuario = (datos !== null) ? parseInt($.trim(datos.ID)) : 0;

		$.ajax({
			type: 'GET',
			url: general.base_url + '/usuarios/modal',
			data: datos,
			contentType: 'application/html; charset=utf-8',
			beforeSend: function (xhr) {
			general.block();
			},
			success: function (resultado) {
			try {
				usuarios.modalUsuario = bootbox.dialog({
				title: '<i class="fa fa-user"></i> Usuario',
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
									usuarios.frmUsuario.submit();
						return false;
					}
					}
				}
				});

				usuarios.modalUsuario.on('shown.bs.modal', function () {
				$('.bootbox-close-button').focus();

				setTimeout(function () {
					$('.bootbox-close-button').focusout();
				}, 100);

				//Inicialización
				usuarios.frmUsuario = $('#frmUsuario');
				usuarios.txtRol = $('#txtRol');
				usuarios.txtInfoRol = $('#txtInfoRol');
				usuarios.tblRoles = $('#tblRoles');
				usuarios.frmRol = $('#frmRol');
				usuarios.txtDependencia = $('#txtDependencia');
				usuarios.txtInfoDependencia = $('#txtInfoDependencia');
				usuarios.tblDependencias = $('#tblDependencias');
				usuarios.frmDependencia = $('#frmDependencia');

				if(usuarios.idUsuario){
                    $("#form-password").hide();
				}

				//Funcionalidad
				usuarios.frmUsuario.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
					.on('success.form.fv', function (e) {
						e.preventDefault();
						if (usuarios.tblRoles.bootstrapTable('getOptions').totalRows > 0 && usuarios.tblDependencias.bootstrapTable('getOptions').totalRows > 0) {
						usuarios.guardarUsuario();
						usuarios.modalUsuario.modal('hide');
						} else {
						general.notify('<strong>Alerta</strong><br/><br/>', 'Debes seleccionar los roles y/o dependencias del usuario.', 'warning', true);
						}
					});

				usuarios.txtRol.typeahead({
					showHintOnFocus: true,
					items: 50,
					delay: 1000,
					source: function (query, process) {
					map = null;
					usuarios.txtInfoRol.val('');

					if ($.trim(query) !== '') {
						$.ajax({
						url: general.base_url + '/usuarios/buscar/?opt=0',
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
							usuarios.txtInfoRol.val(key + '|' + $.trim(map[key].DESCRIPCION));
							usuarios.frmRol
								.formValidation('revalidateField', 'txtRol')
								.formValidation('revalidateField', 'txtInfoRol');

							return false;
						}
						});
					} else {
						item = '';
					}

					return item;
					}
				});

				usuarios.txtDependencia.typeahead({
					showHintOnFocus: true,
					items: 50,
					delay: 1000,
					source: function (query, process) {
					map = null;
					usuarios.txtInfoDependencia.val('');

					if ($.trim(query) !== '') {
						$.ajax({
						url: general.base_url + '/usuarios/buscar/?opt=1',
						type: 'GET',
						data: {txtNombre: query},
						contentType: 'application/json; charset=utf-8',
						success: function (result) {
							map = {};
							objects = [];

							$.each(result.datos, function (i, object) {
							map[$.trim(object.FLEX_VALUE_ID)] = object;
							objects.push($.trim(object.DESCRIPTION));
							});

							process(objects);
						}
						});
					}
					},
					updater: function (item) {
					if (map !== null) {
						$.each(map, function (key, value) {
						if (value.DESCRIPTION === item) {
							usuarios.txtInfoDependencia.val(key + '|' + $.trim(map[key].FLEX_VALUE));
							usuarios.frmDependencia
								.formValidation('revalidateField', 'txtDependencia')
								.formValidation('revalidateField', 'txtInfoDependencia');

							return false;
						}
						});
					} else {
						item = '';
					}

					return item;
					}
				});

				usuarios.tblRoles.bootstrapTable({
					uniqueId: 'ID'
				});
				usuarios.tblRoles.bootstrapTable('resetView');

				usuarios.tblDependencias.bootstrapTable({
					uniqueId: 'FLEX_VALUE_ID'
				});
				usuarios.tblDependencias.bootstrapTable('resetView');

				usuarios.frmRol.formValidation({excluded: [':disabled'], live: 'enabled', locale: 'es_ES'})
					.on('success.form.fv', function (e) {
						e.preventDefault();
						usuarios.agregarRol($.trim(usuarios.txtInfoRol.val()), $.trim(usuarios.txtRol.val()));
					});

				usuarios.frmDependencia.formValidation({excluded: [':disabled'], live: 'enabled', locale: 'es_ES'})
					.on('success.form.fv', function (e) {
						e.preventDefault();
						usuarios.agregarDependencia($.trim(usuarios.txtInfoDependencia.val()), $.trim(usuarios.txtDependencia.val()));
					});

				if (usuarios.idUsuario > 0) {
					usuarios.cargaTablaRoles();
				}
				});
			} catch (e) {
				setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al cargar la página de usuario: ' + e + '.', 'danger', true);
				}, 500);
			}
			},
			error: function () {
			general.unblock();
			setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar la página de usuario.', 'danger', true);
			}, 500);
			},
			complete: function () {
			if (usuarios.idUsuario === 0) {
				general.unblock();
			}
			}
		});
    },
    cargaTablaRoles: function () {
		$.ajax({
			type: 'GET',
			url: general.base_url + '/usuarios/buscar/?opt=2',
			data: {idUsuario: usuarios.idUsuario},
			contentType: 'application/json; charset=utf-8',
			beforeSend: function (xhr) {
			general.block();
			},
			success: function (resultado) {
			try {
				if (resultado.estatus === 'success') {
				usuarios.tblRoles.bootstrapTable({});
				usuarios.tblRoles.bootstrapTable('load', resultado.datos);
				usuarios.tblRoles.bootstrapTable('selectPage', 1);
				} else {
				usuarios.tblRoles.bootstrapTable({});
				general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
				}

				usuarios.tblRoles.bootstrapTable('resetView');
			} catch (e) {
				setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error carga de los roles: ' + e + '.', 'danger', true);
				}, 500);
			}
			},
			error: function () {
			general.unblock();
			setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar los roles.', 'danger', true);
			}, 500);
			},
			complete: function () {
			usuarios.cargaTablaDependencias();
			}
		});
    },
    cargaTablaDependencias: function () {
		$.ajax({
			type: 'GET',
			url: general.base_url + '/usuarios/buscar/?opt=3',
			data: {idUsuario: usuarios.idUsuario},
			contentType: 'application/json; charset=utf-8',
			beforeSend: function (xhr) {
			general.block();
			},
			success: function (resultado) {
			try {
				if (resultado.estatus === 'success') {
				usuarios.tblDependencias.bootstrapTable({});
				usuarios.tblDependencias.bootstrapTable('load', resultado.datos);
				usuarios.tblDependencias.bootstrapTable('selectPage', 1);
				} else {
				usuarios.tblDependencias.bootstrapTable({});
				general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
				}

				usuarios.tblDependencias.bootstrapTable('resetView');
			} catch (e) {
				setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error carga de las dependencias: ' + e + '.', 'danger', true);
				}, 500);
			}
			},
			error: function () {
			general.unblock();
			setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al cargar las dependencias.', 'danger', true);
			}, 500);
			},
			complete: function () {
			general.unblock();
			}
		});
    },
    guardarUsuario: function () {
		var form = usuarios.frmUsuario.serializeArray();

		var data = {
			id: form[0]['value'],
			usuario: form[1]['value'],
			nombre: form[2]['value'],
			correo: form[3]['value'],
            password: form[4]['value'],
			roles: usuarios.tblRoles.bootstrapTable('getData'),
			dependencias: usuarios.tblDependencias.bootstrapTable('getData')
		};
			console.log(" LOG_DATA: "+ JSON.stringify(data));
		$.ajax({
			type: 'POST',
			url: general.base_url + '/usuarios/guardar',
			data: JSON.stringify(data),
			contentType: 'application/json; charset=utf-8',
			dataType: 'json',
			beforeSend: function (xhr) {
			general.block();
			},
			success: function (resultado) {
			try {
				if (resultado.estatus === 'success') {
				usuarios.tblUsuarios.bootstrapTable('refresh');
				}

				general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
			} catch (e) {
				setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al guardar el usuario: ' + e + '.', 'danger', true);
				}, 500);
			}
			},
			error: function () {
			general.unblock();
			setTimeout(function () {
				general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al guardar el usuario.', 'danger', true);
			}, 500);
			},
			complete: function () {
			general.unblock();
			}
		});
    },
    borrarUsuario: function (idIn) {
		var id = (idIn !== undefined) ? $.base64.decode(idIn) : null;
		bootbox.confirm({
			message: "¿Deseas borrar el usuario?",
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
				url: general.base_url + '/usuarios/borrar/?txtIdUsuario=' + id,
				contentType: 'application/json; charset=utf-8',
				beforeSend: function (xhr) {
					general.block();
				},
				success: function (resultado) {
					try {
					if (resultado.estatus === 'success') {
						usuarios.tblUsuarios.bootstrapTable('refresh');
					}

					general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
					} catch (e) {
					setTimeout(function () {
						general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al borrar el usuario: ' + e + '.', 'danger', true);
					}, 500);
					}
				},
				error: function () {
					general.unblock();
					setTimeout(function () {
					general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor al borrar el usuario.', 'danger', true);
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
    agregarRol: function (datos, rol) {
		var datosRol = datos.split("|");

		if (usuarios.tblRoles.bootstrapTable('getRowByUniqueId', datosRol[0]) === null) {
			usuarios.tblRoles.bootstrapTable('insertRow', {
			index: datosRol[0],
			row: {
				ID: datosRol[0],
				NOMBRE: rol,
				DESCRIPCION: datosRol[1]
			}
			});
		} else {
			general.notify('<strong>Alerta</strong><br/><br/>', 'El roles seleccionado ya se ha agregado previamente.', 'warning', true);
		}

		usuarios.txtInfoRol.val('');
		usuarios.txtRol.val('');
		usuarios.frmRol.data('formValidation').resetField('txtInfoRol', '');
		usuarios.frmRol.data('formValidation').resetField('txtRol', '');
    },
    quitarRol: function (id) {
		id = $.base64.decode(id);
		if (usuarios.tblRoles.bootstrapTable('getRowByUniqueId', id) !== null) {
			usuarios.tblRoles.bootstrapTable('removeByUniqueId', id);
		} else {
			general.notify('<strong>Alerta</strong><br/><br/>', 'El roles seleccionado no se ha agregado previamente.', 'warning', true);
		}
    },
    agregarDependencia: function (datos, dependencia) {
		var datosDependencia = datos.split("|");
        	console.log("FLEX_VALUE_ID --------> "+ datosDependencia[0]);
			console.log("FLEX_VALUE -------> "+ datosDependencia[1]);
			console.log("DESCRIPCION ------> "+ dependencia);

		if (usuarios.tblDependencias.bootstrapTable('getRowByUniqueId', datosDependencia[0]) === null) {
			usuarios.tblDependencias.bootstrapTable('insertRow', {
			index: $.trim(datosDependencia[0]),
			row: {
                FLEX_VALUE_ID: datosDependencia[0],
                FLEX_VALUE: $.trim(datosDependencia[1]),
                DESCRIPTION: dependencia
			}
			});
		} else {
			general.notify('<strong>Alerta</strong><br/><br/>', 'La dependencia seleccionada ya se ha agregado previamente.', 'warning', true);
		}

		usuarios.txtDependencia.val('');
		usuarios.txtInfoDependencia.val('');
		usuarios.frmDependencia.data('formValidation').resetField('txtDependencia', '');
		usuarios.frmDependencia.data('formValidation').resetField('txtInfoDependencia', '');
    },
    quitarDependencia: function (id) {
	id = $.trim($.base64.decode(id));

	if (usuarios.tblDependencias.bootstrapTable('getRowByUniqueId', id) !== null) {
	    usuarios.tblDependencias.bootstrapTable('removeByUniqueId', id);
	} else {
	    general.notify('<strong>Alerta</strong><br/><br/>', 'La dependencia seleccionada no se ha agregado previamente.', 'warning', true);
	}
    },
    actionFormatter: function (value, row, index) {
	return [
	    '&nbsp;<a class="btn btn-warning btn-lg btn-xs" role="button" href="javascript:usuarios.cargaFrmUsuario(\'' + $.base64.encode(JSON.stringify(row)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Editar Usuario"><i class="glyphicon glyphicon-pencil"></i></a>',
	    '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:usuarios.borrarUsuario(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Usuario"><i class="glyphicon glyphicon-trash"></i></a>'
	].join('');
    },
    rolesFormatter: function (value, row, index) {
	return [
	    '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:usuarios.quitarRol(\'' + $.base64.encode(row.ID) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Rol"><i class="glyphicon glyphicon-trash"></i></a>'
	].join('');
    },
    dependenciasFormatter: function (value, row, index) {
	return [
	    '&nbsp;<a class="btn btn-danger btn-lg btn-xs" role="button" href="javascript:usuarios.quitarDependencia(\'' + $.base64.encode($.trim(row.FLEX_VALUE_ID)) + '\');" data-toggle="tooltip" data-placement="bottom" title="Borrar Dependencia"><i class="glyphicon glyphicon-trash"></i></a>'
	].join('');
    }
};

usuarios.init();
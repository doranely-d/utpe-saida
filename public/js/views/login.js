//Declaración de Objeto
var login = {
	frmLogin : null,
    btnPassword: null,
    btnEntrar: null,
    btnRegistrar: null,


	init : function () {
		//Inicilización de propiedades del objeto
		this.frmLogin = $('#frmLogin');
		this.btnPassword = $('#btnPassword');
		this.btnEntrar = $('#btnEntrar');
		this.btnRegistrar = $('#btnRegistrar');

        this.btnPassword.click(function () {
            login.cargaFrmAccion();
        });

        this.btnEntrar.click(function () {
            login.cargaFrmAccion();
        });

        this.btnRegistrar.click(function () {
            login.cargaFrmAccion();
        });

		//Funcionalidad
		this.frmLogin.formValidation({excluded: [':disabled', ':hidden', ':not(:visible)'], live: 'enabled', locale: 'es_ES'})
            .on('success.form.fv', function (e) {
                e.preventDefault();
                login.login();
            });
	},
    login: function () {
        $.ajax({
            type: 'POST',
            url: general.base_url + '/login/login',
            data: login.frmLogin.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            beforeSend: function (xhr) {
                general.block();
            },
            success: function (resultado) {
                try {
                    if (resultado.estatus === 'success') {
                        window.location = general.base_url + '/admin';
                    }else{
                        general.notify('<strong>Mensaje del Sistema</strong><br/><br/>', resultado.mensaje, resultado.estatus, true);
                    }
                } catch (e) {
                    setTimeout(function () {
                        general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error al intentar acceder a la Base de datos: ' + e + '.', 'danger', true);
                    }, 2000);
                }
            },
            error: function () {
                general.unblock();
                setTimeout(function () {
                    general.notify('<strong>Ocurrió un error</strong><br/><br/>', 'Ocurrió un error en la petición al servidor.', 'danger', true);
                }, 2000);
            },
            complete: function () {
                general.unblock();
                $('#frmLogin')[0].reset();
            }
        });
    },
};

//Se inicializa el objeto
login.init();
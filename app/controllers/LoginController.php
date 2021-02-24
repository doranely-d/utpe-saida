<?php

class LoginController extends ControllerBase
{

	public function initialize()
	{
		parent::initialize();
	}

	/**  Vista donde se muestra la página de login */
	public function indexAction() {
		$this->tag->setTitle('Login');
	}

    /**
     *  Función para dar/denegar acceso por medio de login
     *  @author Dora Nely Vega Gonzalez
     */
    public function loginAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPost()) {
           // if ($this->security->checkToken()) {
                try {
                    $usuario = $this->request->getPost('txtUsuario', null, '');
                    $password = $this->request->getPost('txtPassword', null, '');

                    if (!empty($usuario) && !empty($password)) {

                        //Consulta el usuario a ingresar
                        $usuarios = SdUsuario::query()
                            ->columns(array('ID_USUARIO' => "SdUsuario.id", 'USUARIO' => 'SdUsuario.usuario',
                                'NOMBRE' => 'SdUsuario.nombre', 'PASSWORD' => 'SdUsuario.password',
                                'FECHA_I' => "to_char(SdUsuario.fecha_i,'DD/MM/YYYY')", 'CORREO' => 'SdUsuario.correo'))
                            ->conditions('SdUsuario.usuario=:usuario: AND SdUsuario.estatus=:estatus:')
                            ->bind(['usuario' => trim($usuario), 'estatus' => 'AC'])
                            ->execute()->getFirst();

                        //Hacemos la consulta de los roles del usuario
                        $roles = SdRol::query()
                            ->columns(array('ID' => "SdRol.id",'NOMBRE' => "SdRol.nombre"))
                            ->innerJoin('SdUsuarioRol', "SdUsuarioRol.id_rol = SdRol.id", 'SdUsuarioRol')
                            ->conditions('SdUsuarioRol.id_usuario=:id_usuario: AND SdRol.estatus=:estatus:')
                            ->bind(['id_usuario' => $usuarios->ID_USUARIO, 'estatus' => 'AC'])
                            ->execute();

                        //Hacemos la consulta de las dependencias por usuario
                        $dependencias = SdUsuarioDependencia::query()
                            ->columns(array('ID_DEPENDENCIA' => "SdUsuarioDependencia.id_dependencia",'DESCRIPCION' => "SdUsuarioDependencia.descripcion"))
                            ->innerJoin('SdUsuario', "SdUsuario.id = SdUsuarioDependencia.id_usuario", 'SdUsuario')
                            ->conditions('SdUsuario.id=:id_usuario: AND SdUsuarioDependencia.estatus=:estatus:')
                            ->bind(['id_usuario' => $usuarios->ID_USUARIO, 'estatus' => 'AC'])
                            ->execute();


                        if ($usuarios) {
                            //validamos el password
                            $security = new \Phalcon\Security();

                            if ($security->checkHash($password, $usuarios->PASSWORD)) {
                                //crea la sesión del usuario
                                $this->session->usuario = [
                                    "id_usuario" => $usuarios->ID_USUARIO,
                                    "usuario" => $usuarios->USUARIO,
                                    "nombre" => $usuarios->NOMBRE,
                                    "correo" => $usuarios->CORREO,
                                    "fecha_i" => $usuarios->FECHA_I,
                                    "roles" => $roles,
                                    "dependencias" => $dependencias,
                                    "isLogin" => 'isLogin'
                                ];

                                $this->mensaje = ['success', 'A ingresado correctamente al sistema.', null];
                            }else{
                                $this->mensaje = ['warning', 'Lo sentimos su Usuario/Contraseña es incorrecto.', null];
                            }
                        } else {
                            // Para protegernos de reiterados ataques. Independientemente de si un usuario existe o no,
                            $this->security->hash(rand());
                            $this->mensaje = ['warning', 'Lo sentimos su Usuario/Contraseña es incorrecto.', null];
                        }
                    }else{
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar entrar al sistema SAIDA.', null];
                }
                //obtenemos el mensaje de respuesta
                $funcion = new Funciones();
                $this->resultado = $funcion->getMensaje($this->mensaje);
                $this->response->setContentType('application/json', 'UTF-8');
                $this->response->setJsonContent($this->resultado);
                $this->response->setStatusCode(200, "OK");
                $this->response->send();
            /*    } else {
                $this->mensaje = ['warning', 'No hay lectura del token', null];
              }*/
        } else {
            $this->mensaje = ['warning', 'No hay acceso post', null];
        }
    }

    /**
     *  Funcion para cerrar sesións
     *  @author Dora Nely Vega Gonzalez
     */
    public function logoutAction()
    {
        $this->view->disable();

        //Remueve la sesión de usuario
        $this->session->remove("usuario");
        // Destruye la sesión usuario
        $this->session->destroy();

        return $this->response->redirect('admin');
    }
}


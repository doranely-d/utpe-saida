<?php

class PerfilController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Perfil');
        parent::initialize();
    }
    /**   Vista donde se muestra la página del perfil del usuario */
    public function indexAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $id =  $this->session->usuario['id_usuario'];

        //Hacemos la búsqueda del usuario
        $usuario = SdUsuario::query()
            ->columns(array('USUARIO'=>'SdUsuario.usuario', 'DEPENDENCIA'=>'SdUsuarioDependencia.descripcion',
                'NOMBRE'=>'SdUsuario.nombre', 'FECHA_I'=>"to_char(SdUsuario.fecha_i,'DD/MM/YYYY')", 'CORREO'=>'SdUsuario.correo'))
            ->innerJoin('SdUsuarioDependencia', "SdUsuarioDependencia.id_usuario = SdUsuario.id", 'SdUsuarioDependencia')
             ->conditions('SdUsuario.id=:id: AND SdUsuario.estatus=:estatus: AND SdUsuarioDependencia.estatus=:estatus:')
            ->bind(['id' => $id, 'estatus' => 'AC'])
            ->execute()->getFirst();

        $this->view->usuario = $usuario->USUARIO;
        $this->view->nombre =  $usuario->NOMBRE;
        $this->view->correo =  $usuario->CORREO;
        $this->view->fecha_i =  $usuario->FECHA_I;
        $this->view->dependencia =  $usuario->DEPENDENCIA;

    }

    /** Muestra el modal dependiendo la opción seleccionada*/
    public function modalAction(){
        //obtenemos la opción del modal a mostrar
        $opt = $this->request->get('opt', null, 0);

        switch ($opt) {
            case 0:
                //Muestra la vista del modal para editar el usuario
                $this->view->pick('perfil/modal/usuario');
                break;
            case 1:
                //muestra la vista del modal para editar el password
                $this->view->pick('perfil/modal/password');
                break;
        }
    }

    /**
     *  Guarda / Modifica el usuario seleccionada en base a su id_usuario
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $id = $this->request->getPost('txtIdUsuario', null, 0);
                    $nombre =  $this->request->getPost('txtNombre', null, '');
                    $correo =  $this->request->getPost('txtCorreo', null, '');
                    $password =  $this->request->getPost('txtPassword', null, '');

                    if(!empty($nombre) & !empty($correo)) {
                        $sdUsuario = SdUsuario::findFirst($id);
                        $sdUsuario->nombre = $nombre;
                        $sdUsuario->correo = $correo;
                        $sdUsuario->usuario_u = $this->session->usuario['usuario'];
                        $sdUsuario->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                    }else {
                        $sdUsuario = SdUsuario::findFirst($id);
                        $sdUsuario->password = $this->security->hash($password);;
                        $sdUsuario->usuario_u = $this->session->usuario['usuario'];
                        $sdUsuario->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                    }
                    if ($sdUsuario) {
                        if ($sdUsuario->save()) {
                            $this->mensaje = ['success', 'Se ha modificado correctamente.', null];
                        } else {
                            foreach ($sdUsuario->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.' .$this->msnError, null];
                        }
                    } else {
                            $this->mensaje = ['warning', 'El usuario no se encuentra en el sistema.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar al usuario.', null];
                }
                $this->resultado = $funcion->getMensaje($this->mensaje);
                $this->response->setContentType('application/json', 'UTF-8');
                $this->response->setJsonContent($this->resultado);
                $this->response->setStatusCode(200, "OK");
                $this->response->send();
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
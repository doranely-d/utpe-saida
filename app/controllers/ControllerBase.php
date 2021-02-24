<?php

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('Saida | ');
        $this->view->setVars(
            [
                'fecha' => date("d/m/Y"),
                'today' => date("Y"),
                'id_usuario' => $this->session->usuario['id_usuario'],
                'usuario'    => $this->session->usuario['usuario'],
                'nombre'    => $this->session->usuario['nombre'],
                'correo'    => $this->session->usuario['correo'],
                'fecha_i'    => $this->session->usuario['fecha_i'],
                'isLogin'    => $this->session->usuario['isLogin'],
                'dependencias' => $this->session->usuario['dependencias'],
                'roles' => $this->session->usuario['roles'],
            ]
        );
    }

    /**  Validamos los días restantes para las solicitudes*/
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $funcion = new Funciones();

        //Validamos el tiempo de espera de las solicitudes en estrado
       // $funcion->validarEstrados();

        //Hacemos la validación a las solicitudes en caso de que tengan condicion
       // $funcion->validarCondicion();
    }

    /**
     *  Verifica si el usuario ha iniciado sesión
     *  @author Dora Nely Vega Gonzalez
     */
    public function isLoginAction(){
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try {
                    // Verifica si el usuario ha iniciado sesión
                    if ($this->session->has('usuario')) {
                        $usuario = $this->session->usuario;
                        //Remueve la sesión de usuario
                        $this->session->remove("usuario");
                        // Destruye la sesión usuario
                        $this->session->destroy();

                        $this->mensaje = ['success', $usuario != null, null];
                    } else {
                        $this->mensaje = ['danger', 'Ocurrió un error al verificar la sesión del usuario.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los estatus.', null];
                }
                $this->resultado = $funcion->getMensaje($this->mensaje);
                $this->response->setContentType('application/json', 'UTF-8');
                $this->response->setJsonContent($this->resultado);
                $this->response->setStatusCode(200, "OK");
                $this->response->send();
            } else {
                $this->response->setStatusCode(404, "Página no encontrada.");
            }
        }
    }
}
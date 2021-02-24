<?php

class CalendarioController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Calendario');
        parent::initialize();
    }

    /** Muestra el calendario de las solicitudes por el tipo(SAI ó ARCO) */
    public function indexAction()
    {
        $tipo = $this->request->get('tipo', null, 0);
        $this->view->tipo = strtoupper($tipo);
    }
    /**
     *  Hace la búsqueda de elementos en formato json
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de la variable
                    $opt = $this->request->get('opt', null, 0);
                    $tipo = $this->request->get('tipo', null, 0);
                    $idTipo =$funcion->getTipo($tipo);

                    switch ($opt) {
                        case 0:
                            //obtenemos las solicitudes en el calendario
                            $registros =$funcion->getSolicitudes($tipo);
                            break;
                        case 1:
                            //obtenemos los estados del calendario activos por flujo
                            $registros = $funcion->obtenerEstados($idTipo);
                            break;
                        case 2:
                            //obtenemos los días inhabiles del calendario
                            $registros = $funcion->getDiasInabiles();
                            break;
                    }
                    if(!empty($registros)){
                        $this->mensaje = ['success', 'Se guardaron correctamente los registros.', $registros];
                    } else {
                        $this->mensaje = ['warning', 'No hay registros disponibles.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los registros.', null];
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
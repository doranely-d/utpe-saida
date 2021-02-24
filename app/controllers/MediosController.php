<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class MediosController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Medios de respuesta');
        parent::initialize();
    }

    /**  Vista donde se muestra el listado de medios de respuesta */
    public function indexAction(){
        $this->view->pick('administracion/medios/index');
    }

    /**
     *  Muestra el modal para agregar y modificar medios de respuesta
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/medios/modal');
        $this->view->id_medio_respuesta = $this->request->get('ID_MEDIO_RESPUESTA', null,'');
        $this->view->medio = $this->request->get('MEDIO', null, '');
        $this->view->costo = $this->request->get('COSTO', null, '');
    }

    /**
     *  Guarda / Modifica medio de respuesta a las solicitudes
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $idMedio = $this->request->getPost('txtIdMedio', null, 0);
                    $medio =  $this->request->getPost('txtMedio', null, '');
                    $costo =  $this->request->getPost('txtCosto', null, 0);

                    if(!empty($medio)) {
                        if (empty(($idMedio))) {
                            $secuencia = $this->db->query('SELECT SD_MEDIO_RESPUESTA_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $sdMedio = new SdMedioRespuesta();
                            $sdMedio->id_medio_respuesta =  $secuencia[0]['NEXTVAL'];
                            $sdMedio->medio = trim($medio);
                            $sdMedio->costo = $costo;
                            $sdMedio->usuario_i = $this->session->usuario['usuario'];
                            $sdMedio->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdMedio->estatus = 'AC';
                        } else {
                            $sdMedio = SdMedioRespuesta::findFirst($idMedio);
                            $sdMedio->medio = trim($medio);
                            $sdMedio->costo = $costo;
                            $sdMedio->usuario_u = $this->session->usuario['usuario'];
                            $sdMedio->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($sdMedio) {
                            if ($sdMedio->save()) {
                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                            } else {
                                foreach ($sdMedio->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null ];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El medio de respuesta seleccionado no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los medios de respuesta.', null];
                }
                //obtenemos el mensaje de respuesta
                $funcion = new Funciones();
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

    /**
     *  Borra el medio de respuesta seleccionado en base a id_medio_respuesta
     *  @var integer $id del medio de respuesta
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del medio de respuesta
                    $idMedio = $this->request->get('txtIdMedio', null, 0);

                    //Se realiza la búsqueda del medio de respuesta
                    $sdMedio = SdMedioRespuesta::findFirst($idMedio);

                    if ($sdMedio) {
                        $sdMedio->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $sdMedio->usuario_u = $this->session->usuario['usuario'];
                        $sdMedio->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdMedio->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el medio de respuesta seleccionado.', null];
                        } else {
                            foreach ($sdMedio->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el medio de repsuesta seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El medio de respuesta no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los medios de respuesta.', null];
                }
                //obtenemos el mensaje de respuesta
                $funcion = new Funciones();
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

    /**
     *  Hace un listado con  los medios de respuesta activos en formato json
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        //Defición de Variables al realizar el filtro
        $limit = $this->request->get('limit', null, 0);
        $offset = $this->request->get('offset', null, 0);
        $order = $this->request->get('order', null, '');
        $sort = $this->request->get('sort', null, '');
        $search = $this->request->get('search', null, '');
        $currentPage =  (($offset/$limit) + 1);
        $total = 0;
        $rows = array();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{

                    //hace la búsqueda de los medios de respuesta
                    $sdMedios = SdMedioRespuesta::find([
                        'columns' => array('ID_MEDIO_RESPUESTA' => "id_medio_respuesta", 'MEDIO'=> 'medio', 'COSTO' => 'costo'),
                        'conditions' => "UPPER(translate(medio, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:medio:)  and estatus=:estatus:",
                        'bind' => ['medio' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'],
                        'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                    ]);

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $sdMedios,
                            'limit' => $limit,
                            'page'  => $currentPage,
                        ]
                    );

                    //Obtiene el total de registros
                    $total = $paginacion->getPaginate()->total_items;

                    // Obtener los resultados paginados
                    $rows = $paginacion->getPaginate()->items;

                    $this->response->setContentType('application/json', 'UTF-8');
                    $this->response->setJsonContent(array('total' => $total, 'rows' => $rows));
                    $this->response->setStatusCode(200, "OK");
                    $this->response->send();
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los medios de respuesta.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
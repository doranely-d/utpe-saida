<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class CondicionesController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Condiciones');
        parent::initialize();
    }
    /** Vista donde se muestra el listado de condiciones */
    public function indexAction(){
        $this->view->pick('administracion/condiciones/index');
    }

    /**
     *  Muestra el modal para agregar y modificar condiciones
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/condiciones/modal');
        $this->view->id = $this->request->get('ID', null,'');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->valor = $this->request->get('VALOR', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
        $this->view->id_flujo = $this->request->get('ID_FLUJO', null, '');
        $this->view->flujo = $this->request->get('FLUJO', null, '');
    }
    /**
     *  Guarda / Modifica una condición de las fases
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $idCondicion = $this->request->getPost('txtIdCondicion', null, 0);
                    $nombre =  $this->request->getPost('txtNombre', null, '');
                    $valor =  $this->request->getPost('txtValor', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');
                    $flujo =  $this->request->getPost('slFlujo', null, '');

                    if(!empty($nombre) & !empty($valor) & !empty($descripcion)) {
                        if (empty(($idCondicion))) {

                            $secuencia = $this->db->query('SELECT SD_FLUJO_CONDICION_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $sdCondiciones = new SdFlujoCondicion();
                            $sdCondiciones->id =  $secuencia[0]['NEXTVAL'];
                            if($flujo){
                                $sdCondiciones->id_flujo = $flujo;
                            }
                            $sdCondiciones->nombre = $nombre;
                            $sdCondiciones->valor = $valor;
                            $sdCondiciones->descripcion = $descripcion;
                            $sdCondiciones->usuario_i = $this->session->usuario['usuario'];
                            $sdCondiciones->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdCondiciones->estatus = 'AC';
                        } else {
                            $sdCondiciones = SdFlujoCondicion::findFirst($idCondicion);
                            if($flujo){
                                $sdCondiciones->id_flujo = $flujo;
                            }
                            $sdCondiciones->nombre = $nombre;
                            $sdCondiciones->valor = $valor;
                            $sdCondiciones->descripcion = $descripcion;
                            $sdCondiciones->usuario_u = $this->session->usuario['usuario'];
                            $sdCondiciones->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($sdCondiciones) {
                            if ($sdCondiciones->save()) {
                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                            } else {
                                foreach ($sdCondiciones->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.' . $this->msnError , null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'La condición seleccionada no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las condiciones.', null];
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
     *  Borra la condición seleccionada en base a id_condicion
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id de la condición
                    $idCondicion = $this->request->get('txtIdCondicion', null, 0);

                    //Se realiza la búsqueda de la condición seleccionada
                    $sdCondiciones = SdFlujoCondicion::findFirst($idCondicion);

                    if ($sdCondiciones) {
                        $sdCondiciones->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $sdCondiciones->usuario_u = $this->session->usuario['usuario'];
                        $sdCondiciones->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdCondiciones->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente la condición seleccionada.', null];
                        } else {
                            foreach ($sdCondiciones->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar la condición seleccionada.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'La condición no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las condiciones.', null];
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
     *  Hace un listado con las condiciones activas
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

                   //realizamos la búsqueda de las condiciones activas
                   $sdCondiciones = SdFlujoCondicion::query()
                       ->columns( array('ID' => "SdFlujoCondicion.id", 'NOMBRE'=> 'SdFlujoCondicion.nombre',
                           'VALOR'=> 'SdFlujoCondicion.valor', 'ID_FLUJO'=> 'SdFlujo.id_flujo', 'FLUJO'=> 'SdFlujo.nombre',
                           'DESCRIPCION' => 'SdFlujoCondicion.descripcion'))
                       ->innerJoin('SdFlujo', "SdFlujo.id_flujo = SdFlujoCondicion.id_flujo", 'SdFlujo')
                       ->conditions("UPPER(translate(SdFlujoCondicion.nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:)
                                                AND SdFlujoCondicion.estatus=:estatus:")
                       ->bind(['nombre' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU"). '%', 'estatus'=>'AC'])
                       ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                       ->execute();

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $sdCondiciones,
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
                   $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las condiciones.', null];
               }
           }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }

    /**
     *  Obtiene los registros en base a la opción seleccionada en formato json
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction()
    {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    $registros = SdFlujo::find([
                           'columns' => array('ID_FLUJO' => "id_flujo", 'NOMBRE'=> 'nombre'),
                           'conditions' => "estatus='AC'",
                       ]);

                    if($registros){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $registros]; //se debe enviar los recursos
                    }else{
                        $this->mensaje = ['danger', 'No hay registros disponibles.', null];
                    }
                }catch (\Exception $e) {
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
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class AccionesController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Acciones');
        parent::initialize();
    }

    /**  Vista donde se muestra el listado de acciones */
    public function indexAction(){
        $this->view->pick('administracion/permisos/acciones/index');
    }

    /**
     *  Muestra el modal para agregar y modificar acciones
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/permisos/acciones/modal');
        $this->view->id = $this->request->get('ID', null,'');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
    }

    /**
     *  Guarda / Modifica una acción en los permios del sistema
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $id = $this->request->getPost('txtIdAccion', null, 0);
                    $nombre =  $this->request->getPost('txtNombre', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');

                    if(!empty($nombre) & !empty($descripcion)) {
                        if (empty(($id))) {
                            $secuencia = $this->db->query('SELECT SD_ACCION_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $sdAccion = new SdAccion();
                            $sdAccion->id =  $secuencia[0]['NEXTVAL'];
                            $sdAccion->nombre = strtolower($nombre);
                            $sdAccion->descripcion = $descripcion;
                            $sdAccion->usuario_i = $this->session->usuario['usuario'];
                            $sdAccion->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdAccion->estatus = 'AC';
                        } else {
                            $sdAccion = SdAccion::findFirst($id);
                            $sdAccion->nombre = strtolower($nombre);
                            $sdAccion->descripcion = $descripcion;
                            $sdAccion->usuario_u = $this->session->usuario['usuario'];
                            $sdAccion->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($sdAccion) {
                            if ($sdAccion->save()) {
                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                            } else {
                                foreach ($sdAccion->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'La acción seleccionada no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las acciones.', null];
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
     *  Borra la acción seleccionada en base a id
     *  @var integer $id de la acción
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id de la acción
                    $id = $this->request->get('txtIdAccion', null, 0);

                    //Se realiza la búsqueda de la acción seleccionada
                    $sdAccion = SdAccion::findFirst($id);

                    if ($sdAccion) {
                        $sdAccion->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $sdAccion->usuario_u = $this->session->usuario['usuario'];
                        $sdAccion->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdAccion->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente la acción seleccionada.', null];
                        } else {
                            foreach ($sdAccion->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar la acción seleccionada.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'La acción no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las acciones.', null];
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
     *  Hace un listado con las acciones activas en formato json
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

                   //obtiene los registros del modelo accion
                   $acciones = SdAccion::find([
                       'columns' => array('ID' => "id", 'NOMBRE'=> 'nombre', 'DESCRIPCION' => 'descripcion'),
                       'conditions' => "UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:)  and estatus=:estatus:",
                       'bind' => ['nombre' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'],
                       'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                   ]);

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $acciones,
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
                   $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las acciones.', null];
               }
           }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
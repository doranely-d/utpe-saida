<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ParametrosController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Parámetros');
        parent::initialize();
    }
    /***  Vista donde se muestra el listado de los parámetros */
    public function indexAction(){
        $this->view->pick('administracion/parametros/index');
    }

    /**
     *  Muestra el modal para agregar y modificar parámetros
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/parametros/modal');
        $this->view->id_parametro = $this->request->get('ID_PARAMETRO', null,'');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->valor = $this->request->get('VALOR', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
    }

    /**
     *  Guarda / Modifica parámetro
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $idParametro = $this->request->getPost('txtIdParametro', null, 0);
                    $nombre =  $this->request->getPost('txtNombre', null, '');
                    $valor =  $this->request->getPost('txtValor', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');

                    if(!empty($nombre) & !empty($valor) &!empty($descripcion)) {
                        if (empty(($idParametro))) {
                            $secuencia = $this->db->query('SELECT SD_PARAMETROS_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $sdParametros = new SdParametros();
                            $sdParametros->id_parametro =  $secuencia[0]['NEXTVAL'];
                            $sdParametros->nombre = strtolower($nombre);
                            $sdParametros->valor = $valor;
                            $sdParametros->descripcion = $descripcion;
                            $sdParametros->usuario_i = $this->session->usuario['usuario'];
                            $sdParametros->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdParametros->estatus = 'AC';
                        } else {
                            $sdParametros = SdParametros::findFirst($idParametro);
                            $sdParametros->nombre = strtolower($nombre);
                            $sdParametros->valor = $valor;
                            $sdParametros->descripcion = $descripcion;
                            $sdParametros->usuario_u = $this->session->usuario['usuario'];
                            $sdParametros->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($sdParametros) {
                            if ($sdParametros->save()) {
                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                            } else {
                                foreach ($sdParametros->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.',   $this->msnError];
                            }
                        } else {
                            $this->mensaje = ['warning', 'La acción seleccionada no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los parametros.', null];
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
     *  Borra el parámetro seleccionado en base a id_parametro
     *  @var integer $id del parámetro
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del parámetro
                    $idParametro = $this->request->get('txtIdParametro', null, 0);

                    //Se realiza la búsqueda del parámetro seleccionado
                    $sdParametros = SdParametros::findFirst($idParametro);

                    if ($sdParametros) {
                        $sdParametros->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $sdParametros->usuario_u = $this->session->usuario['usuario'];
                        $sdParametros->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdParametros->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el parámetro seleccionado.', null];
                        } else {
                            foreach ($sdParametros->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el parámetro seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'EL parámetro seleccionado no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los parametros.', null];
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
     *  Hace un listado con los parámetros activos en formato json
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

                   //Se realiza la búsqueda de los parámetros
                   $sdParametros = SdParametros::find([
                       'columns' => array('ID_PARAMETRO' => "id_parametro", 'NOMBRE'=> 'nombre', 'VALOR'=> 'valor', 'DESCRIPCION' => 'descripcion'),
                       'conditions' => "UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:) and estatus=:estatus:",
                       'bind' => ['nombre' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU"). '%', 'estatus'=>'AC'],
                       'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                   ]);

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $sdParametros,
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
               } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los parametros.', null];
                }
           }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
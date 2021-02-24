<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 08/05/2018
 * Time: 12:32 PM
 */
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class TemasController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Temas');
        parent::initialize();
    }

    /** Vista donde se muestra el listado de temas*/
    public function indexAction()
    {
        $this->view->pick('administracion/catalogo/temas/index');
    }

    /**
     *  Muestra el modal para agregar y  modificar temas
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/catalogo/temas/modal');   //cambiamos la dirección de la vista
        $this->view->id_tema = $this->request->get('ID_TEMA', null, '');
        $this->view->tema = $this->request->get('TEMA', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
    }

    /**
     *  Guarda / Modifica el tema seleccionada en base a su id_tema
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
                    $idTema = $this->request->getPost('txtIdTema', null, 0);
                    $tema =  $this->request->getPost('txtTema', null, '');
                    $descripcion = $this->request->getPost('txtDescripcion', null, '');

                    if(!empty($tema) & !empty($descripcion)) {
                        if (empty(($idTema))) {
                            $secuencia = $this->db->query('SELECT SD_TEMA_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $sdTema = new SdTema();
                            $sdTema->id_tema =  $secuencia[0]['NEXTVAL'];
                            $sdTema->tema = ucfirst($tema);
                            $sdTema->descripcion = $descripcion;
                            $sdTema->usuario_i = $this->session->usuario['usuario'];
                            $sdTema->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdTema->estatus = 'AC';
                        } else {
                            //Seleccionamos el tema a editar
                            $sdTema = SdTema::findFirst($idTema);

                            $sdTema->tema = ucfirst($tema);
                            $sdTema->descripcion = $descripcion;
                            $sdTema->usuario_u = $this->session->usuario['usuario'];
                            $sdTema->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($sdTema) {
                            if ($sdTema->save()) {
                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                            } else {
                                foreach ($sdTema->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error( $this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];                            }
                        } else {
                            $this->mensaje = ['warning', 'El tema seleccionado no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los temas.', null];
                }
                //obtenemos el mensaje de respuesta
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
     *  Borra el tema seleccionada en base a id_tema
     *  @param int $id del tema
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del tema
                    $idTema = $this->request->get('txtIdTema', null, 0);

                    //Se realiza la búsqueda del tema a borrar
                    $sdTema = SdTema::findFirst($idTema);

                    if ($sdTema) {
                        $sdTema->estatus = 'IN'; //cambiamos el estatus a INACTIVO
                        $sdTema->usuario_u = $this->session->usuario['usuario'];
                        $sdTema->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdTema->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el tema seleccionado.', null];
                        } else {
                            foreach ($sdTema->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error( $this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el tema seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'el tema no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los temas.', null];
                }
                //obtenemos el mensaje de respuesta
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
     *  Hace un listado con los temas activos
     *  Retorna array en formato json con todos los temas
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

                    //obtiene los registros del modelo tema
                    $temas = SdTema::find([
                        'columns' => array('ID_TEMA' => "id_tema", 'TEMA'=> 'tema', 'DESCRIPCION' => 'descripcion', 'ESTATUS'=>'estatus'),
                        'conditions' => "UPPER(translate(tema, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:tema:) AND estatus=:estatus:",
                        'bind' => ['tema' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'],
                        'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                    ]);

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $temas,
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
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los temas.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
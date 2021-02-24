<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 08/05/2018
 * Time: 01:46 PM
 */
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class SubtemasController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Subtemas');
        parent::initialize();
    }

    /** Vista donde se muestra el listado de subtemas */
    public function indexAction()
    {
        $this->view->pick('administracion/catalogo/subtemas/index');
    }

    /**
     *  Muestra el modal para agregar y  modificar subtemas
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction(){
        $this->view->pick('administracion/catalogo/subtemas/modal'); //cambiamos la dirección de la vista
        $this->view->id_subtema = $this->request->get('ID_SUBTEMA', null, '');
        $this->view->id_tema = $this->request->get('ID_TEMA', null, '');
        $this->view->tema = $this->request->get('TEMA', null, '');
        $this->view->subtema = $this->request->get('SUBTEMA', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
    }

    /**
     *  Guarda /Modifica el subtema seleccionado en base a su id_subtema
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
                    $idSubtema = $this->request->getPost('txtIdSubtema', null, 0);
                    $id_tema =  $this->request->getPost('slTema', null, '');
                    $idTema =  $this->request->getPost('txtIdTema', null, '');
                    $subtema =  $this->request->getPost('txtSubtema', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');

                    //hace la validacion de los campos que no sean vacios
                    if(!empty($subtema) & !empty($descripcion)) {
                        //Valida si la acción es guardar o modificar
                        if (empty(($idSubtema))) {
                            //Obtenemos la secuencia del id_subtema
                            $secuencia = $this->db->query('SELECT SD_SUBTEMA_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            //creamos un subtema
                            $sdSubTema = new SdSubtema();
                            $sdSubTema->id_subtema =  $secuencia[0]['NEXTVAL'];
                            $sdSubTema->subtema = ucfirst($subtema);
                            $sdSubTema->descripcion = $descripcion;
                            $sdSubTema->usuario_i = "dvegag"; //$this->session->usuario['usuario'];
                            $sdSubTema->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdSubTema->estatus = 'AC';

                        } else {
                            //seleccionamos el subtema para realizar la modificación
                            $sdSubTema = SdSubtema::findFirst($idSubtema);

                            if($sdSubTema){
                                $sdSubTema->subtema = ucfirst($subtema);
                                $sdSubTema->descripcion = $descripcion;
                                $sdSubTema->usuario_u = $this->session->usuario['usuario'];
                                $sdSubTema->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                            }else{
                                $this->mensaje = ['danger', 'Ocurrio un error al modificar los registros.', null];
                            }
                        }
                        if ($sdSubTema) {
                            //obtenemos el tema en base al id_tema
                            $sdTema = SdTema::findFirst($id_tema);
                            $flag = true; //bandera para verificar el eliminado de registro SdTemaSubtema

                            if($sdTema){
                                if ($sdSubTema->save()) {
                                    if(!empty($idTema)) {
                                        //Elimina el registro SdTemaSubtema cuando se hace la edición
                                        $query = " DELETE FROM SdTemaSubtema WHERE id_tema = :id_tema: AND id_subtema = :id_subtema:";
                                        $result = $this->modelsManager->executeQuery($query, array('id_tema' => $idTema, 'id_subtema' => $idSubtema));

                                        if ($result->success() === false) {
                                            $flag =  false;
                                        }
                                    }
                                    if($flag){
                                        //llenado de la relacion sd_tema_subtema
                                        $temaSubtema = new SdTemaSubtema();
                                        $temaSubtema->id_tema = $sdTema->id_tema;
                                        $temaSubtema->id_subtema = $sdSubTema->id_subtema;
                                        $temaSubtema->usuario_i = $this->session->usuario['usuario'];
                                        $temaSubtema->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $temaSubtema->estatus = 'AC';

                                        if ($temaSubtema) {
                                            if ($temaSubtema->save()) {
                                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                            } else {
                                                foreach ($sdSubTema->getMessages() as $message) {
                                                    $this->msnError .= $message->getMessage() . "<br/>";
                                                }
                                                $this->logger->error($this->msnError);
                                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                                            }
                                        }
                                    }else{
                                        $this->mensaje = ['danger', 'Ocurrio un error al editar los registos.', null];
                                    }
                                } else {
                                    foreach ($sdSubTema->getMessages() as $message) {
                                        $this->msnError .= $message->getMessage() . "<br/>";
                                    }
                                    $this->logger->error($this->msnError);
                                    $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                                }
                            }else {
                                $this->mensaje = ['danger', 'El tema seleccionado no se encuentra en el sistema.', null];
                            }
                        }else {
                            $this->mensaje = ['warning', 'El subtema seleccionado no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los subtemas.', null];
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
     *  Borra el subtema seleccionado en base a id_subtema
     *  @param int $id del subtema
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del subtema
                    $idSubtema = $this->request->get('txtIdSubtema', null, 0);

                    //Se realiza la búsqueda del subtema
                    $sdSubtema = SdSubtema::findFirst($idSubtema);

                    if ($sdSubtema) {
                        $sdSubtema->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $sdSubtema->usuario_u = $this->session->usuario['usuario'];
                        $sdSubtema->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdSubtema->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el subtema seleccionado.', null];
                        } else {
                            foreach ($sdSubtema->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el subtema seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El subtema no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los subtemas.', null];
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
     *  Hace un listado con los subtemas activos
     *  Retorna array en formato json con todos los subtemas
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

                    //obtiene los registros del modelo subtemas
                    $sdSubtemas = SdSubtema::query()
                        ->columns(array('ID_SUBTEMA' => "SdSubtema.id_subtema",'SUBTEMA'=> 'SdSubtema.subtema', 'TEMA'=> 'SdTema.tema',
                            'ID_TEMA'=> 'SdTema.id_tema', 'DESCRIPCION' => 'SdSubtema.descripcion', 'ESTATUS'=>'SdSubtema.estatus'))
                        ->join('SdTemaSubtema', "SdTemaSubtema.id_subtema = SdSubtema.id_subtema", 'SdTemaSubtema', 'INNER')
                        ->join('SdTema', "SdTema.id_tema = SdTemaSubtema.id_tema", 'SdTema', 'INNER')
                        ->conditions("UPPER(translate(SdSubtema.subtema, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:subtemas:) 
                         AND SdSubtema.estatus=:estatus: AND SdTema.estatus=:estatus: AND SdTemaSubtema.estatus=:estatus:")
                        ->bind(['subtemas' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'])
                        ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                        ->execute();

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $sdSubtemas,
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

    /**
     *  Obtiene los temas activos
     *  Retorna array en formato json con todos los temas
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    $tema = $this->request->get('txtTema', null, 0);

                    //obtiene los registros del modelo temas
                    $sdTemas = SdTema::find([
                        'columns' => array('ID_TEMA' => "id_tema", 'TEMA'=> 'tema'),
                        'conditions' => "UPPER(translate(tema, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:tema:) AND estatus='AC'",
                        'bind' => ['tema' => '%' . strtr(strtoupper(trim($tema)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU"). '%'],
                    ]);

                    if($sdTemas){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $sdTemas];
                    }else{
                        $this->mensaje = ['danger', 'No hay registros disponibles en la tabla de temas.', null];
                    }
                    //obtenemos el mensaje de respuesta
                    $this->resultado = $funcion->getMensaje($this->mensaje);
                    $this->response->setContentType('application/json', 'UTF-8');
                    $this->response->setJsonContent($this->resultado);
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
<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 08/05/2018
 * Time: 03:01 PM
 */
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class TitulosController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Títulos');
        parent::initialize();
    }
    /** Vista donde se muestra el listado de titulos */
    public function indexAction()
    {
        $this->view->pick('administracion/catalogo/titulos/index');
    }

    /**
     *  Muestra el modal para agregar y  modificar titulo
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/catalogo/titulos/modal');
        $this->view->id_titulo = $this->request->get('ID_TITULO', null, '');
        $this->view->titulo = $this->request->get('TITULO', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
        $this->view->subtema = $this->request->get('SUBTEMA', null, '');
        $this->view->id_subtema = $this->request->get('ID_SUBTEMA', null, '');
    }

    /**
     *  Guarda  / Modifica el titulo seleccionada en base a su id_titulo
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
                    $idTitulo = $this->request->getPost('txtIdTitulo', null, 0);
                    $slSubtema =  $this->request->getPost('slSubtema', null, 0);
                    $txtIdSubtema =  $this->request->getPost('txtIdSubtema', null, 0);
                    $titulo =  $this->request->getPost('txtTitulo', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');

                    //hace la validacion de los campos que no sean vacios
                    if(!empty($titulo) & !empty($descripcion)) {
                        //Valida si la acción es guardar o modificar
                        if (empty(($idTitulo))) {
                            //Obtenemos la secuencia del id_titulo
                            $secuencia = $this->db->query('SELECT SD_TITULO_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            //creamos un titulo
                            $sdTitulo = new SdTitulo();
                            $sdTitulo->id_titulo =  $secuencia[0]['NEXTVAL'];
                            $sdTitulo->titulo = ucfirst($titulo);
                            $sdTitulo->descripcion = $descripcion;
                            $sdTitulo->usuario_i = $this->session->usuario['usuario'];
                            $sdTitulo->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdTitulo->estatus = 'AC';

                        } else {
                            //seleccionamos el titulo para realizar la modificación
                            $sdTitulo = SdTitulo::findFirst($idTitulo);

                            if($sdTitulo){
                                $sdTitulo->titulo = ucfirst($titulo);
                                $sdTitulo->descripcion = $descripcion;
                                $sdTitulo->usuario_u = $this->session->usuario['usuario'];
                                $sdTitulo->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                            }else{
                                $this->mensaje = ['danger', 'Ocurrio un error al modificar los registros.', null];
                            }
                        }
                        if ($sdTitulo) {
                            //obtenemos el subtema en base al id_subtema
                            $sdSubTema = SdSubtema::findFirst($slSubtema);
                            $flag = true; //bandera para verificar el eliminado de registro SdTemaSubtema

                            if($sdSubTema){
                                if ($sdTitulo->save()) {
                                    if(!empty($txtIdSubtema)) {
                                        //Elimina el registro SdTemaSubtema cuando se hace la edición
                                        $query = " DELETE FROM SdSubtemaTitulo WHERE id_subtema = :id_subtema: AND id_titulo = :id_titulo:";
                                        $result = $this->modelsManager->executeQuery($query, array('id_subtema' => $txtIdSubtema, 'id_titulo' => $idTitulo));

                                        if ($result->success() === false) {
                                            $flag =  false;
                                        }
                                    }
                                    if($flag){
                                        //llenado de la relacion SdSubtemaTitulo
                                        $SdSubtemaTitulo = new SdSubtemaTitulo();
                                        $SdSubtemaTitulo->id_subtema = $sdSubTema->id_subtema;
                                        $SdSubtemaTitulo->id_titulo = $sdTitulo->id_titulo;
                                        $SdSubtemaTitulo->usuario_i = $this->session->usuario['usuario'];
                                        $SdSubtemaTitulo->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $SdSubtemaTitulo->estatus = 'AC';

                                        if ($SdSubtemaTitulo) {
                                            if ($SdSubtemaTitulo->save()) {
                                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                            } else {
                                                foreach ($SdSubtemaTitulo->getMessages() as $message) {
                                                    $this->msnError .= $message->getMessage() . "<br/>";
                                                }
                                                $this->logger->error($this->msnError);
                                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                                            }
                                        }
                                    }else{
                                        $this->mensaje = ['danger', 'Ocurrio un error al acceder a los títulos.', null];
                                    }
                                } else {
                                    foreach ($sdTitulo->getMessages() as $message) {
                                        $this->msnError .= $message->getMessage() . "<br/>";
                                    }
                                    $this->logger->error($this->msnError);
                                    $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                                }
                            }else {
                                $this->mensaje = ['danger', 'El título seleccionado no se encuentra en el sistema.', null];
                            }
                        }else {
                            $this->mensaje = ['warning', 'El título seleccionado no se encuentra en el sistema.', null];
                        }

                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los titulos.', null];
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
     *  Borra el titulo seleccionado en base a id_titulo
     *  @param int $id del título
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del título
                    $idTitulo = $this->request->get('txtIdTitulo', null, 0);

                    //Se realiza la búsqueda del título a borrar
                    $sdTitulo = SdTitulo::findFirst($idTitulo);

                    if ($sdTitulo) {
                        $sdTitulo->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $sdTitulo->usuario_u = $this->session->usuario['usuario'];
                        $sdTitulo->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdTitulo->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el título seleccionado.', null];
                        } else {
                            foreach ($sdTitulo->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el título seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El título no se encuentra en base de datos.', null];
                    }

                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los titulos.', null];
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
     *  Hace un listado con los titulos activos
     *  Retorna array en formato json con todos los títulos
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
            //si es una petición ajax
            if ($this->request->isAjax() == true) {
                try {

                    //obtiene los registros del modelo titulo
                    $titulos = SdTitulo::query()
                        ->columns(array('ID_TITULO' => "SdTitulo.id_titulo",'TITULO'=> 'SdTitulo.titulo', 'ID_SUBTEMA' => "SdSubtema.id_subtema",
                            'SUBTEMA'=> 'SdSubtema.subtema', 'DESCRIPCION' => 'SdTitulo.descripcion', 'ESTATUS'=>'SdTitulo.estatus'))
                        ->join('SdSubtemaTitulo', "SdSubtemaTitulo.id_titulo = SdTitulo.id_titulo", 'SdSubtemaTitulo', 'INNER')
                        ->join('SdSubtema', "SdSubtema.id_subtema = SdSubtemaTitulo.id_subtema", 'SdSubtema', 'INNER')
                        ->conditions("UPPER(translate(SdTitulo.titulo, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:titulo:)  
                        AND SdTitulo.estatus=:estatus: AND SdSubtema.estatus=:estatus: AND SdSubtemaTitulo.estatus=:estatus:")
                        ->bind(['titulo' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU")  . '%', 'estatus'=>'AC'])
                        ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                        ->execute();

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $titulos,
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

    /**
     *  Obtiene los subtemas activos
     *  Retorna array en formato json con todos los subtemas
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    $subtema = $this->request->get('txtSubtema', null, 0);

                    //obtiene los registros del modelo subtemas
                    $sdSubtemas = SdSubtema::find([
                        'columns' => array('ID_SUBTEMA' => "id_subtema", 'SUBTEMA'=> 'subtema'),
                        'conditions' => "UPPER(subtema) LIKE :subtema: AND estatus='AC'",
                        'bind' => ['subtema' => '%' . strtoupper(trim($subtema)) . '%'],
                    ]);

                    if($sdSubtemas){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $sdSubtemas];
                    }else{
                        $this->mensaje = ['danger', 'No hay registros disponibles en la tabla de títulos.', null];
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
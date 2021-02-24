<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class RecursosController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Recursos');
        parent::initialize();
    }

    /** Vista donde se muestra el listado de recursos */
    public function indexAction(){
        $this->view->pick('administracion/permisos/recursos/index');
    }

    /**
     *  Muestra el modal para agregar y modificar recursos
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/permisos/recursos/modal');
        $this->view->id = $this->request->get('ID', null, '');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
    }

    /**
     *  Guarda / Modifica el recurso seleccionado en base a su id_recurso
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();
        $flag = true; //bandera para verificar el eliminado de registro SdRecursoAccion

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $id = $this->request->getPost('txtIdRecurso', null, 0);
                    $nombre =  $this->request->getPost('txtNombre', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');
                    $privacidad =  $this->request->getPost('slPrivacidad', null, 'PRIVADA');

                    //obtenemos las acciones a relacionar
                    $acciones = SdAccion::find([
                        'columns' => array('ID' => "id", "NOMBRE"=>"nombre"),
                        'conditions' => "nombre IN('index', 'modal', 'guardar', 'borrar', 'listar', 'buscar') AND estatus='AC'"
                    ]);

                    if(!empty($nombre) & !empty($descripcion) & count($acciones) > 0) {
                        if (empty(($id))) {
                            $secuencia = $this->db->query('SELECT SD_RECURSO_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $recurso = new SdRecurso();
                            $recurso->id =  $secuencia[0]['NEXTVAL'];
                            $recurso->nombre = strtolower($nombre);
                            $recurso->descripcion = $descripcion;
                            $recurso->usuario_i = $this->session->usuario['usuario'];
                            $recurso->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $recurso->estatus = 'AC';
                        } else {
                            // Seleccionamos el recurso a modificar
                            $recurso = SdRecurso::findFirst($id);
                            $recurso->nombre = strtolower($nombre);
                            $recurso->descripcion = $descripcion;
                            $recurso->usuario_u = $this->session->usuario['usuario'];
                            $recurso->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($recurso) {
                            if ($recurso->save()) {
                                if (empty(($id))) {
                                    //Elimina el registro RecursoAccion cuando se hace la edición
                                    $query = " DELETE FROM SdRecursoAccion WHERE id_recurso = :id_recurso:";
                                    $result = $this->modelsManager->executeQuery($query, array('id_recurso' =>$id));

                                    if ($result->success() === false) {
                                        $flag =  false;
                                    }
                                }
                                if($flag) {
                                    foreach ( $acciones as $accion) {
                                        $recursoAccion = new SdRecursoAccion();
                                        $recursoAccion->id_accion = $accion->ID;
                                        $recursoAccion->id_recurso = $recurso->id;
                                        $recursoAccion->privacidad = $privacidad;
                                        $recursoAccion->descripcion = $recurso->nombre . ' + ' . $accion->NOMBRE;
                                        $recursoAccion->usuario_i = $this->session->usuario['usuario'];
                                        $recursoAccion->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $recursoAccion->estatus = 'AC';

                                        if ($recursoAccion) {
                                            if ($recursoAccion->save()) {
                                                //hacemos la busqueda de los items del menu que estan relacionados con los recursos
                                                $phql = "SELECT M.id_menu AS ID_MENU, M.id_padre AS ID_PADRE, M.nombre
                                                      AS NOMBRE, M.url AS URL, M.icono AS ICONO, M.orden AS ORDEN,
                                                      (SELECT COUNT(*) AS COUN FROM SdMenu MM WHERE MM.id_padre= M.id_menu AND MM.url LIKE :recurso:) AS SUBMENUS
                                                   FROM SdMenu  M
                                                   WHERE   M.url  LIKE :recurso: AND M.estatus = :estatus:
                                                GROUP BY M.id_menu,  M.id_padre, M.nombre, M.url, M.icono, M.orden
                                                ORDER BY M.orden ASC";

                                                $menus  = $query = $this->modelsManager->executeQuery($phql, ['id_padre' => 0, 'recurso' => $recurso->nombre, 'estatus' => 'AC']);

                                                if($menus){
                                                    //creamos la relación del menu con los recursos
                                                    foreach ($menus as $menu) {
                                                        $sdMenuRecurso = new SdMenuRol();
                                                        $sdMenuRecurso->id_recurso = $recurso->id;
                                                        $sdMenuRecurso->id_menu = $menu->ID_MENU;
                                                        $sdMenuRecurso->descripcion = $recurso->nombre. ' + ' .$menu->NOMBRE;
                                                        $sdMenuRecurso->usuario_i = $this->session->usuario['usuario'];
                                                        $sdMenuRecurso->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                        $sdMenuRecurso->estatus = 'AC';
                                                    }
                                                }
                                                $this->mensaje = ['success', 'Se guardo correctamente.', null];
                                            } else {
                                                foreach ($recursoAccion->getMessages() as $message) {
                                                    $this->msnError .= $message->getMessage() . "<br/>";
                                                }
                                                $this->logger->error($this->msnError);
                                                $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .   $this->msnError , null];
                                            }
                                        } else {
                                            $this->mensaje = ['warning', 'Las acciones no pueden ser relacionados con el recurso.', null];
                                        }
                                    }
                                }else{
                                    $this->mensaje = ['error', 'Ocurrio un error al editar el recurso.', null];
                                }
                            } else {
                                foreach ($recurso->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['error', 'Ocurrio un error al registrar el recurso.' . $this->msnError, null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El recurso seleccionada no se encuentra en el sistema.', null];

                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los recursos.', null];
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
     *  Borra el recurso seleccionado en base a id_recurso
     *  @var integer $id del recurso
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del recurso
                    $idRecurso = $this->request->get('txtIdRecurso', null, 0);

                    //Se realiza la búsqueda del recurso a borrar
                    $sdRecurso = SdRecurso::findFirst($idRecurso);

                    if ($sdRecurso) {
                        $sdRecurso->estatus = 'IN'; //cambiamos el estatus a INACTIVO
                        $sdRecurso->usuario_u = $this->session->usuario['usuario'];
                        $sdRecurso->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdRecurso->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el plazo seleccionado.', null];
                        } else {
                            foreach ($sdRecurso->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el plazo seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El recurso no se encuentra en base de datos.', null];
                    }

                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los recursos.', null];
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
     *  Hace un listado con los recursos activos
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

                    //obtiene los registros del modelo recursos
                    $recursos = SdRecurso::find([
                        'columns' => array('ID' => "id", 'NOMBRE'=> 'nombre', 'DESCRIPCION' => 'descripcion'),
                        'conditions' => "UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:) and estatus=:estatus:",
                        'bind' => ['nombre' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU")  . '%', 'estatus'=>'AC'],
                        'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                    ]);

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $recursos,
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
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los recursos.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
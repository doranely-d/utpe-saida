<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class RolesController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Roles');
        parent::initialize();
    }

    /** Vista donde se muestra el listado de roles */
    public function indexAction(){
        $this->view->pick('administracion/permisos/roles/index');
    }

    /**
     *  Muestra el modal para agregar y modificar roles
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/permisos/roles/modal');
        $this->view->id = $this->request->get('ID', null, '');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
    }

    /**
     *  Guarda / Modifica el rol de permios del sistema
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();
        $flag = true; //bandera para verificar el eliminado de registro SdRecursoRol

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    $jsonData = $this->request->getJsonRawBody('roles');

                    if(!empty($jsonData['rol']) & !empty($jsonData['descripcion'])) {
                        if (empty(($jsonData['id']))) {
                            $secuencia = $this->db->query('SELECT SD_ROL_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $SdRol = new SdRol();
                            $SdRol->id =  $secuencia[0]['NEXTVAL'];
                            $SdRol->nombre = strtoupper($jsonData['rol']);
                            $SdRol->descripcion = $jsonData['descripcion'];
                            $SdRol->usuario_i = $this->session->usuario['usuario'];
                            $SdRol->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $SdRol->estatus = 'AC';
                        } else {
                            // Seleccionamos el rol a modificar
                            $SdRol = SdRol::findFirst($jsonData['id']);

                            $SdRol->nombre = strtoupper($jsonData['rol']);
                            $SdRol->descripcion = $jsonData['descripcion'];
                            $SdRol->usuario_u = $this->session->usuario['usuario'];
                            $SdRol->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($SdRol) {
                            if ($SdRol->save()) {
                                if(!empty($jsonData['id'])) {
                                    //Elimina el registro SdRecursoRol cuando se hace la edición
                                    $query = " DELETE FROM SdRecursoRol WHERE id_rol = :id_rol:";
                                    $result = $this->modelsManager->executeQuery($query, array('id_rol' => $jsonData['id']));

                                    if ($result->success() === false) {
                                        $flag =  false;
                                    }
                                    //Elimina el registro SdRecursoRol cuando se hace la edición
                                    $query = " DELETE FROM SdMenuRol WHERE id_rol = :id_rol:";
                                    $result = $this->modelsManager->executeQuery($query, array('id_rol' => $jsonData['id']));

                                    if ($result->success() === false) {
                                        $flag =  false;
                                    }
                                }
                                if($flag) {
                                    foreach ($jsonData['recursos'] as $recurso) {
                                        $sdRecursoRol = new SdRecursoRol();
                                        $sdRecursoRol->id_recurso = $recurso['ID'];
                                        $sdRecursoRol->id_rol = $SdRol->id;
                                        $sdRecursoRol->descripcion = $SdRol->nombre. ' + ' . $recurso['NOMBRE'];
                                        $sdRecursoRol->usuario_i = $this->session->usuario['usuario'];
                                        $sdRecursoRol->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $sdRecursoRol->estatus = 'AC';
                                        if ($sdRecursoRol) {
                                            if ($sdRecursoRol->save() === false) {
                                                $flag =  false;
                                            }
                                        }else {
                                            $this->mensaje = ['warning', 'Los recursos no pueden ser relacionados con el rol.', null];
                                        }

                                        foreach ($jsonData['menu'] as $menu) {
                                            $sdMenuRol = new SdMenuRol();
                                            $sdMenuRol->id_menu = $menu['ID_MENU'];
                                            $sdMenuRol->id_rol = $SdRol->id;
                                            $sdMenuRol->descripcion = $SdRol->nombre . ' + ' . $menu['NOMBRE'];
                                            $sdMenuRol->usuario_i = $this->session->usuario['usuario'];
                                            $sdMenuRol->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                            $sdMenuRol->estatus = 'AC';
                                            if ($sdMenuRol) {
                                                if ($sdMenuRol->save() === false) {
                                                    $flag = false;
                                                }
                                            } else {
                                                $this->mensaje = ['warning', 'El menu no pueden ser relacionados con el rol.', null];
                                            }
                                        }
                                    }
                                    if($flag){
                                        $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                    }
                                }else{
                                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los roles.', null];
                                }
                            } else {
                                foreach ($SdRol->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El rol seleccionado no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los roles.', null];
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
     *  Borra el rol seleccionado en base a id_rol
     *  @param int $id del rol
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del rol
                    $idRol = $this->request->get('txtIdRol', null, 0);

                    //Se realiza la búsqueda del rol
                    $sdRol = SdRol::findFirst($idRol);

                    if ($sdRol) {
                        $sdRol->estatus = 'IN'; //cambiamos el estatus a INACTIVO
                        $sdRol->usuario_u = $this->session->usuario['usuario'];
                        $sdRol->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdRol->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el rol seleccionado.', null];
                        } else {
                            foreach ($sdRol->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el rol seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El rol no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los roles.', null];
                }
                //obtenemos el mensaje de respuesta
                $this->resultado = $funcion->getMensaje($this->mensaje);
                $this->response->setContentType('application/json', 'UTF-8');
                $this->response->setJsonContent($this->resultado);
                $this->response->setStatusCode(200, "OK");
                $this->response->send();
            }
        } else {
            $this->response->setStatusCode(404, "No se encuentra la página de roles, por favor intentalo de nuevo");
        }
    }

    /**
     *  Hace un listado con los roles activos
     *  Retorna un json con todos los roles
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

                    $roles = SdRol::query()
                    ->columns(array('ID' => "SdRol.id",'NOMBRE'=> 'SdRol.nombre','DESCRIPCION' => 'SdRol.descripcion'))
                    ->innerJoin('SdRecursoRol', "SdRecursoRol.id_rol = SdRol.id", 'SdRecursoRol')
                    ->innerJoin('SdRecurso', "SdRecurso.id = SdRecursoRol.id_recurso", 'SdRecurso')
                    ->conditions("UPPER(translate(SdRol.nombre , 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:) AND SdRol.estatus=:estatus: AND SdRecursoRol.estatus=:estatus: AND SdRecurso.estatus=:estatus:")
                    ->bind(['nombre' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'])
                    ->groupBy('SdRol.id, SdRol.nombre, SdRol.descripcion, SdRol.estatus')
                    ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                    ->execute();

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $roles,
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
                $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los registros.', null];
            }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }

    /**
     *  Obtiene los registros
     *  retorna array en formato json con todos los registros
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //definición de variables
                    $nombre = $this->request->get('txtNombre', null, '');
                    $opt = $this->request->get('opt', null, 0);
                    $id = $this->request->get('idRol', null, 0);
                    $registros = array();

                    switch ($opt) {
                        case 0:
                            //obtiene los registros del modelo recursos
                            $registros = SdRecurso::find([
                                'columns' => array('ID' => "id", 'NOMBRE'=> 'nombre', 'DESCRIPCION' => 'descripcion'),
                                'conditions' => "UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:) AND estatus=:estatus:",
                                'bind' => ['nombre' => '%' . strtr(strtoupper(trim($nombre)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'],
                            ]);
                            break;

                        case 1:
                            //obtiene los recursos por rol seleccionado
                            $registros = SdRecurso::query()
                                ->columns(array('ID' => "SdRecurso.id",'NOMBRE'=> 'SdRecurso.nombre', 'DESCRIPCION' => 'SdRecurso.descripcion'))
                                ->join('SdRecursoRol', "SdRecursoRol.id_recurso = SdRecurso.id", 'SdRecursoRol', 'INNER')
                                ->join('SdRol', "SdRol.id = SdRecursoRol.id_rol", 'SdRol', 'INNER')
                                ->conditions('SdRol.id=:id: AND SdRecurso.estatus=:estatus: AND SdRecursoRol.estatus=:estatus: AND SdRol.estatus=:estatus:')
                                ->bind(['id'=>$id,'estatus'=>'AC'])
                                ->execute();
                            break;

                        case 3:
                            //obtiene los registros del modelo menu
                            $registros = SdMenu::find([
                                'columns' => array('ID_MENU' => "id_menu", 'NOMBRE'=> 'nombre', 'DESCRIPCION' => 'descripcion'),
                                'conditions' => "UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:) AND estatus=:estatus:",
                                'bind' => ['nombre' => '%' . strtr(strtoupper(trim($nombre)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'],
                            ]);
                            break;

                        case 4:
                            //obtiene los menus por rol seleccionado
                            $registros = SdMenu::query()
                                ->columns(array('ID_MENU' => "SdMenu.id_menu",'NOMBRE'=> 'SdMenu.nombre', 'DESCRIPCION' => 'SdMenu.descripcion'))
                                ->innerJoin('SdMenuRol', "SdMenuRol.id_menu = SdMenu.id_menu", 'SdMenuRol')
                                ->innerJoin('SdRol', "SdRol.id = SdMenuRol.id_rol", 'SdRol')
                                ->conditions('SdRol.id=:id: AND SdMenu.estatus=:estatus: AND SdMenuRol.estatus=:estatus: AND SdRol.estatus=:estatus:')
                                ->bind(['id'=>$id,'estatus'=>'AC'])
                                ->execute();
                            break;
                    }
                    if($registros){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $registros]; //se debe enviar los recursos
                    }else{
                        $this->mensaje = ['danger', 'No hay registros disponibles.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los registros.', null];
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
}
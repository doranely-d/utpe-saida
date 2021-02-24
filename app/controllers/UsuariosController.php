<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class UsuariosController extends  ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Usuarios');
        parent::initialize();
    }

    /**   Vista donde se muestra el listado de usuarios */
    public function indexAction(){
        $this->view->pick('administracion/permisos/usuarios/index');
    }

    /**
     *  Muestra el modal para agregar y  modificar usuario
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/permisos/usuarios/modal');
        $this->view->id = $this->request->get('ID', null, '');
        $this->view->usuario = $this->request->get('USUARIO', null, '');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->password = $this->request->get('PASSWORD', null, '');
        $this->view->correo = $this->request->get('CORREO', null, '');
    }

    /**
     *  Guarda / Modifica el usuario seleccionada en base a su id_usuario
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPost()) {
            $flag = true; //bandera para verificar el eliminado de registro SdUsuarioRol

            if ($this->request->isAjax() == true) {
                try {
                    //Obtenemos los valores del formulario
                    $jsonData =   $this->request->getJsonRawBody('usuarios');

                    if(!empty($jsonData['roles']) & !empty($jsonData['dependencias']) & !empty($jsonData['nombre'])
                         & !empty($jsonData['correo'])  & !empty($jsonData['usuario'])) {

                        if (empty(($jsonData['id']))) {
                            $secuencia = $this->db->query('SELECT SD_USUARIO_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $sdUsuario = new SdUsuario();
                            $sdUsuario->id =  $secuencia[0]['NEXTVAL'];
                            $sdUsuario->usuario = $jsonData['usuario'];
                            $sdUsuario->password = $this->security->hash($jsonData['password']);
                            $sdUsuario->nombre = $jsonData['nombre'];
                            $sdUsuario->correo = strtolower($jsonData['correo']);
                            $sdUsuario->usuario_i = $this->session->usuario['usuario'];
                            $sdUsuario->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdUsuario->estatus = 'AC';
                        } else {
                            // Seleccionamos el rol a modificar
                            $sdUsuario = SdUsuario::findFirst($jsonData['id']);
                            $sdUsuario->usuario =  $jsonData['usuario'];
                            $sdUsuario->nombre = $jsonData['nombre'];
                            $sdUsuario->correo =  strtolower($jsonData['correo']);
                            $sdUsuario->usuario_u = $this->session->usuario['usuario'];
                            $sdUsuario->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($sdUsuario) {
                            if ($sdUsuario->save()) {
                                if(!empty($jsonData['id'])) {
                                    //Elimina el registro SdUsuarioRol cuando se hace la edición
                                    $query = " DELETE FROM SdUsuarioRol WHERE id_usuario = :id_usuario:";
                                    $result = $this->modelsManager->executeQuery($query, array('id_usuario' => $jsonData['id']));

                                    if ($result->success() === false) {
                                        $flag =  false;
                                    }
                                    //Elimina el registro SdUsuarioDependencia cuando se hace la edición
                                    $query = " DELETE FROM SdUsuarioDependencia WHERE id_usuario = :id_usuario:";
                                    $result = $this->modelsManager->executeQuery($query, array('id_usuario' => $jsonData['id']));

                                    if ($result->success() === false) {
                                        $flag =  false;
                                    }
                                }
                                if($flag) {
                                    foreach ($jsonData['roles'] as $rol) {
                                        $sdUsuarioRol = new SdUsuarioRol();
                                        $sdUsuarioRol->id_usuario = $sdUsuario->id;
                                        $sdUsuarioRol->id_rol = $rol['ID'];
                                        $sdUsuarioRol->usuario_i = $this->session->usuario['usuario'];
                                        $sdUsuarioRol->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $sdUsuarioRol->estatus = 'AC';
                                        if ($sdUsuarioRol) {
                                            if ($sdUsuarioRol->save() === false) {
                                                $flag =  false;
                                            }
                                        }else {
                                            $this->mensaje = ['warning', 'Los roles no pueden ser relacionados con el usuario.', null];
                                        }
                                    }
                                    foreach ($jsonData['dependencias'] as $dependencia) {
                                        $sdUsuarioDependencia = new SdUsuarioDependencia();
                                        $sdUsuarioDependencia->id_usuario = $sdUsuario->id;
                                        $sdUsuarioDependencia->id_dependencia = $dependencia['FLEX_VALUE_ID'];
                                        $sdUsuarioDependencia->clave = $dependencia['FLEX_VALUE'];
                                        $sdUsuarioDependencia->descripcion = $dependencia['DESCRIPTION'];
                                        $sdUsuarioDependencia->usuario_i = $this->session->usuario['usuario'];
                                        $sdUsuarioDependencia->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $sdUsuarioDependencia->estatus = 'AC';

                                        if ($sdUsuarioDependencia) {
                                            if ($sdUsuarioDependencia->save() === false) {
                                                    $flag =  false;
                                            }
                                        }else {
                                            $this->mensaje = ['warning', 'Los roles no pueden ser relacionados con el usuario.', null];
                                        }
                                    }
                                    if($flag){
                                        $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                    }
                                }else{
                                    $this->mensaje = ['danger', 'Ocurrio un error al editar el rol.', null];
                                }
                            } else {
                                foreach ($sdUsuario->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El Rol no puede ser accesado.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los usuarios.', null];
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
     *  Borra el usuario seleccionado en base a id_usuario
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
                    //obtenemos el id del usuario
                    $idUsuario = $this->request->get('txtIdUsuario', null, 0);

                    //Se realiza la búsqueda del usuario seleccionado
                    $sdUsuario = SdUsuario::findFirst($idUsuario);

                    if ($sdUsuario) {
                        $sdUsuario->estatus = 'IN'; //cambiamos el estatus a INACTIVO
                        $sdUsuario->usuario_u = $this->session->usuario['usuario'];
                        $sdUsuario->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdUsuario->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el usuario seleccionado.', null];
                        } else {
                            foreach ($sdUsuario->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el usuario seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El usuario no se encuentra en base de datos.', null];
                    }

                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los usuarios.', null];
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
     *  Hace un listado con los usuarios activos
     *  Retorna array en formato json con todos los usuarios
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        //Defición de Variables
        $limit = ($this->request->get('limit') != null) ? $this->request->get('limit') : 0;
        $offset = ($this->request->get('offset') != null) ? $this->request->get('offset') : 0;
        $order = ($this->request->get('order') != null) ? $this->request->get('order') : '';
        $sort = ($this->request->get('sort') != null) ? $this->request->get('sort') : '';
        $search = ($this->request->get('search') != null) ? $this->request->get('search') : '';
        $currentPage =  (($offset/$limit) + 1);
        $total = 0;
        $rows = array();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{

                    $sdUsuarios = SdUsuario::query()
                        ->columns(array('ID' => "SdUsuario.id",'USUARIO'=> 'SdUsuario.usuario','NOMBRE'=> 'SdUsuario.nombre',
                            'CORREO'=> 'SdUsuario.correo', 'PASSWORD'=>'SdUsuario.password'))
                        ->innerJoin('SdUsuarioRol', "SdUsuarioRol.id_usuario = SdUsuario.id", 'SdUsuarioRol')
                        ->innerJoin('SdRol', "SdRol.id = SdUsuarioRol.id_rol", 'SdRol')
                        ->innerJoin('SdUsuarioDependencia', "SdUsuarioDependencia.id_usuario = SdUsuario.id", 'SdUsuarioDependencia')
                        ->conditions("UPPER(translate(SdUsuario.usuario, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:usuario:) AND SdUsuario.estatus=:estatus: AND SdRol.estatus=:estatus: 
                                    AND SdUsuarioRol.estatus=:estatus: AND SdUsuarioDependencia.estatus=:estatus:")
                        ->bind(['usuario' => '%' .  strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU"). '%', 'estatus'=>'AC'])
                        ->groupBy('SdUsuario.id, SdUsuario.usuario, SdUsuario.nombre, SdUsuario.correo, SdUsuario.password, SdUsuario.estatus')
                        ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                        ->execute();

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $sdUsuarios,
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
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los usuarios.', null];
                }
          }
        } else {
            $this->response->setStatusCode(404, "Not Found");
        }
    }

    /**
     *  Obtiene los roles o las dependencias activas
     *  Retorna array en formato json con los roles o las dependencias activas
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    $nombre = $this->request->get('txtNombre', null, '');
                    $opt = $this->request->get('opt', null, 0);
                    $idUsuario = $this->request->get('idUsuario', null, '');
                    $registros = array();

                    switch ($opt) {
                        case 0:
                            //obtiene los registros del modelo SdRol
                            $registros =  SdRol::find([
                                    'columns' => array('ID' => "id", 'NOMBRE'=> 'nombre','DESCRIPCION'=> 'descripcion'),
                                    'conditions' => "UPPER(nombre) LIKE :nombre: and estatus=:estatus:",
                                    'bind' => ['nombre' => '%' . strtoupper(trim($nombre)) . '%', 'estatus'=>'AC'],
                                ]);

                            break;
                        case 1:
                            //obtiene los registros de todas las dependencias
                            $phql = "SELECT DISTINCT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION, hierarchy AS HIERARCHY, agrupador AS AGRUPADOR  
                              FROM XxhrPqHierarchyV 
                              WHERE HIERARCHY = :hierarchy: AND UPPER(translate(description, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(translate(:description:, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU'))";

                                //validamos que sea la solicitud seleccionada
                                $registros  = $query = $this->modelsManager->executeQuery($phql,
                                    [
                                        "hierarchy" => 17,
                                        "description" =>'%'.$nombre.'%',
                                    ]
                                );

                            break;
                        case 2:
                            //obtiene los registros de todos los roles del usuario
                            $registros = SdRol::query()
                                ->columns(array('ID' => "SdRol.id",'NOMBRE'=> 'SdRol.nombre', 'DESCRIPCION' => 'SdRol.descripcion'))
                                ->join('SdUsuarioRol', "SdUsuarioRol.id_rol = SdRol.id", 'SdUsuarioRol', 'INNER')
                                ->join('SdUsuario', "SdUsuario.id = SdUsuarioRol.id_usuario", 'SdUsuario', 'INNER')
                                ->conditions('SdUsuario.id=:id: AND SdRol.estatus=:estatus:')
                                ->bind(['id'=>$idUsuario,'estatus'=>'AC'])
                                ->execute();

                            break;
                        case 3:

                            //obtiene los registros de las dependencias por usuario
                            $sdUsuarioDependencia = SdUsuarioDependencia::query()
                                ->columns(array('CLAVE' => "SdUsuarioDependencia.clave",))
                                ->innerJoin('SdUsuario', "SdUsuario.id = SdUsuarioDependencia.id_usuario", 'SdUsuario')
                                ->conditions('SdUsuario.id=:id: AND SdUsuarioDependencia.estatus=:estatus:  AND SdUsuario.estatus=:estatus:')
                                ->bind(['id'=>$idUsuario,'estatus'=>'AC'])
                                ->execute();

                            //llenamos el arreglo con el id de las dependencias
                            foreach ($sdUsuarioDependencia AS $dependencia){
                                $dependencias[] = $dependencia->CLAVE;
                            }
                            //separamos las dependencias dandole formato
                            $dependencias = "'" . implode("', '", $dependencias) ."'";
                            //hacemos la consulta sql
                            $phql = "SELECT DISTINCT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION, hierarchy AS HIERARCHY, agrupador AS AGRUPADOR  
                              FROM XxhrPqHierarchyV 
                              WHERE flex_value IN (" .$dependencias .")";

                            //ejecutamos la consulta
                            $registros  = $query = $this->modelsManager->executeQuery($phql);

                            break;
                    }
                    if($registros){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $registros];
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
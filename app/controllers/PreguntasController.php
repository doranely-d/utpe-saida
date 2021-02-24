<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class PreguntasController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Preguntas');
        parent::initialize();
    }

    /** Muestra la vista de todas las preguntas activas por tippreguntasjsono de solicitud */
    public function indexAction(){
        $tipo = $this->request->get('tipo', null, '');
        $this->view->tipo = strtoupper($tipo);
    }

    /** Muestra el modal dependiendo la opción seleccionada*/
    public function modalAction(){
        //obtenemos la opción del modal a mostrar
        $opt = $this->request->get('opt', null, 0);

        //variables necesarias para el formulario
        $tipo = $this->request->get('tipo', null, '');
        $this->view->tipo = strtoupper($tipo);
        $this->view->folio = $this->request->get('FOLIO', null, '');
        $this->view->id_pregunta = $this->request->get('ID_PREGUNTA', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
        $this->view->observaciones = $this->request->get('OBSERVACIONES', null, '');

        switch ($opt) {
            case 0:
                //Muestra la vista del modal para agregar preguntas
                $this->view->pick('preguntas/peticiones');
                break;
            case 1:
                //muestra la vista del modal para el turnado
                $this->view->pick('preguntas/turnado');
                break;
            case 2:
                //Muestra el modal para mostrar la pregunta y sus dependencias
                $this->view->pick('preguntas/preguntas');
                break;
            case 3:
                //Muestra el modal para mostrar la pregunta y sus dependencias
                $this->view->pick('preguntas/comentarios');
                break;
        }
    }

    /** Obtiene la vista para el perfil de la pregunta */
    public function perfilAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);

        $idPregunta = $this->request->get('idPregunta', null, 0); //obtenemos el id_pregunta
        //Hacemos la búsqueda de lapregunta en base a su id_pregunta
        $pregunta = SdPregunta::query()
            ->columns(array('ID_SOLICITUD' => "SdSolicitud.id_solicitud",'FOLIO'=> 'SdSolicitud.folio','ID_PREGUNTA' => "SdPregunta.id_pregunta",
                'FECHA_I'=> "to_char(SdPregunta.fecha_i,'DD/MM/YYYY')",
                'DESCRIPCION'=> 'SdPregunta.descripcion', 'OBSERVACIONES'=> 'SdPregunta.observaciones', 'ESTATUS'=>'SdPregunta.estatus'))
            ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
            ->execute()
            ->getFirst();
        $this->view->pregunta = $pregunta;
        $this->view->idPregunta = $idPregunta;
    }

    /**
     *  Guarda las preguntas relacionadas a una solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();
        $flag = true;

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    $id = $this->request->getPost('txtIdPregunta', null, 0);
                    $descripcion = $this->request->getPost('txtDescripcion', null, '');
                    $observaciones = $this->request->getPost('txtObservacion', null, '');
                    $idSolicitud = $this->request->getPost('txtIdSolicitud', null, '');
                    $idDependencia = $this->request->getPost('idDependencia', null, '');
                    $idEstatus = $funcion->getEstatusPregunta('RECIBIDA'); //obtiene el estatus en proceso de RECIBIDA

                    //obtenemos la solicitud en base al id_solicitud
                    $solicitud = SdSolicitud::findFirst((int)$idSolicitud);

                    if($solicitud){
                        if(!empty($descripcion)) {
                            if (empty(($id))) {
                                $secuencia = $this->db->query('SELECT SD_PREGUNTA_SEQ.nextval FROM dual');
                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                $secuencia = $secuencia->fetchAll($secuencia);

                                $sdPregunta = new SdPregunta();
                                $sdPregunta->id_pregunta =  $secuencia[0]['NEXTVAL'];
                                $sdPregunta->id_solicitud = $solicitud->id_solicitud;
                                $sdPregunta->descripcion = $descripcion;
                                if($observaciones){
                                    $sdPregunta->observaciones = $observaciones;
                                }
                                $sdPregunta->id_estatus = $idEstatus;
                                $sdPregunta->usuario_i = $this->session->usuario['usuario'];
                                $sdPregunta->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                $sdPregunta->estatus = 'AC';

                            } else {
                                $sdPregunta = SdPregunta::findFirst($id);
                                $sdPregunta->descripcion = $descripcion;
                                if($observaciones){
                                    $sdPregunta->observaciones = $observaciones;
                                }
                                $sdPregunta->usuario_u = $this->session->usuario['usuario'];
                                $sdPregunta->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                            }

                            if ($sdPregunta) {
                                if ($sdPregunta->save()) {
                                    if(!empty($idDependencia)) {
                                        //llenado de la relacion sd_tema_subtema
                                        $dPreguntaDependencia = new SdPreguntaDependencia();
                                        $dPreguntaDependencia->id_dependencia = $idDependencia;
                                        $dPreguntaDependencia->id_pregunta = $sdPregunta->id_pregunta;
                                        $dPreguntaDependencia->usuario_i = $this->session->usuario['usuario'];
                                        $dPreguntaDependencia->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $dPreguntaDependencia->estatus = 'AC';

                                        if ($dPreguntaDependencia) {
                                            if (!$dPreguntaDependencia->save()) {
                                                foreach ($dPreguntaDependencia->getMessages() as $message) {
                                                    $this->msnError .= $message->getMessage() . "<br/>";
                                                }
                                                $flag = false;
                                            }
                                        }
                                    }
                                    if($flag){
                                        $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                    }else{
                                        $this->mensaje = ['danger', 'Ocurrio un error al editar los registos.', null];
                                    }
                                } else {
                                    foreach ($sdPregunta->getMessages() as $message) {
                                        $this->msnError .= $message->getMessage() . "<br/>";
                                    }
                                    $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                                }
                            } else {
                                $this->mensaje = ['warning', 'La pregunta seleccionada no se encuentra en el sistema.', null];
                            }
                        }else {
                            $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                        }
                    }else{
                        $this->mensaje = ['danger', 'Ocurrio un error al seleccionar la solicitud.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las acciones.', null];
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
     *  Borra la pregunta por solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id de la pregunta
                    $idPregunta = $this->request->get('txtIdPregunta', null, 0);

                    //Se realiza la búsqueda de la pregunta a borrar
                    $SdPregunta = SdPregunta::findFirst($idPregunta);

                    if ($SdPregunta) {
                        $SdPregunta->estatus = 'IN';
                        $SdPregunta->usuario_u = $this->session->usuario['usuario'];
                        $SdPregunta->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($SdPregunta->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el documento seleccionado.', null];
                        } else {
                            foreach ($SdPregunta->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar la pregunta seleccionada.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'La pregunta no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las preguntas.', null];
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
     *   Hace un listado con las peticiones de los solicitantes
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        //Defición de Variables al realizar el filtro
        $tipo = $this->request->get('tipo', null, '');
        $id = $this->request->get('id', null, '');
        $opt = $this->request->get('opt', null, '');
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

                $id_tipo = $funcion->getTipo($tipo); //Obtenemos el id_tipo en base al nombre del tipo
                $usuario =  $this->session->usuario['usuario'];

                switch ($opt) {
                    case 0:
                        //Se realiza la búsqueda de las preguntas activas en base al tipo de solicitud
                        $registros = SdPregunta::query()
                            ->columns(array('ID_SOLICITUD' => "SdSolicitud.id_solicitud",'FOLIO'=> 'SdSolicitud.folio','ID_PREGUNTA' => "SdPregunta.id_pregunta",
                                'FECHA_I'=> "to_char(SdPregunta.fecha_i,'DD/MM/YYYY')",
                                'DESCRIPCION'=> 'SdPregunta.descripcion', 'OBSERVACIONES'=> 'SdPregunta.observaciones', 'ESTATUS'=>'SdPregunta.estatus'))
                            ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
                            ->innerJoin('SdSolicitudTipo', "SdSolicitudTipo.id_tipo = SdSolicitud.id_tipo", 'SdSolicitudTipo')
                            ->conditions('SdSolicitud.id_tipo=:id_tipo: AND SdSolicitud.folio LIKE :folio: AND SdPregunta.estatus=:estatus: AND SdSolicitud.estatus=:estatus:')
                            ->bind(['folio' => '%' .  strtoupper(trim($search)). '%', 'id_tipo'=>$id_tipo, 'estatus'=>'AC'])
                            ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                            ->execute();
                        break;

                    case 1:
                        //obtenemos las peticiones que han sido turnadas a la dependencia
                        $registros = SdPregunta::query()
                            ->columns(array('ID_SOLICITUD' => "SdSolicitud.id_solicitud",'FOLIO'=> 'SdSolicitud.folio','ID_PREGUNTA' => "SdPregunta.id_pregunta",
                                'FECHA_I'=> "to_char(SdPregunta.fecha_i,'DD/MM/YYYY')",
                                'DESCRIPCION'=> 'SdPregunta.descripcion', 'OBSERVACIONES'=> 'SdPregunta.observaciones', 'ESTATUS'=>'SdPregunta.estatus'))
                            ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
                            ->innerJoin('SdSolicitudTipo', "SdSolicitudTipo.id_tipo = SdSolicitud.id_tipo", 'SdSolicitudTipo')
                            ->innerJoin('SdPreguntaDependencia', "SdPreguntaDependencia.id_pregunta = SdPregunta.id_pregunta", 'SdPreguntaDependencia')
                            ->innerJoin('SdUsuarioDependencia', "SdUsuarioDependencia.id_dependencia = SdPreguntaDependencia.id_dependencia", 'SdUsuarioDependencia')
                            ->innerJoin('SdUsuario', "SdUsuario.id = SdUsuarioDependencia.id_usuario", 'SdUsuario')
                            ->conditions('SdSolicitudTipo.tipo LIKE :tipo: AND SdUsuario.usuario LIKE :usuario: AND SdSolicitud.folio LIKE :folio: AND SdPregunta.estatus=:estatus: AND SdSolicitud.estatus=:estatus:')
                            ->bind( ['folio' => '%' .  strtoupper(trim($search)). '%', 'tipo'=>'%' .  strtoupper(trim($tipo)). '%', 'usuario'=>'%' .  $usuario. '%','estatus'=>'AC'])
                            ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                            ->execute();
                        break;

                    case 2:
                        //obtiene los registros del historial de comentarios
                        $registros = SdPreguntaComentario::query()
                            ->columns(array('ID' => "SdPreguntaComentario.id", 'ID_DEPENDENCIA'=> 'SdPreguntaComentario.id_dependencia',
                                'FLEX_VALUE'=> 'SdPreguntaComentario.flex_value','USUARIO'=> 'SdUsuario.nombre','COMENTARIO'=> 'SdPreguntaComentario.comentario',
                                'DEPENDENCIA'=> 'SdPreguntaComentario.dependencia', 'FECHA_I'=> "to_char(SdPreguntaComentario.fecha_i,'DD/MM/YYYY')"))
                            ->leftJoin('SdUsuario', "SdUsuario.usuario = SdPreguntaComentario.usuario_i", 'SdUsuario')
                            ->conditions('SdPreguntaComentario.comentario LIKE :comentario: AND 
                                                    SdPreguntaComentario.id_pregunta=:id_pregunta: AND SdPreguntaComentario.estatus=:estatus:')
                            ->bind( ['comentario' => '%' . strtolower(trim($search)) . '%', 'id_pregunta' => $id, 'estatus'=>'AC'])
                            ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                            ->execute();
                        break;

                    case 3:
                        //obtiene los registros del historial de la pregunta
                        $registros = SdPreguntaHistorial::query()
                            ->columns(array('ID' => "id",'ID_PREGUNTA' => "id_pregunta", 'FECHA_I' => "fecha_i",
                                'USUARIO' => "usuario_i", 'MENSAJE'=> 'mensaje'))
                            ->conditions('mensaje LIKE :mensaje: AND id_pregunta=:id_pregunta: AND estatus=:estatus:')
                            ->bind(['mensaje' => '%' . strtolower(trim($search)) . '%', 'id_pregunta' => $id, 'estatus'=>'AC'])
                            ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                            ->execute();
                        break;

                    case 4:
                        //obtiene los registros del historial de la pregunta
                        $registros = SdPreguntaDependencia::query()
                            ->columns(array('ID_PREGUNTA'=>"SdPreguntaDependencia.id_pregunta", 'ID_DEPENDENCIA'=>"SdPreguntaDependencia.id_dependencia",
                                'FLEX_VALUE'=>"SdPreguntaDependencia.flex_value", 'FECHA_I'=>"SdPreguntaDependencia.fecha_i",
                                'DEPENDENCIA'=>"SdPreguntaDependencia.dependencia",'USUARIO'=> 'SdUsuario.nombre'))
                            ->innerJoin('SdUsuario', "SdUsuario.usuario = SdPreguntaDependencia.usuario_i", 'SdUsuario')
                            ->conditions('SdPreguntaDependencia.dependencia LIKE :dependencia:
                                                    AND SdPreguntaDependencia.id_pregunta=:id_pregunta: AND SdPreguntaDependencia.estatus=:estatus:')
                            ->bind(['dependencia' => '%' . strtolower(trim($search)) . '%', 'id_pregunta' => $id, 'estatus'=>'AC'])
                            ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                            ->execute();
                        break;
                }

                // Crear un paginador del modelo
                $paginacion = new PaginatorModel(
                    [
                        'data'  => $registros,
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
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }

    /**
     *  Hace la búsqueda de los registros
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try {
                    $id = $this->request->get('id', null, 0);
                    $nombre = $this->request->get('txtNombre', null, '');
                    $opt = $this->request->get('opt', null, 0);

                    switch ($opt) {
                        case 0:
                            //Obtiene las dependendecias activas por usuario
                            $sdPreguntaDependencia = SdPreguntaDependencia::query()
                                ->columns(array('CLAVE' => "SdPreguntaDependencia.clave", 'ID_DEPENDENCIA' => "SdPreguntaDependencia.clave",
                                    'FECHA_I' => "to_char(SdPreguntaDependencia.fecha_i,'DD/MM/YYYY')"))
                                ->innerJoin('SdPregunta', "SdPregunta.id_pregunta = SdPreguntaDependencia.id_pregunta", 'SdPregunta')
                                ->conditions('SdPregunta.id_pregunta=:id_pregunta: AND SdPreguntaDependencia.estatus=:estatus:  AND SdPregunta.estatus=:estatus:')
                                ->bind(['id_pregunta'=>$id,'estatus'=>'AC'])
                                ->execute();

                            //llenamos el arreglo con el id de las dependencias
                            foreach ($sdPreguntaDependencia AS $dependencia){
                                $dependencias[] = $dependencia->CLAVE;
                            }

                            //separamos las dependencias dandole formato
                            $dependencias = "'" . implode("', '", $dependencias) ."'";

                            //hacemos la consulta sql
                            $phql = "SELECT DISTINCT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION
                                  FROM XxhrPqHierarchyV 
                                  WHERE flex_value IN (" .$dependencias .")";

                            //ejecutamos la consulta
                            $registros  = $query = $this->modelsManager->executeQuery($phql);

                            break;
                        case 1:
                            //Obtiene las dependencias activas
                            $phql = "SELECT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION, hierarchy AS HIERARCHY, agrupador AS AGRUPADOR  
                              FROM XxhrPqHierarchyV 
                              WHERE HIERARCHY = :hierarchy: AND UPPER(translate(description, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(translate(:description:, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU'))
                              AND flex_value LIKE :flex_value:
                              GROUP BY flex_value, flex_value_id, description, hierarchy, agrupador
                              ORDER BY flex_value";

                            //validamos que sea la solicitud seleccionada
                            $registros  = $query = $this->modelsManager->executeQuery($phql, ["hierarchy" => 17, "description" =>'%'.$nombre.'%', "flex_value" =>'1%']);
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
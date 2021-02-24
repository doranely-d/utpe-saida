<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class SolicitantesController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Solicitantes');
        parent::initialize();
    }

    /** Vista donde se muestra el listado de solicitantes */
    public function indexAction(){}

    /** Obtiene la vista para el perfil de la solicitud */
    public function perfilAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);

        //Declaración de variables
        $idSolicitante = $this->request->get('idSolicitante', null, 0);

        $sdSolicitante = SdSolicitante::query()
            ->columns(array('ID_SOLICITANTE' => "SdSolicitante.id_solicitante", 'NOMBRE' => 'SdSolicitante.nombre',
                'APELLIDO_PATERNO' => 'SdSolicitante.apellido_paterno', 'CORREO' => 'SdSolicitante.correo', 'FECHA_I' => "to_char(SdSolicitante.fecha_i,'DD/MM/YYYY')",
                'APELLIDO_MATERNO' => 'SdSolicitante.apellido_materno', 'TELEFONO_FIJO' => 'SdSolicitante.telefono_fijo', 'RAZON_SOCIAL' => 'SdSolicitante.razon_social',
                'NOMBRE_PERSONA_A' => 'SdSolicitante.nombre_persona_a', 'APELLIDO_P_PERSONA_A' => 'SdSolicitante.apellido_p_persona_a',
                'APELLIDO_M_PERSONA_A' => 'SdSolicitante.apellido_m_persona_a', 'ESTADO' => 'SdEstados.estado', 'MUNICIPIO' => 'SdMunicipios.municipio',
                'DOMICILIO' => 'SdSolicitante.domicilio', 'ENTRE_CALLES' => 'SdSolicitante.entre_calles', 'COLONIA' => 'SdSolicitante.colonia',
                'OTRA_REFERENCIA' => 'SdSolicitante.otra_referencia', 'CODIGO_POSTAL' => 'SdSolicitante.codigo_postal',
                'ANONIMO' => 'SdSolicitante.anonimo', 'SEUDONIMO' => 'SdSolicitante.seudonimo', 'TELEFONO_CELULAR' => 'SdSolicitante.telefono_celular', 'ESTATUS' => 'SdSolicitante.estatus'))
            ->leftJoin('SdEstados', "SdEstados.id_estado = SdSolicitante.estado", 'SdEstados')
            ->leftJoin('SdMunicipios', "SdMunicipios.id_municipio = SdSolicitante.municipio", 'SdMunicipios')
            ->conditions('SdSolicitante.id_solicitante=:id_solicitante: AND SdSolicitante.estatus=:estatus:')
            ->bind(['id_solicitante' => $idSolicitante, 'estatus' => 'AC'])
            ->execute();

        $this->view->idSolicitante = $idSolicitante;
        $this->view->solicitante = $sdSolicitante->getFirst();
    }

    /**
     *  Muestra el modal para agregar y modificar
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);

        //obtenemos la opción del modal a mostrar
        $opt = $this->request->get('opt', null, 0);
        //Obtenemos los datos del solicitante
        $this->view->id_solicitante = $this->request->get('ID_SOLICITANTE', null, '');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->apellido_paterno = $this->request->get('APELLIDO_PATERNO', null, '');
        $this->view->apellido_materno = $this->request->get('APELLIDO_MATERNO', null, '');
        $this->view->nombre_persona_a = $this->request->get('NOMBRE_PERSONA_A', null, '');
        $this->view->apellido_p_persona_a = $this->request->get('APELLIDO_P_PERSONA_A', null, '');
        $this->view->apellido_m_persona_a = $this->request->get('APELLIDO_M_PERSONA_A', null, '');
        $this->view->telefono_fijo = $this->request->get('TELEFONO_FIJO', null, '');
        $this->view->telefono_celular = $this->request->get('TELEFONO_CELULAR', null, '');
        $this->view->correo = $this->request->get('CORREO', null, '');
        $this->view->domicilio = $this->request->get('DOMICILIO', null, '');
        $this->view->entre_calles = $this->request->get('ENTRE_CALLES', null, '');
        $this->view->otra_referencia = $this->request->get('OTRA_REFERENCIA', null, '');
        $this->view->colonia = $this->request->get('COLONIA', null, '');
        $this->view->codigo_postal = $this->request->get('CODIGO_POSTAL', null, '');
        $this->view->razon_social = $this->request->get('RAZON_SOCIAL', null, '');
        $this->view->seudonimo = $this->request->get('SEUDONIMO', null, '');
        if($this->request->get('NOMBRE', null, '') == 'ELIMINADO'){
            $this->view->estado = 'ELIMINADO';
            $this->view->municipio = 'ELIMINADO';
        }else{
            $this->view->estado = $this->request->get('ESTADO', null, '');
            $this->view->municipio = $this->request->get('MUNICIPIO', null, '');

        }

        switch ($opt) {
            case 0:
                //Muestra la vista del modal para agregar preguntas
                $this->view->pick('solicitantes/modal/modal');
                break;
            case 1:
                //muestra la vista del modal para borrar los datos personales del solicitante
                $this->view->pick('solicitantes/modal/borrar');
                break;
        }
    }

    /**
     *  Elimina el solicitante y solicitud en base a id_solicitante
     *  @param int $id del solicitante
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del solicitante
                    $idSolicitante = $this->request->get('txtIdSolicitante', null, 0);
                    $comentario =  $this->request->get('txtComentario', null, '');
                    $idSolicitud =  $this->request->get('slSolicitudArco', null, '');

                    //Hacemos la búsqueda de la solicitud ARCO a ejercer
                    $solicitud =  SdSolicitud::findFirst($idSolicitud);

                    if($solicitud){
                        //Se realiza la búsqueda del solicitante
                        $sdSolicitante = SdSolicitante::findFirst($idSolicitante);
                        $sdSolicitante->nombre = 'ELIMINADO';
                        $sdSolicitante->apellido_paterno = 'ELIMINADO';
                        $sdSolicitante->apellido_materno = 'ELIMINADO';
                        $sdSolicitante->telefono_fijo = 'ELIMINADO';
                        $sdSolicitante->telefono_celular = 'ELIMINADO';
                        $sdSolicitante->correo = 'ELIMINADO';
                        $sdSolicitante->domicilio = 'ELIMINADO';
                        $sdSolicitante->entre_calles = 'ELIMINADO';
                        $sdSolicitante->otra_referencia = 'ELIMINADO';
                        $sdSolicitante->colonia = 'ELIMINADO';
                        $sdSolicitante->codigo_postal = 'ELIMINADO';
                        $sdSolicitante->anonimo = 'SI';
                        $sdSolicitante->estado = null;
                        $sdSolicitante->municipio = null;
                        $sdSolicitante->solicitud_arco = $solicitud->folio;

                        if ($sdSolicitante) {
                            if ($sdSolicitante->save()) {
                                //agregamos el comentario a las solicitudes del solicitantes
                                $guardarComentario = $funcion->guardarComentarioSolicitante($idSolicitante, $comentario);

                                if ( $guardarComentario) {
                                    $this->mensaje = ['success', 'Se elimino correctamente los datos del solicitante.', null];
                                }else {
                                    $this->mensaje = ['danger', 'Ocurrio un error al eliminar los datos del solicitante.', null];
                                }
                            } else {
                                foreach ($sdSolicitante->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['danger', 'Ocurrio un problema al intentar eliminar el solicitante seleccionado.' .$this->msnError, null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El solicitante no se encuentra en base de datos.', null];
                        }
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los solicitantes.', null];
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
     *  Hace un listado con los solicitantes
     *  Retorna array en formato json con todos los solicitantes
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        //Defición de Variables al realizar el filtro
        $opt = $this->request->get('opt', null, 0);
        $tipo = $this->request->get('tipo', null, 0);
        $idSolicitante = $this->request->get('id', null, 0);
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

                    switch ($opt) {
                        case 0:
                            //obtiene los registros del modelo solicitantes
                            $registros = SdSolicitante::query()
                                ->columns(array('ID_SOLICITANTE' => "SdSolicitante.id_solicitante", 'NOMBRE' => 'SdSolicitante.nombre',
                                    'APELLIDO_PATERNO' => 'SdSolicitante.apellido_paterno', 'CORREO' => 'SdSolicitante.correo',
                                    'APELLIDO_MATERNO' => 'SdSolicitante.apellido_materno', 'TELEFONO_FIJO' => 'SdSolicitante.telefono_fijo',
                                    'NOMBRE_PERSONA_A' => 'SdSolicitante.nombre_persona_a', 'APELLIDO_P_PERSONA_A' => 'SdSolicitante.apellido_p_persona_a',
                                    'APELLIDO_M_PERSONA_A' => 'SdSolicitante.apellido_m_persona_a', 'ESTADO' => 'SdEstados.estado', 'MUNICIPIO' => 'SdMunicipios.municipio',
                                    'DOMICILIO' => 'SdSolicitante.domicilio', 'ENTRE_CALLES' => 'SdSolicitante.entre_calles', 'COLONIA' => 'SdSolicitante.colonia',
                                    'OTRA_REFERENCIA' => 'SdSolicitante.otra_referencia', 'CODIGO_POSTAL' => 'SdSolicitante.codigo_postal', 'TELEFONO_CELULAR' => 'SdSolicitante.telefono_celular',
                                    'SEUDONIMO' => 'SdSolicitante.seudonimo', 'ANONIMO' => 'SdSolicitante.anonimo', 'ESTATUS' => 'SdSolicitante.estatus'))
                                ->leftJoin('SdEstados', "SdEstados.id_estado = SdSolicitante.estado", 'SdEstados')
                                ->leftJoin('SdMunicipios', "SdMunicipios.id_municipio = SdSolicitante.municipio", 'SdMunicipios')
                                ->conditions('(UPPER(SdSolicitante.nombre) LIKE :nombre: OR UPPER(SdSolicitante.anonimo) LIKE :anonimo: OR UPPER(SdSolicitante.seudonimo) LIKE :nombre:) AND SdSolicitante.estatus=:estatus:')
                                ->bind(['nombre' => '%' . strtoupper(trim($search)) . '%', 'anonimo' => '%SI%', 'estatus' => 'AC'])
                                ->orderBy(' SdSolicitante.correo, '. trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute();
                            break;
                        case 1:
                            //obtener las solicitudes
                            $phql = "SELECT H.id_solicitud AS ID_SOLICITUD, S.folio AS FOLIO, H.id_flujo AS ID_FLUJO, ES.orden AS ORDEN,
                                    id_etapa AS ID_ETAPA, E.nombre AS ETAPA,H.id_estado AS ID_ESTADO, ES.nombre AS ESTADO,
                                    id_transaccion AS ID_TRANSACCION, transaccion AS TRANSACCION,  E.condicion  AS CONDICION,
                                    to_char(S.fecha_i,'DD-MM-YYYY') AS FECHA_I, fecha_prevencion AS FECHA_PREVENCION, antecedente AS ANTECEDENTE, medio AS  MEDIO,
                                    E.color  AS COLOR_ETAPA, ES.color AS COLOR_ESTADO, tipo AS TIPO, dias_utpe AS  DIAS_UTPE
                                    FROM SdSolicitudHistorial H
                                    INNER JOIN SdSolicitud S ON (H.id_solicitud = S.id_solicitud)
                                    INNER JOIN SdMedioRegistro MR ON (MR.id_medio_registro = S.id_medio_registro)
                                    INNER JOIN SdFlujoEtapa E ON (H.id_etapa = E.id)
                                    INNER JOIN SdFlujoEstado ES ON (H.id_estado = ES.id)
                                    INNER JOIN SdSolicitudTipo T ON (S.id_tipo = T.id_tipo)
                                    LEFT JOIN SdFlujoEstadoPlazos P ON (ES.id = P.id_estado)
                                    INNER JOIN SdSolicitudSolicitante SS ON (S.id_solicitud = SS.id_solicitud)
                                    INNER JOIN SdSolicitante ST ON (SS.id_solicitante = ST.id_solicitante)
                                    WHERE H.id IN(SELECT MAX (SdSolicitudHistorial.id) FROM SdSolicitudHistorial   GROUP BY SdSolicitudHistorial.id_solicitud)
                                    AND T.tipo=:tipo: AND S.estatus=:estatus: AND ST.id_solicitante=:id_solicitante:
                                    ORDER BY S.id_solicitud, :filtro:";

                            //obtiene los registros del modelo solicitudes
                            $registros = $this->modelsManager->executeQuery($phql,
                                ['tipo' => $tipo, 'estatus' => 'AC', 'id_solicitante' => $idSolicitante, 'filtro' => trim($sort) . ' ' . strtoupper(trim($order))]);

                            break;
                        case 2:
                            $registros = SdSolicitanteComentario::query()
                                ->columns(array('USUARIO' => 'SdSolicitanteComentario.usuario_i', 'ID_COMENTARIO' => "SdSolicitanteComentario.id",
                                    'FECHA_I' => 'SdSolicitanteComentario.fecha_i', 'COMENTARIO' => 'SdSolicitanteComentario.comentario'))
                                ->innerJoin('SdSolicitante', "SdSolicitante.id_solicitante = SdSolicitanteComentario.id_solicitante", 'SdSolicitante')
                                ->conditions('SdSolicitanteComentario.comentario LIKE :comentario: AND SdSolicitante.id_solicitante=:id_solicitante: AND SdSolicitanteComentario.estatus=:estatus:')
                                ->bind(['comentario' => '%' . strtolower(trim($search)) . '%', 'id_solicitante' => $idSolicitante, 'estatus' => 'AC'])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute();


                            break;
                        case 3:
                            $registros = SdSolicitanteHistorial::query()
                                ->columns(array('ID_HISTORIAL' => "SdSolicitanteHistorial.id", 'FECHA_I' => "SdSolicitanteHistorial.fecha_i",
                                    'USUARIO' => "SdSolicitanteHistorial.usuario_i", 'MENSAJE' => 'SdSolicitanteHistorial.mensaje'))
                                ->innerJoin('SdSolicitante', "SdSolicitante.id_solicitante = SdSolicitanteHistorial.id_solicitante", 'SdSolicitante')
                                ->conditions('SdSolicitanteHistorial.mensaje LIKE :mensaje: AND SdSolicitante.id_solicitante=:id_solicitante: AND SdSolicitanteHistorial.estatus=:estatus:')
                                ->bind(['mensaje' => '%' . strtolower(trim($search)) . '%', 'id_solicitante' => $idSolicitante, 'estatus' => 'AC'])
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
     *  Hace la búsqueda de los registros
     *  Retorna array en formato json con los registros
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try {
                    $opt = $this->request->get('opt', null, 0);

                    switch ($opt) {
                        case 0:
                            $registros = SdSolicitud::find([
                                'columns' => array('ID_SOLICITUD' => "id_solicitud", 'FOLIO' => "folio"),
                                'conditions' => "id_tipo=:id_tipo: AND estatus=:estatus:",
                                'bind' => ['id_tipo' => 2, 'estatus' => 'AC']
                            ]);
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
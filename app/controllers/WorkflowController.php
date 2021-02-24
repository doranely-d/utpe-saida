<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class WorkflowController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Flujo de Trabajo');
        parent::initialize();
    }

    /** Vista donde se muestra el listado de workflow */
    public function indexAction(){}

    /** Vista donde se muestra el workflow */
    public function perfilAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $id = $this->request->get('id', null, 0);
        $flujo = SdFlujo::findFirst($id);
        $this->view->ID = $flujo->id_flujo;
        $this->view->FLUJO = $flujo->nombre;
    }
    /** Vista donde se muestra el workflow */
    public function workflowAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $id = $this->request->get('id', null, 0);
        $flujo = SdFlujo::findFirst($id);
        $this->view->ID = $flujo->id_flujo;
        $this->view->FLUJO = $flujo->nombre;
    }

    /**
     *  Muestra el modal para agregar y  modificar workflow
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction(){
        $opt = $this->request->get('opt', null, 0);
        $this->view->ID = $this->request->get('ID', null,'');
        $this->view->NOMBRE = $this->request->get('NOMBRE', null, '');
        $this->view->COLOR = $this->request->get('COLOR', null, '');
        $this->view->DESCRIPCION = $this->request->get('DESCRIPCION', null, '');
        $this->view->ID_ETAPA = $this->request->get('ID_ETAPA', null,'');
        $this->view->ID_ESTADO = $this->request->get('ID_ESTADO', null,'');
        $this->view->NOMBRE_ESTADO = $this->request->get('NOMBRE_ESTADO', null, '');
        $this->view->COLOR_ESTADO = $this->request->get('COLOR_ESTADO', null, '');
        $this->view->DESCRIPCION_ESTADO = $this->request->get('DESCRIPCION_ESTADO', null, '');
        $this->view->ID_CONDICION = $this->request->get('ID_CONDICION', null, '');
        $this->view->CONDICION = $this->request->get('CONDICION', null, '');
        $this->view->ID_PREVENCION = $this->request->get('ID_PREVENCION', null, '');
        $this->view->PREVENCION = $this->request->get('PREVENCION', null, '');
        $this->view->N_ESTADO_ID = $this->request->get('N_ESTADO_ID', null, '');
        $this->view->N_ESTADO = $this->request->get('N_ESTADO', null, '');
        $this->view->N_ETAPA_ID = $this->request->get('N_ETAPA_ID', null, '');
        $this->view->N_ETAPA = $this->request->get('N_ETAPA', null, '');
        $this->view->PRINCIPAL = $this->request->get('PRINCIPAL', null, 0);
        $this->view->DIAS_LEY = $this->request->get('DIAS_LEY', null, 0);
        $this->view->DIAS_UTPE = $this->request->get('DIAS_UTPE', null, 0);

        switch ($opt) {
            case 0:
                $this->view->pick('workflow/modal');
                break;
            case 1:
                $this->view->pick('workflow/modals/etapa');
                break;
            case 2:
                $this->view->pick('workflow/modals/transacciones');
                break;
            case 3:
                $this->view->pick('workflow/modals/transaccion');
                break;
        }
    }

    /**
     *  Guarda / Modifica la fase seleccionada en base a su id_fase
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
                    $opt = $this->request->get('opt', null, 0);
                    $id =  $this->request->getPost('txtId', null, '');
                    $flujo_id =  $this->request->getPost('txtIdFlujoA', null, '');
                    $nombre =  $this->request->getPost('txtNombre', null, '');
                    $color =  $this->request->getPost('txtColor', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');
                    $idEstado =  $this->request->getPost('txtIdEstado', null, '');
                    $nombreEstado =  $this->request->getPost('txtNombreEstado', null, '');
                    $colorEstado =  $this->request->getPost('txtColorEstado', null, '');
                    $descripcionEstado =  $this->request->getPost('txtDescripcionEstado', null, '');
                    $id_etapa =  $this->request->getPost('txtIdEtapa', null, '');
                    $n_etapa_id =  $this->request->getPost('slEtapa', null, '');
                    $accion =  $this->request->getPost('slAccion', null, 0);
                    $roles =  $this->request->getPost('roles', null, '');
                    $condicion =  $this->request->getPost('slCondicion', null, 0);
                    $diasLey =  $this->request->getPost('txtDiasLey', null, 0);
                    $diasUtpe =  $this->request->getPost('txtDiasUtpe', null, 0);
                    $prevencion=  $this->request->getPost('slPrevencion', null, 0);

                    switch ($opt) {
                        case 0:
                            //Guarda el registro del flujo
                            if(!empty($nombre) & !empty($descripcion) & !empty(($id))) {
                                $flujo = SdFlujo::findFirst($id);
                                $flujo->nombre = $nombre;
                                $flujo->descripcion = $descripcion;
                                $flujo->usuario_u = $this->session->usuario['usuario'];
                                $flujo->fecha_u =  new \Phalcon\Db\RawValue('SYSDATE');

                                if ($flujo) {
                                    if ($flujo->save()) {
                                        $this->mensaje = ['success', 'Se guardo correctamente.', null];
                                    } else {
                                        foreach ($flujo->getMessages() as $message) {
                                            $this->msnError .= $message->getMessage() . "<br/>";
                                        }
                                        $this->logger->error($this->msnError);
                                        $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.', null];
                                    }
                                } else {
                                    $this->mensaje = ['warning', 'La acción seleccionada no se encuentra en el sistema.', null];
                                }
                            }else {
                                $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                            }
                            break;

                        case 1:
                            //Guardamos la etapa
                            if(!empty($nombre) & !empty($descripcion) & !empty($color) &
                                !empty($nombreEstado) & !empty($descripcionEstado) & !empty($colorEstado)){
                                if (empty(($id))) {
                                    $secuencia = $this->db->query('SELECT SD_FLUJO_ETAPA_SEQ.nextval FROM dual');
                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                    $secuencia = $secuencia->fetchAll($secuencia);

                                    $flujoEtapa = new SdFlujoEtapa();
                                    $flujoEtapa->id = $secuencia[0]['NEXTVAL'];
                                    $flujoEtapa->id_flujo = $flujo_id;
                                    $flujoEtapa->nombre = $nombre;
                                    $flujoEtapa->descripcion = $descripcion;
                                    $flujoEtapa->color = $color;
                                    $flujoEtapa->condicion = $condicion;
                                    $flujoEtapa->principal = 0;
                                    $flujoEtapa->altura = rand (1, 1000);
                                    $flujoEtapa->izquierda =  rand (1, 1000);
                                    $flujoEtapa->usuario_i = $this->session->usuario['usuario'];
                                    $flujoEtapa->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                    $flujoEtapa->estatus = 'AC';

                                    if ($flujoEtapa->save()) {
                                        $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_SEQ.nextval FROM dual');
                                        $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                        $secuencia = $secuencia->fetchAll($secuencia);

                                        $flujoEstado = new SdFlujoEstado();
                                        $flujoEstado->id = $secuencia[0]['NEXTVAL'];
                                        $flujoEstado->id_flujo = $flujo_id;
                                        $flujoEstado->nombre = $nombreEstado;
                                        $flujoEstado->descripcion = $descripcionEstado;
                                        $flujoEstado->color = $colorEstado;
                                        $flujoEstado->orden = $secuencia[0]['NEXTVAL'];
                                        $flujoEstado->usuario_i = $this->session->usuario['usuario'];
                                        $flujoEstado->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                        $flujoEstado->estatus = 'AC';

                                        if($flujoEstado->save()){
                                            $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_SEQ.nextval FROM dual');
                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                            $secuencia = $secuencia->fetchAll($secuencia);

                                            $flujoEtapaEstado = new SdFlujoEtapaEstado();
                                            $flujoEtapaEstado->id = $secuencia[0]['NEXTVAL'];
                                            $flujoEtapaEstado->id_etapa = $flujoEtapa->id;
                                            $flujoEtapaEstado->id_estado = $flujoEstado->id;
                                            $flujoEtapaEstado->descripcion = $flujoEtapa->nombre . " - " . $flujoEstado->nombre;
                                            $flujoEtapaEstado->usuario_i = $this->session->usuario['usuario'];
                                            $flujoEtapaEstado->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                            $flujoEtapaEstado->estatus = 'AC';

                                            if($flujoEtapaEstado->save()) {
                                                $secuencia = $this->db->query('SELECT SD_PLAZOS_PREGUNTA_SEQ.nextval FROM dual');
                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                $flujoEstadoPlazos = new SdFlujoEstadoPlazos();
                                                $flujoEstadoPlazos->id = $secuencia[0]['NEXTVAL'];
                                                $flujoEstadoPlazos->id_estado = $flujoEstado->id;
                                                $flujoEstadoPlazos->dias_utpe = $diasUtpe;
                                                $flujoEstadoPlazos->dias_ley = $diasLey;
                                                $flujoEstadoPlazos->usuario_i = $this->session->usuario['usuario'];
                                                $flujoEstadoPlazos->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                $flujoEstadoPlazos->estatus = 'AC';
                                                if($flujoEstadoPlazos->save()) {
                                                    $this->mensaje = ['success', 'Se guardo correctamente.', null];
                                                }
                                            }
                                        }
                                    } else {
                                        foreach ($flujoEtapa->getMessages() as $message) {
                                            $this->msnError .= $message->getMessage() . "<br/>";
                                        }
                                        $this->logger->error($this->msnError);
                                        $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .  $this->msnError, null];
                                    }
                                }else{
                                    $flujoEtapa = SdFlujoEtapa::findFirst($id);
                                    $flujoEtapa->nombre = $nombre;
                                    $flujoEtapa->descripcion = $descripcion;
                                    $flujoEtapa->color = $color;
                                    $flujoEtapa->condicion = $condicion;
                                    $flujoEtapa->usuario_u = $this->session->usuario['usuario'];
                                    $flujoEtapa->fecha_u =  new \Phalcon\Db\RawValue('SYSDATE');

                                    if ($flujoEtapa->save()) {
                                        if(!empty($idEstado)){
                                            $flujoEstado = SdFlujoEstado::findFirst($idEstado);
                                            $flujoEstado->nombre = $nombreEstado;
                                            $flujoEstado->descripcion = $descripcionEstado;
                                            $flujoEstado->color = $colorEstado;
                                            $flujoEstado->usuario_u = $this->session->usuario['usuario'];
                                            $flujoEstado->fecha_u =  new \Phalcon\Db\RawValue('SYSDATE');
                                        }else{
                                            $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_SEQ.nextval FROM dual');
                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                            $secuencia = $secuencia->fetchAll($secuencia);

                                            $flujoEstado = new SdFlujoEstado();
                                            $flujoEstado->id = $secuencia[0]['NEXTVAL'];
                                            $flujoEstado->id_flujo = $flujo_id;
                                            $flujoEstado->nombre = $nombreEstado;
                                            $flujoEstado->descripcion = $descripcionEstado;
                                            $flujoEstado->color = $colorEstado;
                                            $flujoEstado->orden = $secuencia[0]['NEXTVAL'];
                                            $flujoEstado->usuario_i = $this->session->usuario['usuario'];
                                            $flujoEstado->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                            $flujoEstado->estatus = 'AC';
                                        }

                                        if ($flujoEstado->save()) {
                                            if(!empty($idEstado)){
                                                //Hacemos la búsqueda de los plazos del estado
                                                $flujoEstadoPlazos = SdFlujoEstadoPlazos::find([
                                                    'conditions' => 'id_estado=:id_estado: and estatus=:estatus:',
                                                    'bind' => ['id_estado' => $idEstado, 'estatus'=>'AC']
                                                ]);

                                                if(count($flujoEstadoPlazos) > 0) {
                                                    foreach ($flujoEstadoPlazos as $plazosEstado){
                                                        $plazosEstado->dias_utpe = (int)$diasUtpe;
                                                        $plazosEstado->dias_ley = (int)$diasLey;
                                                        $plazosEstado->usuario_u = $this->session->usuario['usuario'];
                                                        $plazosEstado->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                                                        if($plazosEstado->save() == false) {
                                                            $flag = false;
                                                        }
                                                    }
                                                }else{
                                                    $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_PLAZOS_SEQ.nextval FROM dual');
                                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                    $secuencia = $secuencia->fetchAll($secuencia);

                                                    $flujoEstadoPlazos = new SdFlujoEstadoPlazos();
                                                    $flujoEstadoPlazos->id = $secuencia[0]['NEXTVAL'];
                                                    $flujoEstadoPlazos->id_estado = $flujoEstado->id;
                                                    $flujoEstadoPlazos->dias_utpe = $diasUtpe;
                                                    $flujoEstadoPlazos->dias_ley = $diasLey;
                                                    $flujoEstadoPlazos->usuario_i = $this->session->usuario['usuario'];
                                                    $flujoEstadoPlazos->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                    $flujoEstadoPlazos->estatus = 'AC';

                                                    if($flujoEstadoPlazos->save() == false) {
                                                        $flag = false;
                                                    }
                                                }

                                            }else{
                                                $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_PLAZOS_SEQ.nextval FROM dual');
                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                $flujoEstadoPlazos = new SdFlujoEstadoPlazos();
                                                $flujoEstadoPlazos->id = $secuencia[0]['NEXTVAL'];
                                                $flujoEstadoPlazos->id_estado = $flujoEstado->id;
                                                $flujoEstadoPlazos->dias_utpe = $diasUtpe;
                                                $flujoEstadoPlazos->dias_ley = $diasLey;
                                                $flujoEstadoPlazos->usuario_i = $this->session->usuario['usuario'];
                                                $flujoEstadoPlazos->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                $flujoEstadoPlazos->estatus = 'AC';

                                                if($flujoEstadoPlazos->save() == false) {
                                                    $flag = false;
                                                }
                                            }

                                            if(empty($idEstado)){
                                                //Hacemos la búsqueda de la relacion de estado etapa
                                                $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_SEQ.nextval FROM dual');
                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                $flujoEtapaEstado = new SdFlujoEtapaEstado();
                                                $flujoEtapaEstado->id = $secuencia[0]['NEXTVAL'];
                                                $flujoEtapaEstado->id_etapa = $flujoEtapa->id;
                                                $flujoEtapaEstado->id_estado = $flujoEstado->id;
                                                $flujoEtapaEstado->descripcion = $descripcion;
                                                $flujoEtapaEstado->usuario_i = $this->session->usuario['usuario'];
                                                $flujoEtapaEstado->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                $flujoEtapaEstado->estatus = 'AC';
                                                if($flujoEtapaEstado->save() ==false) {
                                                    $flag = false;
                                                }
                                            }

                                            if($flag){
                                                $this->mensaje = ['success', 'Se guardo correctamente.', null];
                                            }else{
                                                $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.', null];
                                            }
                                        }
                                    } else {
                                        foreach ($flujoEtapa->getMessages() as $message) {
                                            $this->msnError .= $message->getMessage() . "<br/>";
                                        }
                                        $this->logger->error($this->msnError);
                                        $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.', null];
                                    }
                                }
                            }else {
                                $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                            }
                            break;

                        case 2:
                            //Guardamos la transacción
                            $boton = "";
                            $icono = "";

                            if(!empty($nombre) & !empty($descripcion)) {
                                switch ($accion) {
                                    case 0:
                                        //Pasa a la siguiente etapa sin que se realice alguna acción
                                        $boton = "btn-dropbox";
                                        $icono = "glyphicon glyphicon-share-alt";
                                        $acciones =[['INSERT','SdSolicitudHistorial',"", ""]];
                                        break;

                                    case 1:
                                        //Prepara respuesta de prevención
                                        $boton = "btn-dropbox";
                                        $icono = "glyphicon glyphicon-edit";
                                        $acciones =[['INSERT','SdSolicitudHistorial',"", ""],['GENERAR', 'SdPrevencion', "", ""]];
                                        break;

                                    case 2:
                                        //Se notifica al solicitante
                                        $boton = "btn-dropbox";
                                        $icono = "fa fa-envelope";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""],['NOTIFICACION', 'SdSolicitante', "", ""]];
                                        break;

                                    case 3:
                                        //Se notifica a la UTPE
                                        $boton = "btn-dropbox";
                                        $icono = "fa fa-envelope";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""],['NOTIFICACION', 'UTPE', "", ""]];
                                        break;

                                    case 4:
                                        //Cuando se cumple al condicion
                                        $boton = "btn-success";
                                        $icono = "fa fa-check";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""],['VALIDA', 'SdFlujoCondicion', "", ""]];
                                        break;

                                    case 5:
                                        //Cuando no se cumple la condicion
                                        $boton = "btn-danger";
                                        $icono = "glyphicon glyphicon-ban-circle";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""]];
                                        break;

                                    case 6:
                                        //Cuando la acción a realizar es el turnado de la solicitud
                                        $boton = "btn-primary";
                                        $icono = "glyphicon glyphicon-link";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""],['TURNAR', 'SdSolicitud', "", ""]];
                                        break;

                                    case 7:
                                        //Se hace el analisis de las peticiones por parte de las dependencias
                                        $boton = "btn-primary";
                                        $icono = "glyphicon glyphicon-search";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""]];
                                        break;

                                    case 8:
                                        //Se analiza la respuesta de la dependencia o UAR
                                        $boton = "btn-primary";
                                        $icono = "glyphicon glyphicon-search";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""]];

                                        break;

                                    case 9:
                                        //Se finaliza el flujo de la solicitud
                                        $boton = "btn-primary";
                                        $icono = "glyphicon glyphicon-link";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""],['TURNAR_UAR', 'SdSolicitud', "", ""]];
                                        break;

                                    case 10:
                                        //Se finaliza el flujo de la solicitud
                                        $boton = "btn-success";
                                        $icono = "fa fa-check";
                                        $acciones = [['INSERT', 'SdSolicitudHistorial', "", ""],['FINALIZAR', 'SdSolicitudHistorial', "", ""]];
                                        break;
                                }
                                if(!empty($id_etapa)){
                                    //Obtenemos la etapa actual de la transaccion
                                    $etapaActual = SdFlujoEtapa::findFirst($id_etapa);

                                    if($etapaActual){
                                        //Obtenemos la siguiente etapa de la transaccion
                                        $n_etapa = SdFlujoEtapa::findFirst($n_etapa_id);

                                        if($n_etapa){
                                            //Hacemos la búsqueda del estado del la siguiente etapa
                                            $estadoNuevo = SdFlujoEstado::query()
                                                ->columns(array( 'ID' => "SdFlujoEstado.id",'NOMBRE'=> 'SdFlujoEstado.nombre'))
                                                ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                                ->conditions("SdFlujoEtapaEstado.id_etapa=:id_etapa:  AND SdFlujoEstado.estatus=:estatus:")
                                                ->bind(['id_etapa' => $n_etapa->id, 'estatus' => 'AC'])
                                                ->execute()->toArray();

                                            if(count($estadoNuevo) > 0){
                                                foreach ($estadoNuevo AS $n_estado){
                                                    //Hacemos la búsqueda de los estados nuevos
                                                    $estados = SdFlujoEstado::query()
                                                        ->columns(array( 'ID' => "SdFlujoEstado.id",'NOMBRE'=> 'SdFlujoEstado.nombre'))
                                                        ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                                        ->conditions("SdFlujoEtapaEstado.id_etapa=:id_etapa:  AND SdFlujoEstado.estatus=:estatus:")
                                                        ->bind(['id_etapa' => $etapaActual->id, 'estatus' => 'AC'])
                                                        ->execute()->toArray();

                                                    if(count($estados) > 0){
                                                        //Validamos si la transaccion ya existe
                                                        if(!empty(($id))){
                                                            //Hacemos la búsqueda de la transacción
                                                            $transaccionAccion = SdFlujoTransaccionAccion::find([
                                                                'conditions' => 'id_transaccion=:id_transaccion:',
                                                                'bind' => ['id_transaccion'=>$id]
                                                            ]);
                                                            if(count($transaccionAccion) > 0){
                                                                foreach ($transaccionAccion AS $transa){
                                                                    $query = "DELETE FROM SdFlujoTransaccionAccion WHERE id_transaccion = :id_transaccion:";
                                                                    $eliminaTransAccion = $this->modelsManager->executeQuery($query, array('id_transaccion' => $transa->id_transaccion));

                                                                    $query = " DELETE FROM SdFlujoAccion WHERE id = :id:";
                                                                    $eliminaAccion = $this->modelsManager->executeQuery($query, array('id' => $transa->id_accion));

                                                                    $query = " DELETE FROM SdFlujoTransaccionRol WHERE id_transaccion = :id_transaccion:";
                                                                    $eliminaTransRol = $this->modelsManager->executeQuery($query, array('id_transaccion' => $transa->id_transaccion));

                                                                    $query = " DELETE FROM SdFlujoEstadoTransaccion WHERE id_transaccion = :id_transaccion:";
                                                                    $eliminaEstadoTrans = $this->modelsManager->executeQuery($query, array('id_transaccion' => $transa->id_transaccion));

                                                                    $query = " DELETE FROM SdSolicitudHistorial WHERE id_transaccion = :id_transaccion:";
                                                                    $eliminaHistorialTrans = $this->modelsManager->executeQuery($query, array('id_transaccion' => $transa->id_transaccion));

                                                                    $query = " DELETE FROM SdFlujoTransaccion WHERE id = :id:";
                                                                    $eliminaTransaccion = $this->modelsManager->executeQuery($query, array('id' => $id));

                                                                    if ($eliminaTransAccion->success() == false & $eliminaAccion->success() == false & $eliminaHistorialTrans->success() == false &
                                                                        $eliminaTransRol->success() == false  & $eliminaEstadoTrans->success() == false& $eliminaTransaccion->success() == false) {
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        foreach ($estados AS $estado){
                                                            $secuencia = $this->db->query('SELECT SD_FLUJO_TRANSACCION_SEQ.nextval FROM dual');
                                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                            $secuencia = $secuencia->fetchAll($secuencia);

                                                            //Creamos la transacción necesaria para los estados
                                                            $flujoTransaccion = new SdFlujoTransaccion();
                                                            $flujoTransaccion->id = $secuencia[0]['NEXTVAL'];
                                                            $flujoTransaccion->id_flujo = $flujo_id;
                                                            $flujoTransaccion->nombre = $nombre;
                                                            $flujoTransaccion->descripcion = $descripcion;
                                                            $flujoTransaccion->boton = $boton;
                                                            $flujoTransaccion->icono = $icono;
                                                            $flujoTransaccion->formulario = $accion;
                                                            if($prevencion){
                                                                $flujoTransaccion->id_prevencion = $prevencion;
                                                            }
                                                            if($condicion){
                                                                $flujoTransaccion->condicion = $condicion;
                                                            }
                                                            $flujoTransaccion->usuario_i = $this->session->usuario['usuario'];
                                                            $flujoTransaccion->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                            $flujoTransaccion->estatus = 'AC';

                                                            if ($flujoTransaccion) {
                                                                if ($flujoTransaccion->save()) {
                                                                    $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_TRANS_SEQ.nextval FROM dual');
                                                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                    $secuencia = $secuencia->fetchAll($secuencia);

                                                                    $flujoEstadoTransaccion = new SdFlujoEstadoTransaccion();
                                                                    $flujoEstadoTransaccion->id = $secuencia[0]['NEXTVAL'];
                                                                    $flujoEstadoTransaccion->id_estado = $estado['ID'];
                                                                    $flujoEstadoTransaccion->id_transaccion = $flujoTransaccion->id;
                                                                    $flujoEstadoTransaccion->descripcion = $estado['NOMBRE'] ." + " . $flujoTransaccion->nombre;
                                                                    $flujoEstadoTransaccion->usuario_i = $this->session->usuario['usuario'];
                                                                    $flujoEstadoTransaccion->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                                    $flujoEstadoTransaccion->estatus = 'AC';

                                                                    if ($flujoEstadoTransaccion->save()) {
                                                                        foreach ($roles as $rol){
                                                                            $secuencia = $this->db->query('SELECT SD_FLUJO_TRANSACCION_ROL_SEQ.nextval FROM dual');
                                                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                            $secuencia = $secuencia->fetchAll($secuencia);

                                                                            $transaccionRol = new SdFlujoTransaccionRol();
                                                                            $transaccionRol->id = $secuencia[0]['NEXTVAL'];
                                                                            $transaccionRol->id_transaccion = $flujoTransaccion->id;
                                                                            $transaccionRol->id_rol = $rol['ID'];
                                                                            $transaccionRol->descripcion = $flujoTransaccion->nombre ." + " .  $rol['NOMBRE'];
                                                                            $transaccionRol->usuario_i = $this->session->usuario['usuario'];
                                                                            $transaccionRol->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                                            $transaccionRol->estatus = 'AC';

                                                                            if ($transaccionRol) {
                                                                                if ($transaccionRol->save() == false){
                                                                                    $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .   $this->msnError, null];
                                                                                }
                                                                            }else{  $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .   $this->msnError, null]; }
                                                                        }
                                                                        foreach ($acciones as $nAccion) {
                                                                            $secuencia = $this->db->query('SELECT SD_FLUJO_ACCION_SEQ.nextval FROM dual');
                                                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                            $secuencia = $secuencia->fetchAll($secuencia);

                                                                            $flujoAccion = new SdFlujoAccion();
                                                                            $flujoAccion->id = $secuencia[0]['NEXTVAL'];
                                                                            $flujoAccion->id_flujo = $flujo_id;
                                                                            $flujoAccion->nombre = $flujoTransaccion->nombre;
                                                                            $flujoAccion->descripcion = $flujoTransaccion->descripcion;
                                                                            $flujoAccion->tipo = $nAccion[0];
                                                                            $flujoAccion->tabla = $nAccion[1];
                                                                            $flujoAccion->campo = $nAccion[2];
                                                                            $flujoAccion->valor = $nAccion[3];
                                                                            $flujoAccion->n_etapa_id = $n_etapa->id;
                                                                            $flujoAccion->n_etapa = $n_etapa->nombre;
                                                                            $flujoAccion->n_estado_id = $n_estado['ID'];
                                                                            $flujoAccion->n_estado = $n_estado['NOMBRE'];
                                                                            $flujoAccion->usuario_i = $this->session->usuario['usuario'];
                                                                            $flujoAccion->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                                            $flujoAccion->estatus = 'AC';

                                                                            if ($flujoAccion) {
                                                                                if ($flujoAccion->save()){
                                                                                    $secuencia = $this->db->query('SELECT SD_FLUJO_TRANS_ACCION_SEQ.nextval FROM dual');
                                                                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                                    $secuencia = $secuencia->fetchAll($secuencia);

                                                                                    $transaccionAccion = new SdFlujoTransaccionAccion();
                                                                                    $transaccionAccion->id = $secuencia[0]['NEXTVAL'];
                                                                                    $transaccionAccion->id_accion = $flujoAccion->id;
                                                                                    $transaccionAccion->id_transaccion = $flujoTransaccion->id;
                                                                                    $transaccionAccion->descripcion = $flujoTransaccion->nombre ." + " . $flujoAccion->nombre;
                                                                                    $transaccionAccion->usuario_i = $this->session->usuario['usuario'];
                                                                                    $transaccionAccion->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                                                    $transaccionAccion->estatus = 'AC';
                                                                                    if ($transaccionAccion) {
                                                                                        if ($transaccionAccion->save()){
                                                                                            $this->mensaje = ['success', 'Se guardo correctamente.', null];
                                                                                        }
                                                                                    }else{  $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .   $this->msnError, null]; }
                                                                                }
                                                                            }else{ $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .   $this->msnError, null]; }
                                                                        }
                                                                    } else {
                                                                        foreach ($flujoEstadoTransaccion->getMessages() as $message) {
                                                                            $this->msnError .= $message->getMessage() . "<br/>";
                                                                        }
                                                                        $this->logger->error($this->msnError);
                                                                        $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .   $this->msnError , null];
                                                                    }
                                                                } else {
                                                                    foreach ($flujoTransaccion->getMessages() as $message) {
                                                                        $this->msnError .= $message->getMessage() . "<br/>";
                                                                    }
                                                                    $this->logger->error($this->msnError);
                                                                    $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' .   $this->msnError, null];
                                                                }
                                                            } else {
                                                                $this->mensaje = ['warning', 'La acción seleccionada no se encuentra en el sistema.', null];
                                                            }
                                                        }
                                                    }
                                                }
                                            }else{
                                                $this->mensaje = ['warning', 'La etapa a conectar no tiene un estatus registrado', null];
                                            }
                                        }else{
                                            $this->mensaje = ['warning', 'No se tiene una etapa seleccionada', null];
                                        }
                                    } else{
                                        $this->mensaje = ['warning', 'No se tiene una etapa seleccionada', null];
                                    }
                                }else{
                                    $this->mensaje = ['warning', 'No se ha seleccionado etapa', null];
                                }
                            }else {
                                $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                            }

                            break;

                        case 3:

                            $cambioEtapas= [];
                            $cambioEstados= [];

                            //Hacemos la copia del flujo
                            $flujoPadre = SdFlujo::findFirst($flujo_id);
                            $flujoPadre->aprobado = 1;
                            $flujoPadre->estatus = 'IN'; //Inactivamos el flujo padre
                            $flujoPadre->usuario_u = $this->session->usuario['usuario'];
                            $flujoPadre->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                            $secuencia = $this->db->query('SELECT SD_FLUJO_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            //Duplicamos el flujo padre con los mismos datos del flujo_padre
                            $flujo = new SdFlujo();
                            $flujo->id_flujo = $secuencia[0]['NEXTVAL'];
                            $flujo->nombre = $flujoPadre->nombre;
                            $flujo->descripcion = $flujoPadre->descripcion;
                            $flujo->aprobado = 0;
                            $flujo->id_tipo = $flujoPadre->id_tipo;;
                            $flujo->id_padre = $flujoPadre->id_flujo;
                            $flujo->usuario_i = $this->session->usuario['usuario'];
                            $flujo->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $flujo->estatus = 'AC';

                            if ($flujo->save()) {
                                //Hacemos la búsqueda de las etapas a clonar
                                $etapas = SdFlujoEtapa::find(
                                    ['conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus:',
                                        'bind' => ['id_flujo'=> $flujo_id, 'estatus'=> 'AC']]);

                                if($etapas){
                                    foreach ($etapas as $etapa){
                                        $secuencia = $this->db->query('SELECT SD_FLUJO_ETAPA_SEQ.nextval FROM dual');
                                        $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                        $secuencia = $secuencia->fetchAll($secuencia);
                                        //Hacemos la copia de las etapas
                                        $flujoEtapa = new SdFlujoEtapa();
                                        $flujoEtapa->id = $secuencia[0]['NEXTVAL'];
                                        $flujoEtapa->id_flujo = $flujo->id_flujo;
                                        $flujoEtapa->nombre = $etapa->nombre;
                                        $flujoEtapa->descripcion = $etapa->descripcion;
                                        $flujoEtapa->color = $etapa->color;
                                        $flujoEtapa->principal = $etapa->principal;
                                        $flujoEtapa->altura = $etapa->altura;
                                        $flujoEtapa->izquierda = $etapa->izquierda;
                                        $flujoEtapa->condicion = $etapa->condicion;
                                        $flujoEtapa->editar = $etapa->editar;
                                        $flujoEtapa->usuario_i = $this->session->usuario['usuario'];
                                        $flujoEtapa->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $flujoEtapa->estatus = 'AC';

                                        if ($flujoEtapa->save()) {
                                            //Se hace el llano del array con la relacion de la etapa vieja y la nueva
                                            $cambioEtapas[$etapa->id] = $flujoEtapa->id;

                                            //Para cada etapa le asignamos el estado
                                            $estados = SdFlujoEstado::query()
                                                ->columns(array('ID' => "SdFlujoEstado.id",'NOMBRE'=> 'SdFlujoEstado.nombre', 'DESCRIPCION'=>
                                                    'SdFlujoEstado.descripcion', 'COLOR'=> 'SdFlujoEstado.color', 'ORDEN'=> 'SdFlujoEstado.orden'))
                                                ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                                ->conditions("SdFlujoEstado.estatus=:estatus: AND SdFlujoEtapaEstado.id_etapa=:id_etapa:")
                                                ->bind(['id_etapa' => $etapa->id, 'estatus'=>'AC'])
                                                ->execute();

                                            if($estados){
                                                foreach ($estados as $nEstado) {
                                                    $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_SEQ.nextval FROM dual');
                                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                    $secuencia = $secuencia->fetchAll($secuencia);

                                                    //Hacemos la copia de los estados
                                                    $estado = new SdFlujoEstado();
                                                    $estado->id = $secuencia[0]['NEXTVAL'];
                                                    $estado->id_flujo = $flujoEtapa->id_flujo;
                                                    $estado->nombre =$nEstado->NOMBRE;
                                                    $estado->descripcion = $nEstado->DESCRIPCION;
                                                    $estado->color = $nEstado->COLOR;
                                                    $estado->orden = $nEstado->ORDEN;
                                                    $estado->usuario_i = $this->session->usuario['usuario'];
                                                    $estado->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                    $estado->estatus = 'AC';

                                                    if ($estado->save()) {
                                                        //Hacemos la copia de los plazos del estado
                                                        $plazos = SdFlujoEstadoPlazos::find(
                                                            ['conditions' => 'id_estado=:id_estado: AND estatus=:estatus:',
                                                                'bind' => ['id_estado'=> $nEstado->ID, 'estatus'=> 'AC']]);
                                                        if(count($plazos) > 0){
                                                            foreach ($plazos AS $plazo){
                                                                $secuencia = $this->db->query('SELECT SD_PLAZOS_PREGUNTA_SEQ.nextval FROM dual');
                                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                                $flujoEstadoPlazos = new SdFlujoEstadoPlazos();
                                                                $flujoEstadoPlazos->id = $secuencia[0]['NEXTVAL'];
                                                                $flujoEstadoPlazos->id_estado = $estado->id;
                                                                $flujoEstadoPlazos->dias_utpe = $plazo->dias_utpe;
                                                                $flujoEstadoPlazos->dias_ley = $plazo->dias_ley;
                                                                $flujoEstadoPlazos->usuario_i = $this->session->usuario['usuario'];
                                                                $flujoEstadoPlazos->fecha_i =  new \Phalcon\Db\RawValue('SYSDATE');
                                                                $flujoEstadoPlazos->estatus = 'AC';
                                                                if ($flujoEstadoPlazos->save() == false){
                                                                    $flag = false;
                                                                }
                                                            }
                                                        }

                                                        $cambioEstados[$nEstado->ID] = $estado->id;

                                                        $secuencia = $this->db->query('SELECT SD_FLUJO_ETAPA_ESTADO_SEQ.nextval FROM dual');
                                                        $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                        $secuencia = $secuencia->fetchAll($secuencia);

                                                        //Hacemos la relación de la etapa con el estado
                                                        $etapaEstado = new SdFlujoEtapaEstado();
                                                        $etapaEstado->id = $secuencia[0]['NEXTVAL'];
                                                        $etapaEstado->id_etapa = $flujoEtapa->id;
                                                        $etapaEstado->id_estado = $estado->id;
                                                        $etapaEstado->descripcion = $estado->nombre . " + " . $estado->nombre;
                                                        $etapaEstado->usuario_i = $this->session->usuario['usuario'];
                                                        $etapaEstado->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                        $etapaEstado->estatus = 'AC';

                                                        if ($etapaEstado->save() == false){
                                                            $flag = false;
                                                        }
                                                        //Hacemos la búsqueda de las transacciones a clonar
                                                        $transacciones = SdFlujoTransaccion::query()
                                                            ->columns(array('ID' => "SdFlujoTransaccion.id",'NOMBRE'=> 'SdFlujoTransaccion.nombre',
                                                                'DESCRIPCION'=> 'SdFlujoTransaccion.descripcion', 'BOTON'=> 'SdFlujoTransaccion.boton',
                                                                'FORMULARIO'=> 'SdFlujoTransaccion.formulario',  'ICONO'=> 'SdFlujoTransaccion.icono',
                                                                'PREVENCION'=> 'SdFlujoTransaccion.id_prevencion', 'CONDICION'=> 'SdFlujoTransaccion.condicion'))
                                                            ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoEstadoTransaccion')
                                                            ->conditions("SdFlujoTransaccion.estatus=:estatus: AND SdFlujoEstadoTransaccion.id_estado=:id_estado:")
                                                            ->bind(['id_estado' => $nEstado->ID, 'estatus'=>'AC'])
                                                            ->execute();

                                                        if($transacciones){
                                                            foreach ($transacciones as $nTransaccion) {
                                                                $secuencia = $this->db->query('SELECT SD_FLUJO_TRANSACCION_SEQ.nextval FROM dual');
                                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                $secuencia = $secuencia->fetchAll($secuencia);
                                                                //Hacemos la copia de las transacciones
                                                                $transaccion = new SdFlujoTransaccion();
                                                                $transaccion->id =$secuencia[0]['NEXTVAL'];
                                                                $transaccion->id_flujo = $flujoEtapa->id_flujo;
                                                                $transaccion->nombre = $nTransaccion->NOMBRE;
                                                                $transaccion->descripcion = $nTransaccion->DESCRIPCION;
                                                                $transaccion->boton = $nTransaccion->BOTON;
                                                                $transaccion->icono = $nTransaccion->ICONO;
                                                                $transaccion->formulario = $nTransaccion->FORMULARIO;
                                                                $transaccion->id_prevencion = $nTransaccion->PREVENCION;
                                                                $transaccion->condicion = $nTransaccion->CONDICION;
                                                                $transaccion->usuario_i = $this->session->usuario['usuario'];
                                                                $transaccion->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                $transaccion->estatus = 'AC';

                                                                if ($transaccion->save()) {
                                                                    $secuencia = $this->db->query('SELECT SD_FLUJO_ESTADO_TRANS_SEQ.nextval FROM dual');
                                                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                    $secuencia = $secuencia->fetchAll($secuencia);
                                                                    //Hacemos la relación del estado con la transacción
                                                                    $estadoTransaccion = new SdFlujoEstadoTransaccion();
                                                                    $estadoTransaccion->id =$secuencia[0]['NEXTVAL'];
                                                                    $estadoTransaccion->id_estado = $estado->id;
                                                                    $estadoTransaccion->id_transaccion = $transaccion->id;
                                                                    $estadoTransaccion->descripcion = $estado->nombre ." + " . $transaccion->nombre;
                                                                    $estadoTransaccion->usuario_i = $this->session->usuario['usuario'];
                                                                    $estadoTransaccion->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                    $estadoTransaccion->estatus = 'AC';

                                                                    if ($estadoTransaccion->save() == false){
                                                                        $flag = false;
                                                                    }

                                                                    $roles = SdFlujoTransaccionRol::find(
                                                                        ['conditions' => 'id_transaccion=:id_transaccion: AND estatus=:estatus:',
                                                                            'bind' => ['id_transaccion'=> $nTransaccion->ID, 'estatus'=> 'AC']]);

                                                                    if(count($roles) > 0){
                                                                        foreach ($roles as $rol) {
                                                                            $secuencia = $this->db->query('SELECT SD_FLUJO_TRANSACCION_ROL_SEQ.nextval FROM dual');
                                                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                            $secuencia = $secuencia->fetchAll($secuencia);
                                                                            //Hacemos la relación de la transacción con el rol
                                                                            $transaccionRol = new SdFlujoTransaccionRol();
                                                                            $transaccionRol->id =$secuencia[0]['NEXTVAL'];
                                                                            $transaccionRol->id_transaccion = $transaccion->id;
                                                                            $transaccionRol->id_rol = $rol->id_rol;
                                                                            $transaccionRol->descripcion = $rol->descripcion;
                                                                            $transaccionRol->usuario_i = $this->session->usuario['usuario'];
                                                                            $transaccionRol->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                            $transaccionRol->estatus = 'AC';

                                                                            if ($transaccionRol->save() == false){
                                                                                $flag = false;
                                                                            }
                                                                        }
                                                                    }else{
                                                                        $this->mensaje = ['warning', 'No se encuentran roles a clonar ', null];
                                                                    }
                                                                    //Hacemos la búsqueda de las acciones a clonar
                                                                    $acciones = SdFlujoAccion::query()
                                                                        ->columns(array('ID' => "SdFlujoAccion.id",'NOMBRE'=> 'SdFlujoAccion.nombre', 'TABLA'=> 'SdFlujoAccion.tabla',
                                                                            'DESCRIPCION'=> 'SdFlujoAccion.descripcion', 'TIPO'=> 'SdFlujoAccion.tipo', 'CAMPO'=> 'SdFlujoAccion.campo',
                                                                            'VALOR'=> 'SdFlujoAccion.valor', 'N_ESTADO_ID'=> 'SdFlujoAccion.n_estado_id', 'N_ESTADO'=> 'SdFlujoAccion.n_estado',
                                                                            'N_ETAPA'=> 'SdFlujoAccion.n_etapa', 'N_ETAPA_ID'=> 'SdFlujoAccion.n_etapa_id'))
                                                                        ->innerJoin('SdFlujoTransaccionAccion', "SdFlujoTransaccionAccion.id_accion = SdFlujoAccion.id", 'SdFlujoTransaccionAccion')
                                                                        ->conditions("SdFlujoAccion.estatus=:estatus: AND SdFlujoTransaccionAccion.id_transaccion=:id_transaccion:")
                                                                        ->bind(['id_transaccion' => $nTransaccion->ID, 'estatus'=>'AC'])
                                                                        ->execute();

                                                                    if($acciones){
                                                                        foreach ($acciones as $nAccion) {
                                                                            $secuencia = $this->db->query('SELECT SD_FLUJO_ACCION_SEQ.nextval FROM dual');
                                                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                            $secuencia = $secuencia->fetchAll($secuencia);
                                                                            //Hacemos la copia de las acciones
                                                                            $accion = new SdFlujoAccion();
                                                                            $accion->id =$secuencia[0]['NEXTVAL'];
                                                                            $accion->id_flujo =  $flujoEtapa->id_flujo;
                                                                            $accion->nombre = $nAccion->NOMBRE;
                                                                            $accion->descripcion = $nAccion->DESCRIPCION;
                                                                            $accion->tipo = $nAccion->TIPO;
                                                                            $accion->tabla = $nAccion->TABLA;
                                                                            $accion->campo = $nAccion->CAMPO;
                                                                            $accion->valor = $nAccion->VALOR;
                                                                            $accion->n_etapa = $nAccion->N_ETAPA;
                                                                            $accion->n_etapa_id = $nAccion->N_ETAPA_ID;
                                                                            $accion->n_estado = $nAccion->N_ESTADO;
                                                                            $accion->n_estado_id = $nAccion->N_ESTADO_ID;
                                                                            $accion->usuario_i = $this->session->usuario['usuario'];
                                                                            $accion->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                            $accion->estatus = 'AC';

                                                                            if ($accion->save()) {
                                                                                $secuencia = $this->db->query('SELECT SD_FLUJO_TRANS_ACCION_SEQ.nextval FROM dual');
                                                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                                $secuencia = $secuencia->fetchAll($secuencia);
                                                                                //Hacemos la relación de la transacción con la acción
                                                                                $transaccionAccion = new SdFlujoTransaccionAccion();
                                                                                $transaccionAccion->id =$secuencia[0]['NEXTVAL'];
                                                                                $transaccionAccion->id_accion = $accion->id;
                                                                                $transaccionAccion->id_transaccion = $transaccion->id;
                                                                                $transaccionAccion->descripcion = $transaccion->nombre ." + " . $accion->nombre;
                                                                                $transaccionAccion->usuario_i = $this->session->usuario['usuario'];
                                                                                $transaccionAccion->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                                $transaccionAccion->estatus = 'AC';

                                                                                if ($transaccionAccion->save() == false){
                                                                                    $flag = false;
                                                                                }
                                                                            }else {
                                                                                foreach ($accion->getMessages() as $message) {
                                                                                    $this->msnError .= $message->getMessage() . "<br/>";
                                                                                }
                                                                                $this->logger->error($this->msnError);
                                                                                $this->mensaje = ['error', 'Ocurrio un error al agregar las acciones.' .   $this->msnError , null];
                                                                            }
                                                                        }
                                                                    }else{
                                                                        $this->mensaje = ['warning', 'El flujo no se puede clonar porque no ha sido completado.', null];
                                                                    }
                                                                }else {
                                                                    foreach ($estado->getMessages() as $message) {
                                                                        $this->msnError .= $message->getMessage() . "<br/>";
                                                                    }
                                                                    $this->logger->error($this->msnError);
                                                                    $this->mensaje = ['error', 'Ocurrio un error al agregar los registos 1.' .   $this->msnError , null];
                                                                }
                                                            }
                                                        }else{
                                                            $this->mensaje = ['warning', 'No se encuentran transacciones a clonar ', null];
                                                        }
                                                    }else {
                                                        foreach ($estado->getMessages() as $message) {
                                                            $this->msnError .= $message->getMessage() . "<br/>";
                                                        }
                                                        $this->mensaje = ['error', 'Ocurrio un error al agregar los registos. 2' .   $this->msnError , null];
                                                    }
                                                }
                                            }else{
                                                $this->mensaje = ['warning', 'No se encuentran estados a clonar ', null];
                                            }
                                        } else {
                                            foreach ($flujoEtapa->getMessages() as $message) {
                                                $this->msnError .= $message->getMessage() . "<br/>";
                                            }
                                            $this->logger->error($this->msnError);
                                            $this->mensaje = ['error', 'Ocurrio un error al agregar los registos. 3' .   $this->msnError , null];
                                        }
                                    }
                                }else{
                                    $this->mensaje = ['warning', 'No se encuentran etapas a clonar ', null];
                                }
                            } else {
                                foreach ($flujo->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->logger->error($this->msnError);
                                $this->mensaje = ['error', 'Ocurrio un error al agregar los registos.' . $this->msnError, null];
                            }

                            if($flag) {
                                //Hacemos la búsqueda de la acción
                                $acciones = SdFlujoAccion::find(
                                    ['conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus: AND n_estado_id IS NOT NULL',
                                        'bind' => ['id_flujo'=> $flujo->id_flujo, 'estatus'=> 'AC']]);

                                if(count($acciones) > 0){
                                    foreach ($acciones as $nAccion) {
                                        $estadoN = SdFlujoEstado::findFirst((int)$cambioEstados[(int)$nAccion->n_estado_id]);
                                        $etapaN = SdFlujoEtapa::findFirst((int)$cambioEtapas[(int)$nAccion->n_etapa_id]);

                                        //Agregamos la accion para registrar
                                        $acciond = SdFlujoAccion::findFirst($nAccion->id);
                                        $acciond->n_etapa_id = $etapaN->id;
                                        $acciond->n_estado_id = $estadoN->id;

                                        if ($acciond->save()) {
                                            if ($flujoPadre->save()) {
                                                $this->mensaje = ['success', 'Se inactivo correctamente.', $flujo];
                                            } else {
                                                foreach ($flujoPadre->getMessages() as $message) {
                                                    $this->msnError .= $message->getMessage() . "<br/>";
                                                }
                                                $this->logger->error($this->msnError);
                                                $this->mensaje = ['danger', 'Ocurrio un problema al aprobar el flujo.', null];
                                            }
                                        } else {
                                            foreach ($acciond->getMessages() as $message) {
                                                $this->msnError .= $message->getMessage() . "<br/>";
                                            }
                                            $this->logger->error($this->msnError);
                                            $this->mensaje = ['error', 'Ocurrio un error al registrar el flujo.' . $this->msnError, null];
                                        }
                                    }
                                }else{
                                    $this->mensaje = ['warning', 'No se encuentran acciones a clonar ', null];
                                }
                            }
                            break;
                    }
                } catch (\Exception $e) {
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar al flujo.', null];
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
     *  Rechaza el flujo seleccionado en base a id_flujo
     *  @param int $id del flujo
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    $opt = $this->request->get('opt', null, 0);
                    $id = $this->request->get('id', null, 0);

                    switch ($opt) {
                        case 0:
                            //Se realiza la búsqueda del flujo a rechazar
                            $registro = SdFlujo::findFirst($id);
                            $registro->aprobado = 0;
                            break;
                        case 1:
                            //Se realiza la búsqueda de la etapa a rechazar
                            $registro = SdFlujoEtapa::findFirst($id);
                            break;
                        case 2:
                            //Se realiza la búsqueda del flujo a rechazar
                            $registro = SdFlujoEstado::findFirst($id);
                            break;
                        case 3:
                            //Se realiza la búsqueda de la transaccion a rechazar
                            $registro = SdFlujoTransaccion::findFirst($id);
                            break;
                    }
                    if ($registro) {
                        $registro->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $registro->usuario_u = $this->session->usuario['usuario'];
                        $registro->fecha_u =  new \Phalcon\Db\RawValue('SYSDATE');

                        if ($registro->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente.', null];
                        } else {
                            foreach ($registro->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al borrar.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'No se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar.', null];
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
     *  Aprueba el flujo seleccionado
     *  @param int $id del flujo
     *  @author Dora Nely Vega Gonzalez
     */
    public function cambiarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    $id = $this->request->get('txtId', null, 0);
                    //Se realiza la búsqueda del flujo que se desea aprobar
                    $flujo = SdFlujo::findFirst($id);

                    $etapa = SdFlujoEtapa::find(
                        ['conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus: AND principal=:principal:',
                            'bind' => ['id_flujo'=> $flujo->id_flujo, 'estatus'=> 'AC', 'principal'=> 1]]);

                    if(count($etapa) > 0){
                        if ($flujo) {
                            $flujo->aprobado = 1;
                            $flujo->estatus = 'AC';
                            $flujo->usuario_u = $this->session->usuario['usuario'];
                            $flujo->fecha_u =  new \Phalcon\Db\RawValue('SYSDATE');

                            if ($flujo->save()) {
                                $this->mensaje = ['success', 'Se aprobó correctamente.', null];
                            } else {
                                foreach ($flujo->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->mensaje = ['danger', 'Ocurrio un problema al aprobar el flujo.', null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El flujo no se encuentra en base de datos.', null];
                        }
                    }else{
                        $this->mensaje = ['warning', 'Debes tener una etapa principal.', null];
                    }
                }catch (\Exception $e) {
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar al flujo.', null];
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
     *  Hace un listado con las workflow activas
     *  Retorna array en formato json con todas las workflow
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        //Defición de Variables al realizar el filtro
        $opt = $this->request->get('opt', null, 0);
        $id = $this->request->get('id', null, 0);
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

                switch ($opt) {
                    case 0:
                        //obtenemos los flujos para las solicitudes
                        $registros = SdFlujo::query()
                            ->columns(array('ID' => "SdFlujo.id_flujo", 'NOMBRE' => "SdFlujo.nombre", 'DESCRIPCION' => "SdFlujo.descripcion",
                                'APROBADO' => "SdFlujo.aprobado",  'USUARIO_I' => "SdUsuario.nombre", 'FECHA_I' => "to_char(SdFlujo.fecha_i,'DD/MM/YYYY')",  'ESTATUS' => "SdFlujo.estatus"))
                            ->leftJoin('SdUsuario', "SdUsuario.usuario = SdFlujo.usuario_i", 'SdUsuario')
                            ->conditions("UPPER(REPLACE(SdFlujo.nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:search:)")
                            ->bind(['search' => '%'.strtolower(trim($search)).'%'])
                            ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                            ->execute();
                        break;

                    case 2:
                        //Obtenemos las etapas activas
                        $registros = SdFlujoEtapa::query()
                            ->columns(array('ID' => "SdFlujoEtapa.id",'NOMBRE'=> 'SdFlujoEtapa.nombre', 'DESCRIPCION'=> 'SdFlujoEtapa.descripcion',
                                'PRINCIPAL'=>'SdFlujoEtapa.principal','CONDICION'=>'SdFlujoEtapa.condicion','EDITAR'=>'SdFlujoEtapa.editar',
                                'NOMBRE_ESTADO'=>'SdFlujoEstado.nombre','DESCRIPCION_ESTADO'=>'SdFlujoEstado.descripcion',
                                'DIAS_UTPE'=>'SdFlujoEstadoPlazos.dias_utpe','DIAS_LEY'=>'SdFlujoEstadoPlazos.dias_ley',
                                'ID_ESTADO' => 'SdFlujoEstado.id','COLOR' => 'SdFlujoEtapa.color','COLOR_ESTADO' => 'SdFlujoEstado.color'))
                            ->leftJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_etapa = SdFlujoEtapa.id", 'SdFlujoEtapaEstado')
                            ->leftJoin('SdFlujoEstado', "SdFlujoEstado.id = SdFlujoEtapaEstado.id_estado", 'SdFlujoEstado')
                            ->leftJoin('SdFlujoEstadoPlazos', "SdFlujoEstadoPlazos.id_estado = SdFlujoEstado.id", 'SdFlujoEstadoPlazos')
                            ->conditions("UPPER(REPLACE(SdFlujoEtapa.nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:search:) 
                            AND SdFlujoEtapa.id_flujo=:id_flujo: AND SdFlujoEtapa.estatus=:estatus:")
                            ->bind(['search' => '%'.strtolower(trim($search)).'%', 'id_flujo' => (int)$id, 'estatus' => 'AC'])
                            ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                            ->execute();
                        break;

                    case 3:
                        //obtenemos los estados activos
                        $registros = $funcion->obtenerEstados($id);
                        break;
                    case 4:
                        $registros = SdFlujoTransaccion::query()
                            ->columns(array(
                                'ID'=>"SdFlujoTransaccion.id",
                                'NOMBRE'=>'SdFlujoTransaccion.nombre',
                                'DESCRIPCION'=>'SdFlujoTransaccion.descripcion',
                                'BOTON'=>'SdFlujoTransaccion.boton',
                                'ICONO'=>'SdFlujoTransaccion.icono',
                                'FORMULARIO'=>'SdFlujoTransaccion.formulario',
                                'ID_ETAPA'=>'SdFlujoEtapa.id',
                                'ETAPA'=>'SdFlujoEtapa.nombre',
                                'COLOR_ETAPA'=>'SdFlujoEstado.color',
                                'ID_ESTADO'=>'SdFlujoEstado.id',
                                'ESTADO'=>'SdFlujoEstado.nombre',
                                'COLOR_ESTADO'=>'FlujoEstado2.color',
                                'N_ETAPA_ID'=>'SdFlujoAccion.n_etapa_id',
                                'N_ETAPA'=>'SdFlujoAccion.n_etapa',
                                'N_ESTADO_ID'=>'SdFlujoAccion.n_estado_id',
                                'N_ESTADO'=>'SdFlujoAccion.n_estado',
                                'ID_CONDICION'=>'SdFlujoTransaccion.condicion',
                                'CONDICION'=>'SdFlujoCondicion.nombre',
                                'ID_PREVENCION'=>'SdPrevencion.id',
                                'PREVENCION'=>'SdPrevencion.descripcion'
                                ))
                            ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoEstadoTransaccion')
                            ->innerJoin('SdFlujoEstado', "SdFlujoEstado.id = SdFlujoEstadoTransaccion.id_estado", 'SdFlujoEstado')
                            ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                            ->innerJoin('SdFlujoEtapa', "SdFlujoEtapa.id = SdFlujoEtapaEstado.id_etapa", 'SdFlujoEtapa')
                            ->innerJoin('SdFlujoTransaccionAccion', "SdFlujoTransaccionAccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoTransaccionAccion')
                            ->innerJoin('SdFlujoAccion', "SdFlujoAccion.id = SdFlujoTransaccionAccion.id_accion", 'SdFlujoAccion')
                            ->leftJoin('SdFlujoCondicion', "SdFlujoCondicion.id = SdFlujoTransaccion.condicion", 'SdFlujoCondicion')
                            ->leftJoin('SdPrevencion', "SdPrevencion.id = SdFlujoTransaccion.id_prevencion", 'SdPrevencion')
                            ->innerJoin('SdFlujoEstado', "FlujoEstado2.id = SdFlujoAccion.n_estado_id", 'FlujoEstado2')
                            ->conditions("SdFlujoEtapa.id=:id: AND SdFlujoTransaccion.estatus=:estatus: AND SdFlujoAccion.tipo=:tipo:") //AND SdFlujoTransaccion.formulario <> 1
                            ->bind(['id' => $id, 'estatus'=>'AC','tipo'=>'INSERT'])
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
     *  Realiza la búsqueda de los registros
     *  Retorna array en formato json con todos los registros
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
                    $opt = $this->request->get('opt', null, 0);
                    $id = $this->request->get('id', null, 0);
                    $registros = array();

                    switch ($opt) {
                        case 0:
                            //hacemos la búsqueda de las etapas
                            $registros = $funcion->obtenerEtapas($id);
                            break;

                        case 1:
                            //hacemos la búsqueda de los estados
                            $registros = SdFlujoEstado::query()
                                ->columns(array("id" => "SdFlujoEstado.id", "nombre" => "SdFlujoEstado.nombre",  "descripcion" => "SdFlujoEstado.descripcion"))
                                ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.estado_id = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                ->conditions("SdFlujoEstado.estatus=:estatus: AND SdFlujoEtapaEstado.etapa_id=:etapa_id:")
                                ->bind(['estatus'=>'AC', 'etapa_id'=>$id])
                                ->execute();;
                            break;

                        case 2:
                            //hacemos la búsqueda de los estados de la etapa actual
                            $registros = SdFlujoEstado::query()
                                ->columns(array("id" => "SdFlujoEstado.id", "nombre" => "SdFlujoEstado.nombre",  "descripcion" => "SdFlujoEstado.descripcion"))
                                ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.estado_id = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                ->conditions("SdFlujoEstado.estatus=:estatus: AND SdFlujoEtapaEstado.etapa_id=:etapa_id:")
                                ->bind(['estatus'=>'AC', 'etapa_id'=>$id])
                                ->execute();;
                            break;

                        case 3:
                            //hacemos la búsqueda de los roles para las tracciones
                            $registros = SdFlujoTransaccionRol::query()
                                ->columns(array("ID" => "SdRol.id", "NOMBRE" => "SdRol.nombre",  "DESCRIPCION" => "SdRol.descripcion"))
                                ->innerJoin('SdRol', "SdRol.id = SdFlujoTransaccionRol.id_rol", 'SdRol')
                                ->conditions("SdFlujoTransaccionRol.estatus=:estatus: AND SdFlujoTransaccionRol.id_transaccion=:id_transaccion:")
                                ->bind(['estatus'=>'AC', 'id_transaccion'=>$id])
                                ->execute();;
                            break;

                        case 4:
                            //Hacemos la búsqueda de la relación entre etapa y sus transacciones
                            $etapas= [];
                            $transacciones = [];
                            $condiciones = [];

                          $flujoTransacciones = SdFlujoTransaccion::query()
                                ->columns(array( 'ID_ETAPA'=>'SdFlujoEtapa.id','ID_N_ETAPA'=>'SdFlujoAccion.n_etapa_id', 'NOMBRE'=>'SdFlujoTransaccion.nombre'))
                                ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoEstadoTransaccion')
                                ->innerJoin('SdFlujoEstado', "SdFlujoEstado.id = SdFlujoEstadoTransaccion.id_estado", 'SdFlujoEstado')
                                ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                ->innerJoin('SdFlujoEtapa', "SdFlujoEtapa.id = SdFlujoEtapaEstado.id_etapa", 'SdFlujoEtapa')
                                ->innerJoin('SdFlujoTransaccionAccion', "SdFlujoTransaccionAccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoTransaccionAccion')
                                ->innerJoin('SdFlujoAccion', "SdFlujoAccion.id = SdFlujoTransaccionAccion.id_accion", 'SdFlujoAccion')
                                ->conditions("SdFlujoTransaccion.id_flujo=:id_flujo: AND SdFlujoAccion.n_etapa_id IS NOT NULL 
                                 AND SdFlujoTransaccion.estatus=:estatus: AND SdFlujoEtapa.estatus=:estatus:")
                                ->bind(['id_flujo' => $id, 'estatus' => 'AC'])
                                ->groupBy("SdFlujoEtapa.id, SdFlujoAccion.n_etapa_id, SdFlujoTransaccion.nombre ")
                                ->execute();

                            foreach ($flujoTransacciones as $transaccion) {
                                $transacciones[] = ["T1"=>$transaccion->ID_ETAPA, "T2"=>$transaccion->ID_N_ETAPA, "nombre"=>$transaccion->NOMBRE];
                            }

                            $etapaPrincipal = SdFlujoEtapa::find([
                                'columns' =>  array('ID' => 'id', 'NOMBRE' =>'nombre', 'DESCRIPCION' =>'descripcion', 'COLOR' =>'color','IZQUIERDA' => 'izquierda','ALTURA' => 'altura'),
                                'conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus: AND principal=:principal:',
                                'bind' => ['id_flujo' => (int)$id, 'estatus' => 'AC', 'principal' => 1]
                            ]);

                            $flujoEtapa = SdFlujoEtapa::find([
                                'columns' =>  array('ID' => 'id', 'NOMBRE' =>'nombre', 'DESCRIPCION' =>'descripcion', 'COLOR' =>'color','PRINCIPAL' => 'principal' ,'IZQUIERDA' => 'izquierda','ALTURA' => 'altura'),
                                'conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus: AND condicion=0',
                                'bind' => ['id_flujo' => (int)$id, 'estatus' => 'AC']
                            ]);
                            foreach ($flujoEtapa As $etapa){
                                $etapas[] = [$etapa->ID, $etapa->NOMBRE, $etapa->COLOR, $etapa->IZQUIERDA, $etapa->ALTURA];
                            }
                            $condicionEtapas = SdFlujoEtapa::find([
                                'columns' =>  array('ID' => 'id', 'NOMBRE' =>'nombre', 'DESCRIPCION' =>'descripcion', 'COLOR' =>'color','PRINCIPAL' => 'principal','IZQUIERDA' => 'izquierda','ALTURA' => 'altura'),
                                'conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus: AND condicion=1',
                                'bind' => ['id_flujo' => (int)$id, 'estatus' => 'AC']
                            ]);
                            if($condicionEtapas){
                                foreach ($condicionEtapas As $condicion){
                                    $condiciones[] = [$condicion->ID, $condicion->NOMBRE, $condicion->COLOR, $condicion->IZQUIERDA, $condicion->ALTURA];
                                }
                            }

                            $registros = [ $etapas, $transacciones, $etapaPrincipal, $condiciones];
                            break;
                        case 5:
                            $registros = SdFlujoCondicion::find([
                                'columns' => array('ID' => 'id', 'NOMBRE' =>'nombre', 'DESCRIPCION' =>'descripcion'),
                                'conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus:',
                                'bind' => ['id_flujo' => (int)$id, 'estatus' => 'AC']
                            ]);
                            break;
                        case 6:
                            //Búsqueda de las respuestas de prevencion
                            $registros = SdPrevencion::find([
                                'columns' => array('ID' => 'id', 'NOMBRE' =>'nombre', 'DESCRIPCION' =>'descripcion'),
                                'conditions' => "estatus='AC'"]);
                            break;
                    }
                    if($registros){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $registros]; //se debe enviar los recursos
                    }else{
                        $this->mensaje = ['danger', 'No hay registros disponibles.', null];
                    }
                }catch (\Exception $e) {
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los registros.', null];
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
}
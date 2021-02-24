<?php

use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class SolicitudesController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Solicitudes');
        parent::initialize();
    }

    /** Muestra la vista de todas las solicitudes por estatus y tipo */
    public function indexAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);

        //Declaración de variables
        $opt = $this->request->get('opt', null, 0);
        $id = $this->request->get('id', null, 0);
        $tipo = $this->request->get('tipo', null, '');
        $folio = $this->request->get('folio', null, 0);
        $antecedente = '';

        if(!empty($id)){
            $historial =  SdSolicitudHistorial::find([
                'conditions' => "id_solicitud=:id_solicitud:",
                'bind' => ['id_solicitud' => $id],
            ])->getLast();

            $this->view->id_etapa = $historial->id_etapa;
            //obtenemos la solicitud
            $solicitud = SdSolicitud::findFirst($id);
            //obtenemos el antecedente de la solicitud
            $antecedente = $solicitud->antecedente;
        }

        if(empty($folio) && empty($id) ){
            $solicitud = SdSolicitud::findFirst(['order'     => 'id_solicitud desc']);
            $folio = 'SD' . ($solicitud->id_solicitud + 1);
        }else{
            $folio = 'SD' .$id;
        }

        $this->view->id = $id;
        $this->view->folio = $folio;
        $this->view->tipo = strtoupper($tipo);
        $this->view->antecedente = $antecedente;

        switch ($opt) {
            case 0:
                //Muestra la vista de la tabla con todas las solicitudes
                $this->view->pick('solicitudes/index');
                break;
            case 1:
                //muestra la vista de registro de solicitudes
                $this->view->pick('solicitudes/registro/' .  strtolower($tipo));
                break;
            case 2:
                //muestra la vista de las solicitudes turnadas a la dependencia
                $this->view->pick('solicitudes/solicitudes');
                break;
        }
    }

    /** Muestra el modal dependiendo la opción seleccionada*/
    public function modalAction(){
        //obtenemos la opción del modal a mostrar
        $opt = $this->request->get('opt', null, 0);
        //variables necesarias para el formulario
        $this->view->numrow = $this->request->get('NUMROW', null, '');
        $this->view->fecha_i = $this->request->get('FECHA_I', null, '');
        $this->view->folio = $this->request->get('FOLIO', null, '');
        $this->view->id_solicitud = $this->request->get('ID_SOLICITUD', null, '');
        $this->view->id_pregunta = $this->request->get('ID_PREGUNTA', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
        $this->view->observaciones = $this->request->get('OBSERVACIONES', null, '');
        $this->view->antecedente = $this->request->get('ANTECEDENTE', null, '');
        $this->view->consentimiento = $this->request->get('CONSENTIMIENTO', null, '');
        $this->view->comentarios = $this->request->get('comentarios', null, '');

        switch ($opt) {
            case 0:
                //Muestra la vista del modal para agregar preguntas
                $this->view->pick('solicitudes/modal/pregunta');
                break;

            case 1:
                //Mustra la vista para editar la prevencion
                $this->view->pick('solicitudes/modal/editar');
                break;

            case 2:
                //Muestra el modal para mostrar la pregunta y sus dependencias
                $this->view->pick('solicitudes/modal/perfil');
                break;

            case 3:
                //muestra la vista del modal para el turnado
                $this->view->pick('solicitudes/modal/turnado');
                break;

            case 6:
                // Modal para turnar las preguntas a las dependencias
                $this->view->pick('solicitudes/modal/preguntas');
                break;

            case 7:
                // Modal para turnar las preguntas a las dependencias
                $this->view->pick('solicitudes/modal/analisis');
                break;

            case 8:
                // Modal para ver el documento de prevencion
                $this->view->pick('solicitudes/modal/prevencion');
                break;

            case 9:
                // Modal para ver el documento de prevencion
                $this->view->pick('solicitudes/modal/preguntas');
                break;

            case 10:
                // Modal para ver el historial de comentarios
                $this->view->pick('solicitudes/modal/comentarios');
                break;
        }
    }

    /** Obtiene la vista para el perfil de la solicitud */
    public function perfilAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $funcion = new Funciones();

        $idSolicitud = $this->request->get('id', null, 0);
        $solicitud = SdSolicitud::findFirst([
            'columns' => array('FOLIO' => "folio",'FECHA_I'=>"to_char(fecha_i,'DD/MM/YYYY')", 'ANTECEDENTE'=>'antecedente'),
            'conditions' => 'id_solicitud=:id_solicitud: AND estatus=:estatus:',
            'bind' => ['id_solicitud' =>$idSolicitud, 'estatus'=>'AC']
        ]);

        $solicitudes = SdSolicitud::query()
            ->columns(array('ID_SOLICITUD' => "SdSolicitud.id_solicitud", 'FOLIO' => 'SdSolicitud.folio', 'ID_SOLICITANTE' => 'SdSolicitante.id_solicitante',
                'FECHA_I' => "to_char(SdSolicitud.fecha_i,'DD/MM/YYYY')", 'TIPO' => 'SdSolicitudTipo.tipo', 'MEDIO' => 'SdMedioRegistro.medio',
                'NOMBRE_REPRESENTANTE' => 'SdRepresentante.nombre', 'APELLIDO_P_REPRESENTANTE' => 'SdRepresentante.apellido_paterno', 'ID_TITULAR' => 'SdSolicitud.id_titular',
                'APELLIDO_M_REPRESENTANTE' => 'SdRepresentante.apellido_materno','ESTATUS' => 'SdSolicitud.estatus'))
            ->innerJoin('SdSolicitudTipo', "SdSolicitudTipo.id_tipo = SdSolicitud.id_tipo", 'SdSolicitudTipo')
            ->innerJoin('SdMedioRegistro', "SdMedioRegistro.id_medio_registro = SdSolicitud.id_medio_registro", 'SdMedioRegistro')
            ->innerJoin('SdSolicitudSolicitante', "SdSolicitudSolicitante.id_solicitud = SdSolicitud.id_solicitud", 'SdSolicitudSolicitante')
            ->leftJoin('SdRepresentante', "SdRepresentante.id_representante = SdSolicitud.id_representante", 'SdRepresentante')
            ->innerJoin('SdSolicitante', "SdSolicitante.id_solicitante = SdSolicitudSolicitante.id_solicitante", 'SdSolicitante')
            ->conditions('SdSolicitud.id_solicitud=:id_solicitud: AND SdSolicitud.estatus=:estatus: ')
            ->bind(['id_solicitud' => $idSolicitud, 'estatus' => 'AC'])
            ->execute();

        $titular = SdTitular::findFirst($solicitudes[0]->ID_TITULAR);

        $sdSolicitante = SdSolicitante::query()
            ->columns(array('ID_SOLICITANTE' => "SdSolicitante.id_solicitante", 'ID_SOLICITUD' => 'SdSolicitud.id_solicitud',
                'NOMBRE' => 'SdSolicitante.nombre', 'APELLIDO_PATERNO' => 'SdSolicitante.apellido_paterno', 'CORREO' => 'SdSolicitante.correo',
                'APELLIDO_MATERNO' => 'SdSolicitante.apellido_materno', 'TELEFONO_FIJO' => 'SdSolicitante.telefono_fijo', 'RAZON_SOCIAL' => 'SdSolicitante.razon_social',
                'NOMBRE_PERSONA_A' => 'SdSolicitante.nombre_persona_a', 'APELLIDO_P_PERSONA_A' => 'SdSolicitante.apellido_p_persona_a',
                'APELLIDO_M_PERSONA_A' => 'SdSolicitante.apellido_m_persona_a', 'ESTADO' => 'SdEstados.estado', 'MUNICIPIO' => 'SdMunicipios.municipio',
                'DOMICILIO' => 'SdSolicitante.domicilio', 'ENTRE_CALLES' => 'SdSolicitante.entre_calles', 'COLONIA' => 'SdSolicitante.colonia',
                'OTRA_REFERENCIA' => 'SdSolicitante.otra_referencia', 'CODIGO_POSTAL' => 'SdSolicitante.codigo_postal', 'TIPO' => 'SdSolicitudTipo.tipo',
                'ANONIMO' => 'SdSolicitante.anonimo', 'SEUDONIMO' => 'SdSolicitante.seudonimo', 'TELEFONO_CELULAR' => 'SdSolicitante.telefono_celular',
                'FOLIO' => 'SdSolicitud.folio', 'ESTATUS' => 'SdSolicitante.estatus'))
            ->join('SdSolicitudSolicitante', "SdSolicitudSolicitante.id_solicitante = SdSolicitante.id_solicitante", 'SdSolicitudSolicitante', 'INNER')
            ->join('SdSolicitud', "SdSolicitud.id_solicitud = SdSolicitudSolicitante.id_solicitud", 'SdSolicitud', 'INNER')
            ->leftJoin('SdEstados', "SdEstados.id_estado = SdSolicitante.estado", 'SdEstados')
            ->leftJoin('SdMunicipios', "SdMunicipios.id_municipio = SdSolicitante.municipio", 'SdMunicipios')
            ->join('SdSolicitudTipo', "SdSolicitudTipo.id_tipo = SdSolicitud.id_tipo", 'SdSolicitudTipo', 'INNER')
            ->conditions('SdSolicitud.id_solicitud=:id_solicitud: AND SdSolicitud.estatus=:estatus:')
            ->bind(['id_solicitud' => $idSolicitud, 'estatus' => 'AC'])
            ->execute();

        $this->view->id_solicitud = $idSolicitud;
        $this->view->solicitud = $solicitud;
        $this->view->solicitudes = $solicitudes->getFirst();
        $this->view->solicitante = $sdSolicitante->getFirst();
        $this->view->titular = $titular;
        $catalogo = $funcion->getCatalogo($idSolicitud);
        $this->view->tema = (!empty($catalogo->TEMA)) ? $catalogo->TEMA : 'Sin especificar.';
        $this->view->subtema = (!empty($catalogo->SUBTEMA)) ? $catalogo->SUBTEMA : 'Sin especificar.';
        $this->view->titulo = (!empty($catalogo->TITULO)) ? $catalogo->TITULO : 'Sin especificar.';
        $this->view->folio = $solicitud->folio;
        $this->view->fecha_i = $solicitud->fecha_i;
    }

    /**
     *  Función para guardar registros
     *  @author Dora Nely Vega González
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

                    switch ($opt) {
                        case 0:
                            //Hacemos el registro de la solicitud para obtener folio
                            $tipo = $this->request->get('tipo', null, 0); // Se obtiene el tipo de Solicitud que se desea registrar
                            $folio_externo = $this->request->get('folio_externo', null, 0);
                            $idMedio = $funcion->getMedioRegistro('SAIDA'); // Se obtiene el medio de registro de saida
                            $idTipo = $funcion->getTipo($tipo); // Se obtiene el tipo SAI para solicitudes de acceso a la información publica
                            $idFlujo = $funcion->obtenerFlujo($idTipo);

                            $flag =  true;
                            //nombre del solicitante
                            $nombre = $this->request->getPost('txtNombre', null, '');
                            $apellidoP = $this->request->getPost('txtApellidoP', null, '');
                            $apellidoM = $this->request->getPost('txtApellidoM', null, '');
                            //nombre del representante
                            $nombreR = $this->request->getPost('txtNombreR', null, '');
                            $apellidoPR = $this->request->getPost('txtApellidoPR', null, '');
                            $apellidoMR = $this->request->getPost('txtApellidoMR', null, '');
                            $acreditacionResponsable = $this->request->getPost('acreditacionResponsable', null, '');
                            $representante = $this->request->getPost('representante', null, '');
                            //datos de la persona autorizada
                            $nombrePA = $this->request->getPost('txtNombrePA', null, '');
                            $apellidoPPA = $this->request->getPost('txtApellidoPPA', null, '');
                            $apellidoMPA = $this->request->getPost('txtApellidoMPA', null, '');
                            //datos del titular de la solicitud
                            $nombreT = $this->request->getPost('txtNombreT', null, '');
                            $apellidoPaternoT = $this->request->getPost('txtApellidoPT', null, '');
                            $apellidoMaternoT = $this->request->getPost('txtApellidoMT', null, '');
                            $fechaNacimiento= $this->request->getPost('txtFechaNacimiento', null, '');
                            $vive = $this->request->getPost('rdVive', null, '');
                            $acreditacionTitular = $this->request->getPost('acreditacionTitular', null, '');
                            //cuando el solicitante es anonimo o tiene un seudonimo
                            $seudonimo = $this->request->getPost('txtSeudonimo', null, '');
                            $anonimo = $this->request->getPost('anonimo', null, '');
                            //datos de contacto
                            $correo = $this->request->getPost('txtCorreo', null, '');
                            $telFijo = $this->request->getPost('txtTelefonoFijo', null, '');
                            $telCelular = $this->request->getPost('txtTelefonoCel', null, '');
                            $domicilio = $this->request->getPost('txtDireccion', null, '');
                            $entre_calles = $this->request->getPost('txtEntreCalles', null, '');
                            $otra_referencia = $this->request->getPost('txtOtraReferencia', null, '');
                            $colonia = $this->request->getPost('txtColonia', null, '');
                            $estado = $this->request->getPost('slEstado', null, 0);
                            $municipio = $this->request->getPost('slMunicipio', null, 0);
                            $codigo_postal = $this->request->getPost('txtCodigoP', null, 0);
                            // persona moral
                            $razonSocial = $this->request->getPost('txtRazonSocial', null, '');
                            $otro= $this->request->getPost('txtOtro', null, "");
                            //Consentimiento para mostrar datos del solicitante a las dependencias
                            $consentimiento = $this->request->getPost('consentimiento', null, '');

                            if($idFlujo != 0){
                                if($idMedio && $idTipo ) {
                                    $secuencia = $this->db->query('SELECT SD_SOLICITUD_SEQ.nextval FROM dual');
                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                    $secuencia = $secuencia->fetchAll($secuencia);

                                    $sdSolicitud = new SdSolicitud();
                                    $sdSolicitud->id_solicitud = $secuencia[0]['NEXTVAL'];
                                    $sdSolicitud->folio = 'SD' . $secuencia[0]['NEXTVAL'];
                                    //En caso de que la solicitud venga de otro sistema
                                    if($folio_externo){
                                        $sdSolicitud->folio_externo = $folio_externo;
                                    }
                                    $sdSolicitud->id_medio_registro = $idMedio;
                                    $sdSolicitud->id_tipo = $idTipo;
                                    $sdSolicitud->id_flujo = $idFlujo;
                                    $sdSolicitud->consentimiento = $consentimiento;
                                    $sdSolicitud->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                    $sdSolicitud->fecha_i = new \Phalcon\Db\RawValue('default');
                                    $sdSolicitud->estatus = 'AC';

                                    if ($sdSolicitud) {
                                        if ($sdSolicitud->save()) {

                                            if(!empty($correo)){
                                                //Hacemos la búsqueda del solicitante en caso de que ya haya registrado una solicitud
                                                $sdSolicitante = SdSolicitante::findFirst([
                                                    'conditions' => 'correo=:correo: AND estatus=:estatus:',
                                                    'bind' => ['correo' => trim($correo), 'estatus'=>'AC']
                                                ]);
                                            }
                                            if(empty($sdSolicitante)){
                                                $secuencia = $this->db->query('SELECT SD_SOLICITANTE_SEQ.nextval FROM dual');
                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                //Agregamos el solicitante
                                                $sdSolicitante = new SdSolicitante();
                                                $sdSolicitante->id_solicitante = $secuencia[0]['NEXTVAL'];
                                                $sdSolicitante->nombre_persona_a = $nombrePA;
                                                $sdSolicitante->apellido_p_persona_a = $apellidoPPA;
                                                $sdSolicitante->apellido_m_persona_a = $apellidoMPA;

                                                //validamos si el solicitante es anonimo ó tiene un seudonimo
                                                if(empty($anonimo)){
                                                    if(!empty($seudonimo)){
                                                        $sdSolicitante->seudonimo = $seudonimo;
                                                    }else{
                                                        $sdSolicitante->nombre = $nombre;
                                                        $sdSolicitante->apellido_paterno = $apellidoP;
                                                        $sdSolicitante->apellido_materno = $apellidoM;
                                                        $sdSolicitante->razon_social = $razonSocial;
                                                    }
                                                    $sdSolicitante->telefono_fijo = $telFijo;
                                                    $sdSolicitante->telefono_celular = $telCelular;
                                                    $sdSolicitante->correo = $correo;
                                                    $sdSolicitante->domicilio = $domicilio;
                                                    $sdSolicitante->entre_calles = $entre_calles;
                                                    $sdSolicitante->otra_referencia = $otra_referencia;
                                                    $sdSolicitante->colonia = $colonia;
                                                    $sdSolicitante->codigo_postal = $codigo_postal;
                                                }else{
                                                    $sdSolicitante->anonimo = 'SI';
                                                }
                                                if($nombrePA && $apellidoPPA && $apellidoMPA){
                                                    $sdSolicitante->nombre_persona_a = $nombrePA;
                                                    $sdSolicitante->apellido_p_persona_a = $apellidoPPA;
                                                    $sdSolicitante->apellido_m_persona_a = $apellidoMPA;
                                                }
                                                if($estado && $municipio){
                                                    //obtiene el estado
                                                    $estados = SdEstados::findFirst((int)$estado);
                                                    //obtiene el municipio
                                                    $municipios = SdMunicipios::findFirst((int)$municipio);

                                                    if($estados && $municipios) {
                                                        $sdSolicitante->estado = $estados->id_estado;
                                                        $sdSolicitante->municipio = $municipios->id_municipio;
                                                    }
                                                }
                                                $sdSolicitante->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                $sdSolicitante->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                $sdSolicitante->estatus = 'AC';

                                                if (!$sdSolicitante->save()) {
                                                    foreach ($sdSolicitante->getMessages() as $message) {
                                                        $this->msnError .= $message->getMessage() . "<br/>";
                                                    }
                                                    $this->logger->error($this->msnError);
                                                    $flag = false;
                                                }
                                            }

                                            //agregamos al titular en caso de ser requerido
                                            if(!empty($nombreT) & !empty($apellidoPaternoT) & !empty($apellidoMaternoT) & !empty($fechaNacimiento) & !empty($vive)) {
                                                $secuencia = $this->db->query('SELECT SD_TITULAR_SEQ.nextval FROM dual');
                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                $sdTitular = new SdTitular();
                                                $sdTitular->id_titular = $secuencia[0]['NEXTVAL'];
                                                $sdTitular->nombre = $nombreT;
                                                $sdTitular->apellido_paterno = $apellidoPaternoT;
                                                $sdTitular->apellido_materno = $apellidoMaternoT;
                                                $sdTitular->fecha_nacimiento =  new \Phalcon\Db\RawValue('TO_DATE(\'' . $fechaNacimiento . '\', \'dd/mm/yyyy\')');
                                                $sdTitular->vive = $vive;
                                                $sdTitular->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                $sdTitular->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                $sdTitular->estatus = 'AC';

                                                if ($sdTitular) {
                                                    if ($sdTitular->save()) {
                                                        if (!empty($otro)) {
                                                            $secuencia = $this->db->query('SELECT SD_ACREDITACION_IDENTIDAD_SEQ.nextval FROM dual');
                                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                            $secuencia = $secuencia->fetchAll($secuencia);

                                                            $sdAcIdentidad = new SdAcreditacionIdentidad();
                                                            $sdAcIdentidad->id_documento = $secuencia[0]['NEXTVAL'];
                                                            $sdAcIdentidad->descripcion = $otro;
                                                            $sdAcIdentidad->estatus_titular = 'OTRO';
                                                            $sdAcIdentidad->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                            $sdAcIdentidad->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                            $sdAcIdentidad->estatus = 'AC';

                                                            if ($sdAcIdentidad) {
                                                                if ($sdAcIdentidad->save()) {
                                                                    $secuencia = $this->db->query('SELECT SD_ACREDITACION_TITULAR_SEQ.nextval FROM dual');
                                                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                    $secuencia = $secuencia->fetchAll($secuencia);

                                                                    $sdAcreditacionTitular = new SdAcreditacionTitular();
                                                                    $sdAcreditacionTitular->id_acreditacion = $secuencia[0]['NEXTVAL'];
                                                                    $sdAcreditacionTitular->id_documento = $sdAcIdentidad->id_documento;
                                                                    $sdAcreditacionTitular->id_titular = $sdTitular->id_titular;
                                                                    $sdAcreditacionTitular->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                                    $sdAcreditacionTitular->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                    $sdAcreditacionTitular->estatus = 'AC';
                                                                    if (!$sdAcreditacionTitular->save()) {
                                                                        $flag =  false;
                                                                    }
                                                                } else {
                                                                    $flag =  false;
                                                                }
                                                            }
                                                        }
                                                        if (!empty($acreditacionTitular)) {
                                                            foreach ($acreditacionTitular as $documento) {
                                                                $secuencia = $this->db->query('SELECT SD_ACREDITACION_TITULAR_SEQ.nextval FROM dual');
                                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                                $sdAcreditacionTitular = new SdAcreditacionTitular();
                                                                $sdAcreditacionTitular->id_acreditacion = $secuencia[0]['NEXTVAL'];
                                                                $sdAcreditacionTitular->id_documento = $documento;
                                                                $sdAcreditacionTitular->id_titular = $sdTitular->id_titular;
                                                                $sdAcreditacionTitular->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                                $sdAcreditacionTitular->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                $sdAcreditacionTitular->estatus = 'AC';
                                                                if (!$sdAcreditacionTitular->save()) {
                                                                    $flag =  false;
                                                                }
                                                            }
                                                        }
                                                        $sdSolicitud->id_titular =  $sdTitular->id_titular;
                                                    }else {
                                                        $flag =  false;
                                                    }
                                                }
                                            }

                                            //agregamos el representante legal en caso de ser requerido
                                            if(!empty($nombreR) & !empty($apellidoMR) & !empty($apellidoPR)){
                                                //seleccionamos el número de secuencia
                                                $secuencia = $this->db->query('SELECT SD_REPRESENTANTE_SEQ.nextval FROM dual');
                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                $sdRepresentante= new SdRepresentante();
                                                $sdRepresentante->id_representante = $secuencia[0]['NEXTVAL'];
                                                $sdRepresentante->nombre = $nombreR;
                                                $sdRepresentante->apellido_paterno = $apellidoPR;
                                                $sdRepresentante->apellido_materno = $apellidoMR;
                                                if($representante){
                                                    $sdRepresentante->se_acredita = $representante;
                                                }
                                                $sdRepresentante->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                $sdRepresentante->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                $sdRepresentante->estatus = 'AC';

                                                if ($sdRepresentante) {
                                                    if ($sdRepresentante->save()) {
                                                        if(!empty($acreditacionResponsable)){
                                                            foreach ($acreditacionResponsable as $documento){
                                                                //seleccionamos el documento a acreditar
                                                                $sdAcreditacionIdentidad = SdAcreditacionIdentidad::findFirst((int)$documento);

                                                                $secuencia = $this->db->query('SELECT SD_ACREDITACION_REPRESENTA_SEQ.nextval FROM dual');
                                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                                $sdAcreditacionRepresentante= new SdAcreditacionRepresentante();
                                                                $sdAcreditacionRepresentante->id_acreditacion = $secuencia[0]['NEXTVAL'];
                                                                $sdAcreditacionRepresentante->id_representante =  $sdRepresentante->id_representante;
                                                                $sdAcreditacionRepresentante->id_documento = $sdAcreditacionIdentidad->id_documento;
                                                                $sdAcreditacionRepresentante->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                                $sdAcreditacionRepresentante->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                $sdAcreditacionRepresentante->estatus = 'AC';

                                                                if ($sdAcreditacionRepresentante) {
                                                                    if (!$sdAcreditacionRepresentante->save()) {
                                                                        $flag =  false;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        $sdSolicitud->id_representante =  $sdRepresentante->id_representante;
                                                    }else{
                                                        $flag =  false;
                                                    }
                                                }
                                            }

                                            if ($sdSolicitante) {
                                                $sdSoliSolicitante = new SdSolicitudSolicitante();
                                                $sdSoliSolicitante->id_solicitante = $sdSolicitante->id_solicitante;
                                                $sdSoliSolicitante->id_solicitud = $sdSolicitud->id_solicitud;
                                                $sdSoliSolicitante->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                $sdSoliSolicitante->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                $sdSoliSolicitante->estatus = 'AC';
                                                if($flag){
                                                    if ($sdSoliSolicitante->save()) {
                                                        if ($sdSolicitud->save()) {
                                                            $this->mensaje = ['success', 'Se guardaron correctamente la solicitud.', $sdSolicitud->id_solicitud ];//se hace el envio de la solicitud para seguir con el formulario
                                                        } else {
                                                            foreach ($sdSolicitud->getMessages() as $message) {
                                                                $this->msnError .= $message->getMessage() . "<br/>";
                                                            }
                                                            $this->logger->error($this->msnError);
                                                            $this->mensaje = ['danger', 'Ocurrio un error al agregar la solicitud: '. $this->msnErro, null];
                                                        }
                                                    } else {
                                                        foreach ($sdSoliSolicitante->getMessages() as $message) {
                                                            $this->msnError .= $message->getMessage() . "<br/>";
                                                        }
                                                        $this->logger->error($this->msnError);
                                                        $this->mensaje = ['danger', 'Ocurrio un error al agregar el solicitante: '. $this->msnErro, null];
                                                    }
                                                }
                                            }else {
                                                $this->mensaje = ['warning', 'El solicitante seleccionado no se encuentra en el sistema.', null];
                                            }

                                        } else {
                                            foreach ($sdSolicitud->getMessages() as $message) {
                                                $this->msnError .= $message->getMessage() . "<br/>";
                                            }
                                            $this->logger->error($this->msnError);
                                            $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos: ' .$this->msnError, null];
                                        }
                                    }
                                }else {
                                    $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                                }
                            }else {
                                $this->mensaje = ['warning', 'El flujo no esta aprobado, por favor revisarlo.', null];
                            }


                            break;
                        case 1:
                            //Guarda la relación de catálogo por socilitud
                            $idSolicitud = $this->request->getPost('txtIdSolicitud', null, 0);
                            $idTema = $this->request->getPost('slTema', null, 0);
                            $idSubtema = $this->request->getPost('slSubtema', null, 0);
                            $idTitulo = $this->request->getPost('slTitulo', null, 0);
                            $antecedente = $this->request->getPost('txtAntecedentes', null, 0);
                            $observaciones = $this->request->getPost('txtObservaciones', null, 0);
                            $peticion = $this->request->getPost('txtPeticion', null, 0);
                            $medios = $this->request->getPost('medios');
                            //Registra el derecho arco a ejercer en la solicitud
                            $derecho =  $this->request->getPost('idDerechoArco', null, '');
                            $dependencias = $this->request->getPost('slDependencias', null,'');
                            $comentario = $this->request->getPost('txtComentario', null,'');
                            $respuesta = true;

                            if( !empty($idSolicitud)){
                                //obtenemos la solicitud en base al id_solicitud
                                $sdSolicitud = SdSolicitud::findFirst($idSolicitud);

                                if($sdSolicitud){
                                    //Registramos el antecedente
                                    if ($antecedente) {
                                        $sdSolicitud->antecedente = $antecedente;
                                        $sdSolicitud->usuario_u = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                        $sdSolicitud->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                                        if (!$sdSolicitud->save()) {
                                            $respuesta = false;
                                        }
                                    }
                                    //Registramos la peticion del solicitante
                                    if(!empty($peticion)) {
                                        $idEstatus = $funcion->getEstatusPregunta('RECIBIDA');
                                        $secuencia = $this->db->query('SELECT SD_PREGUNTA_SEQ.nextval FROM dual');
                                        $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                        $secuencia = $secuencia->fetchAll($secuencia);

                                        $sdPregunta = new SdPregunta();
                                        $sdPregunta->id_pregunta =  $secuencia[0]['NEXTVAL'];
                                        $sdPregunta->id_solicitud = $sdSolicitud->id_solicitud;
                                        $sdPregunta->descripcion = $peticion;
                                        if($observaciones){
                                            $sdPregunta->observaciones = $observaciones;
                                        }
                                        $sdPregunta->id_estatus = $idEstatus;
                                        $sdPregunta->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                        $sdPregunta->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $sdPregunta->estatus = 'AC';

                                        if ($sdPregunta) {
                                            if (!$sdPregunta->save()) {
                                                $respuesta = false;
                                            }
                                        }
                                    }
                                    //Registramos los medios de respuesta
                                    if(!empty($medios)) {
                                        foreach($medios as $medio){
                                            //obtenemos el medio de respuesta
                                            $sdMedioRespuesta = SdMedioRespuesta::findFirst((int)$medio['ID_MEDIO_RESPUESTA']);

                                            $secuencia = $this->db->query('SELECT SD_SOLICITUD_MEDIO_SEQ.nextval FROM dual');
                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                            $secuencia = $secuencia->fetchAll($secuencia);

                                            $sdSolicitudMedio = new SdSolicitudMedio();
                                            $sdSolicitudMedio->id = $secuencia[0]['NEXTVAL'];
                                            $sdSolicitudMedio->id_solicitud = $sdSolicitud->id_solicitud;
                                            $sdSolicitudMedio->id_medio_respuesta = $sdMedioRespuesta->id_medio_respuesta;
                                            $sdSolicitudMedio->cantidad = $medio['CANTIDAD'];
                                            $sdSolicitudMedio->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                            $sdSolicitudMedio->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                            $sdSolicitudMedio->estatus = 'AC';
                                            if ($sdSolicitudMedio) {
                                                if (!$sdSolicitudMedio->save()) {
                                                    $respuesta = false;
                                                }
                                            }
                                        }
                                    }

                                    //Registramos el catalogo
                                    if(!empty($idTema) && !empty($idSubtema)) {
                                        //obtenemos el tema en base al id_tema
                                        $sdTema = SdTema::findFirst((int)$idTema);
                                        //obtenemos el subtema en base al id_subtema
                                        $sdSubtema = SdSubtema::findFirst((int)$idSubtema);

                                        $secuencia = $this->db->query('SELECT SD_SOLICITUD_MEDIO_SEQ.nextval FROM dual');
                                        $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                        $secuencia = $secuencia->fetchAll($secuencia);

                                        //Generamos el catálogo relacionado a la solicitud
                                        $sdSolicitudCatalogo = new SdSolicitudCatalogo();

                                        $sdSolicitudCatalogo->id = $secuencia[0]['NEXTVAL'];

                                        if( !empty($idTitulo)){
                                            //obtenemos el título en base al id_titulo
                                            $sdTitulo = SdTitulo::findFirst((int)$idTitulo);

                                            if($sdTitulo){
                                                $sdSolicitudCatalogo->id_titulo = $sdTitulo->id_titulo;
                                            }
                                        }

                                        if(!empty($sdTema) && !empty($sdSubtema)){
                                            $sdSolicitudCatalogo->id_solicitud = $sdSolicitud->id_solicitud;
                                            $sdSolicitudCatalogo->id_tema = $sdTema->id_tema;
                                            $sdSolicitudCatalogo->id_subtema = $sdSubtema->id_subtema;
                                            $sdSolicitudCatalogo->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                            $sdSolicitudCatalogo->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                            $sdSolicitudCatalogo->estatus = 'AC';

                                            if ($sdSolicitudCatalogo) {
                                                if (!$sdSolicitudCatalogo->save()) {
                                                    $respuesta = false;
                                                }
                                            } else {
                                                $this->mensaje = ['warning', 'El catálogo seleccionado no se encuentra en el sistema.', null];
                                            }
                                        }else{
                                            $this->mensaje = ['danger', 'Ocurrio un error al seleccionar los datos del catálogo.', null];
                                        }
                                    }
                                    if(!empty($derecho)) {
                                        //hacemos la búsqueda del derecho arco
                                        $derechoArco = SdDerechosArco::findFirst((int)$derecho);

                                        if($derechoArco) {
                                            //actualizamos el id_derecho
                                            $sdSolicitud->id_derecho_arco = $derechoArco->id_derecho;

                                            if ($sdSolicitud->save()) {
                                                //Hacemos la búsqueda de las preguntas a turnar de la solicitud arco
                                                $preguntas = SdPregunta::find([
                                                    'conditions' => 'id_solicitud=:id_solicitud: and estatus=:estatus:',
                                                    'bind' => ['id_solicitud' => $idSolicitud, 'estatus'=>'AC']]);

                                                //Para cada una de las preguntas
                                                foreach ($preguntas AS $pregunta){
                                                    if($dependencias){
                                                        //Para cada una de las dependencias
                                                        foreach ($dependencias as $dependencia){
                                                            //hacemos la búsqueda de la dependencia
                                                            $phql = "SELECT DISTINCT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION
                                                              FROM XxhrPqHierarchyV 
                                                              WHERE flex_value_id = :flex_value_id:";

                                                            //validamos que sea la solicitud seleccionada
                                                            $sdDependencia  = $query = $this->modelsManager->executeQuery($phql, ["flex_value_id" => $dependencia]);
                                                            $sdDependencia=  $sdDependencia->getLast();

                                                            $sdPreguntaDependencia = new SdPreguntaDependencia();
                                                            $sdPreguntaDependencia->id_pregunta = $pregunta->id_pregunta;
                                                            $sdPreguntaDependencia->id_dependencia = $sdDependencia->FLEX_VALUE_ID;
                                                            $sdPreguntaDependencia->flex_value = $sdDependencia->FLEX_VALUE;
                                                            $sdPreguntaDependencia->dependencia = $sdDependencia->DESCRIPTION;
                                                            $sdPreguntaDependencia->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                            $sdPreguntaDependencia->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                            $sdPreguntaDependencia->estatus = 'AC';
                                                            if($sdPreguntaDependencia){
                                                                if (!$sdPreguntaDependencia->save()) {
                                                                    $flag = false;
                                                                }
                                                            }
                                                            if($comentario){
                                                                $secuencia = $this->db->query('SELECT SD_COMENTARIOS_PREGUNTA_SEQ.nextval FROM dual');
                                                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                                $secuencia = $secuencia->fetchAll($secuencia);

                                                                $sdComentariosPregunta = new SdPreguntaComentario();
                                                                $sdComentariosPregunta->id_comentario = $secuencia[0]['NEXTVAL'];
                                                                $sdComentariosPregunta->id_pregunta = $pregunta->id_pregunta;
                                                                $sdComentariosPregunta->id_dependencia = $sdDependencia->FLEX_VALUE_ID;
                                                                $sdComentariosPregunta->flex_value = $sdDependencia->FLEX_VALUE;
                                                                $sdComentariosPregunta->dependencia = $sdDependencia->DESCRIPTION;
                                                                $sdComentariosPregunta->comentario = $comentario;
                                                                $sdComentariosPregunta->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                                $sdComentariosPregunta->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                                $sdComentariosPregunta->estatus = 'AC';

                                                                if($sdComentariosPregunta){
                                                                    if (!$sdComentariosPregunta->save()) {
                                                                        $flag = false;
                                                                    }
                                                                }
                                                            }
                                                            //Hacemos la búsqueda de la solicitud
                                                            $solicitud = SdSolicitud::findFirst($sdPregunta->id_solicitud);

                                                            if($solicitud){
                                                                $solicitud->turnado = 1;
                                                                $solicitud->fecha_turnado = new \Phalcon\Db\RawValue('SYSDATE');
                                                                $solicitud->usuario_u = $this->session->usuario['usuario'];
                                                                $solicitud->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                                                                if (!$solicitud->save()) {
                                                                    $flag = false;
                                                                }
                                                            }

                                                            $secuencia = $this->db->query('SELECT SD_PREGUNTA_HISTORIAL_SEQ.nextval FROM dual');
                                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                                            $secuencia = $secuencia->fetchAll($secuencia);

                                                            $sdPreguntaHistorial = new SdPreguntaHistorial();
                                                            $sdPreguntaHistorial->id = $secuencia[0]['NEXTVAL'];
                                                            $sdPreguntaHistorial->id_pregunta = $pregunta->id_pregunta;
                                                            $sdPreguntaHistorial->mensaje = "Se realiza el turnado de la pregunta";
                                                            $sdPreguntaHistorial->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                                            $sdPreguntaHistorial->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                                            $sdPreguntaHistorial->estatus = 'AC';

                                                            if($sdPreguntaHistorial){
                                                                if (!$sdPreguntaHistorial->save()) {
                                                                    $flag = false;
                                                                }
                                                            }

                                                            //obtenemos la pregunta en base al id_pregunta
                                                            $sdPregunta = SdPregunta::findFirst((int)$pregunta->id_pregunta);
                                                            if($sdPregunta){
                                                                $sdPregunta->turnado = 1;
                                                                $sdPregunta->fecha_turnado = new \Phalcon\Db\RawValue('SYSDATE');
                                                                if (!$sdPregunta->save()) {
                                                                    $flag = false;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($flag) {
                                                    $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                                } else {
                                                    $this->mensaje = ['danger', 'Ocurrio un error al registrar la solicitud.', null];
                                                }
                                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                            } else {
                                                foreach ($sdSolicitud->getMessages() as $message) {
                                                    $this->msnError .= $message->getMessage() . "<br/>";
                                                }
                                                $this->logger->error($this->msnError);
                                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                                            }
                                        }else {
                                            $this->mensaje = ['warning', 'El derecho Arco seleccionado es incorrecto.', null];
                                        }
                                    }else {
                                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                                    }
                                }
                            }else {
                                $this->mensaje = ['warning', 'La solicitud no ha sido registrada.', null];
                            }
                            if($respuesta){
                                //Hacemos el inicio de la solicitud en el flujo buscando la etapa principal
                                if ($funcion->cambiarEtapa($sdSolicitud->id_solicitud)) {
                                    $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];//es necesario enviar los datos de la solicitud
                                } else {
                                    $this->mensaje = ['danger', 'Ocurrio un error al registrar la solicitud.', null];
                                }
                            }

                            break;
                        case 3:
                            //Realizamos el turnado a las dependencias seleccionadas
                            $idPregunta = $this->request->getPost('txtIdPregunta', null, 0);
                            $dependencias = $this->request->getPost('slDependencias', null,'');
                            $comentario = $this->request->getPost('txtComentario', null,'');

                            if(!empty($dependencias) && !empty($idPregunta)) {
                                //obtenemos la pregunta en base al id_pregunta
                                $sdPregunta = SdPregunta::findFirst((int)$idPregunta);

                                if(!empty($sdPregunta)){
                                    foreach ($dependencias as $dependencia){
                                        //hacemos la búsqueda de la dependencia
                                        $phql = "SELECT DISTINCT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION
                                          FROM XxhrPqHierarchyV 
                                          WHERE flex_value_id = :flex_value_id:";

                                        //validamos que sea la solicitud seleccionada
                                        $sdDependencia  = $query = $this->modelsManager->executeQuery($phql, ["flex_value_id" => $dependencia]);
                                        $sdDependencia=  $sdDependencia->getLast();

                                        $sdPreguntaDependencia = new SdPreguntaDependencia();
                                        $sdPreguntaDependencia->id_pregunta = $idPregunta;
                                        $sdPreguntaDependencia->id_dependencia = $sdDependencia->FLEX_VALUE_ID;
                                        $sdPreguntaDependencia->flex_value = $sdDependencia->FLEX_VALUE;
                                        $sdPreguntaDependencia->dependencia = $sdDependencia->DESCRIPTION;
                                        $sdPreguntaDependencia->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                        $sdPreguntaDependencia->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                        $sdPreguntaDependencia->estatus = 'AC';

                                        if($sdPreguntaDependencia){
                                            if (!$sdPreguntaDependencia->save()) {
                                                $flag = false;
                                            }
                                        }
                                        if($comentario){
                                            $secuencia = $this->db->query('SELECT SD_PREGUNTA_COMENTARIO_SEQ.nextval FROM dual');
                                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                            $secuencia = $secuencia->fetchAll($secuencia);

                                            $sdComentariosPregunta = new SdPreguntaComentario();
                                            $sdComentariosPregunta->id = $secuencia[0]['NEXTVAL'];
                                            $sdComentariosPregunta->id_pregunta = $idPregunta;
                                            $sdComentariosPregunta->id_dependencia = $sdDependencia->FLEX_VALUE_ID;
                                            $sdComentariosPregunta->flex_value = $sdDependencia->FLEX_VALUE;
                                            $sdComentariosPregunta->dependencia = $sdDependencia->DESCRIPTION;
                                            $sdComentariosPregunta->comentario = $comentario;
                                            $sdComentariosPregunta->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                            $sdComentariosPregunta->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                            $sdComentariosPregunta->estatus = 'AC';

                                            if($sdComentariosPregunta){
                                                if (!$sdComentariosPregunta->save()) {
                                                    $flag = false;
                                                }
                                            }
                                        }
                                    }
                                    //Hacemos la búsqueda de la solicitud
                                    $solicitud = SdSolicitud::findFirst($sdPregunta->id_solicitud);

                                    if($solicitud){
                                        $solicitud->turnado = 1;
                                        $solicitud->fecha_turnado = new \Phalcon\Db\RawValue('SYSDATE');
                                        $solicitud->usuario_u = $this->session->usuario['usuario'];
                                        $solicitud->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                                        if (!$solicitud->save()) {
                                            $flag = false;
                                        }
                                    }

                                    //Cambiamos el estatus de la pregunta cuando ha sido turnada
                                    $sdPregunta->turnado = 1;
                                    $sdPregunta->fecha_turnado = new \Phalcon\Db\RawValue('SYSDATE');
                                    if (!$sdPregunta->save()) {
                                        $flag = false;
                                    }

                                    $secuencia = $this->db->query('SELECT SD_PREGUNTA_HISTORIAL_SEQ.nextval FROM dual');
                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                    $secuencia = $secuencia->fetchAll($secuencia);

                                    $sdPreguntaHistorial = new SdPreguntaHistorial();
                                    $sdPreguntaHistorial->id = $secuencia[0]['NEXTVAL'];
                                    $sdPreguntaHistorial->id_pregunta = $idPregunta;
                                    $sdPreguntaHistorial->mensaje = "Se realiza el turnado de la pregunta";
                                    $sdPreguntaHistorial->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                    $sdPreguntaHistorial->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                    $sdPreguntaHistorial->estatus = 'AC';

                                    if($sdPreguntaHistorial){
                                        if (!$sdPreguntaHistorial->save()) {
                                            $flag = false;
                                        }
                                    }

                                    if ($flag) {
                                        $this->mensaje = ['success', 'Se ha turnado correctamente.', null];
                                    } else {
                                        $this->mensaje = ['warning', 'El turnado seleccionado no se encuentra en el sistema.', null];
                                    }
                                }else{
                                    $this->mensaje = ['danger', 'Ocurrio un error al seleccionar los datos de la pregunta.', null];
                                }
                            }else {
                                $this->mensaje = ['warning', 'Los campos * son requeridos..', null];
                            }
                            break;
                    }

                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a la solicitud.', null];
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

    /**
     *  Cambia la etapa en el flujo de la solicitud
     *  @author Dora Nely Vega González
     */
    public function cambiarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $idSolicitud = $this->request->getPost('idSolicitud', null, 0);
                    $idTransaccion = $this->request->getPost('idTransaccion', null, '');

                    //Hacemos el cambio de etapa del flujo de solicitud
                    if ($funcion->cambiarEtapa($idSolicitud, $idTransaccion)) {
                        $this->mensaje = ['success', 'Se agrego correctamente el historial de la solicitud.', $idSolicitud]; //es necesario el envio de la solicitud
                    }else{
                        $this->mensaje = ['danger', 'Ocurrio un error al seleccionar la solicitud.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al cambiar de etapa.', null];
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

    /**
     *  Obtiene todas las solicitudes por tipo y estatus
     *  Retorna array en formato json con todas las solicitudes
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        //Defición de Variables al realizar el filtro
        $opt = $this->request->get('opt', null, 0);
        $id = $this->request->get('id_solicitud', null, 0);
        $tipo = $this->request->get('tipo', null, '');
        $limit = $this->request->get('limit', null, 0);
        $offset = $this->request->get('offset', null, 0);
        $order = $this->request->get('order', null, '');
        $sort = $this->request->get('sort', null, '');
        $search = $this->request->get('search', null, '');
        $currentPage =  (($offset/$limit) + 1);
        $total = 0;
        $rows = array();
        $registros = [];
        $roles = [];

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{

                    switch ($opt) {
                        case 0:
                            $phql= "SELECT H.id_solicitud AS ID_SOLICITUD, S.folio AS FOLIO, S.folio_externo AS FOLIO_EXTERNO, 
                                           H.id_flujo AS ID_FLUJO, ES.orden AS ORDEN, T.descripcion AS TIPO, antecedente AS ANTECEDENTE,
                                           H.id_etapa AS ID_ETAPA, E.nombre AS ETAPA, E.color AS COLOR_ETAPA, 
                                           H.n_etapa_id AS N_ETAPA_ID, NE.nombre AS N_ETAPA, NE.color AS COLOR_N_ETAPA,
                                           H.id_estado AS ID_ESTADO, ES.nombre AS ESTADO, ES.color AS COLOR_ESTADO,
                                           H.n_estado_id AS N_ESTADO_ID, NES.nombre AS N_ESTADO, NES.color AS COLOR_N_ESTADO,
                                           id_transaccion AS ID_TRANSACCION, transaccion AS TRANSACCION,  E.condicion  AS CONDICION, 
                                           to_char(S.fecha_i,'DD/MM/YYYY') AS FECHA_RECEPCION, fecha_prevencion AS FECHA_PREVENCION, 
                                           to_char(S.fecha_turnado,'DD/MM/YYYY') AS FECHA_TURNADO, to_char(S.fecha_i,'HH24:MI') AS HORA,
                                           dias_utpe AS DIAS_UTPE, medio AS MEDIO
                                    FROM SdSolicitudHistorial H
                                        INNER JOIN SdSolicitud S ON (H.id_solicitud = S.id_solicitud)
                                        INNER JOIN SdMedioRegistro MR ON (MR.id_medio_registro = S.id_medio_registro)
                                        INNER JOIN SdFlujoEtapa E ON (H.id_etapa = E.id)
                                        INNER JOIN SdFlujoEtapa NE ON (H.n_etapa_id = NE.id)
                                        INNER JOIN SdFlujoEstado ES ON (H.id_estado = ES.id)
                                        INNER JOIN SdFlujoEstado NES ON (H.n_estado_id = NES.id)
                                        INNER JOIN SdSolicitudTipo T ON (S.id_tipo = T.id_tipo)
                                        LEFT JOIN SdFlujoEstadoPlazos P ON (ES.id = P.id_estado)
                                    WHERE   H.id IN(SELECT MAX (SdSolicitudHistorial.id) FROM SdSolicitudHistorial GROUP BY SdSolicitudHistorial.id_solicitud)
                                            AND  T.tipo=:tipo: AND S.estatus=:estatus: AND (UPPER(translate(S.folio, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU'))LIKE UPPER(:folio:) 
                                            OR UPPER(translate(ES.nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:folio:))
                                    ORDER BY  H.id_solicitud";

                            //obtiene los registros del modelo solicitudes
                            $solicitudes = $this->modelsManager->executeQuery($phql,
                                ['tipo'=>$tipo, 'estatus'=>'AC', 'orden'=>trim($sort).' '.strtoupper(trim($order)), 'folio'=>'%'.strtr(strtoupper(trim($search)),"áéíóúÁÉÍÓÚ","aeiouAEIOU").'%']
                            );

                            //Validamos si el usuarios ha sido logueado
                            if ($this->session->usuario['roles']) {
                                foreach ($this->session->usuario['roles'] as $rol){
                                    $roles[] = $rol->ID;
                                }
                            }

                            //Consultamos los roles del usuario registrado
                            $roles = implode(', ', (array)$roles);
                           
                            foreach ($solicitudes as $solicitud){
                                //Hacemos la búsqueda de las transacciones
                                $transacciones = SdFlujoTransaccion::query()
                                    ->columns(array('BOTON' => "SdFlujoTransaccion.boton", 'NOMBRE' => "SdFlujoTransaccion.nombre", 'ID_TRANSACCION' => "SdFlujoTransaccion.id",
                                        'ICONO' => "SdFlujoTransaccion.icono",'FORMULARIO' => "SdFlujoTransaccion.formulario"))
                                    ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoEstadoTransaccion')
                                    ->innerJoin('SdFlujoEstado', "SdFlujoEstado.id = SdFlujoEstadoTransaccion.id_estado", 'SdFlujoEstado')
                                    ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                    ->innerJoin('SdFlujoEtapa', "SdFlujoEtapa.id = SdFlujoEtapaEstado.id_etapa", 'SdFlujoEtapa')
                                    ->innerJoin('SdFlujoTransaccionRol', "SdFlujoTransaccionRol.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoTransaccionRol')
                                    ->conditions("SdFlujoTransaccion.id_flujo=:id_flujo: AND SdFlujoEtapa.id=:n_etapa_id:  
                                    AND SdFlujoEstado.id=:n_estado_id: AND SdFlujoTransaccionRol.id_rol IN (".$roles.") AND SdFlujoTransaccion.estatus=:estatus:")
                                    ->bind( ['id_flujo'=>$solicitud->ID_FLUJO,'n_etapa_id'=>$solicitud->N_ETAPA_ID,'n_estado_id'=>$solicitud->N_ESTADO_ID,'estatus'=>'AC'])
                                    ->groupBy("SdFlujoTransaccion.id, SdFlujoTransaccion.boton,  SdFlujoTransaccion.icono, SdFlujoTransaccion.nombre, SdFlujoTransaccion.formulario")
                                    ->orderBy("SdFlujoTransaccion.formulario")
                                    ->execute()->toArray();

                                $solicitud->transacciones = $transacciones;
                                $fecha = $funcion->getFechaHistorial($solicitud->ID_SOLICITUD);
                                $solicitud->FECHA_PREVENCION = $funcion->getFechaPrevencion( $solicitud->DIAS_UTPE,$fecha, $solicitud->HORA);

                                $registros[] = $solicitud; //Llenamos el array con las solicitudes
                            }

                            break;
                        case 1:
                            //Obtiene preguntas por solicitud activa
                            $preguntas = SdPregunta::query()
                                ->columns(array('ID_PREGUNTA' => "SdPregunta.id_pregunta",'ID_SOLICITUD' => "SdPregunta.id_solicitud", 'FOLIO' => "SdSolicitud.folio",
                                    'ANTECENDENTE'=>"SdSolicitud.antecedente", 'FECHA_I'=>"UPPER(to_char(SdSolicitud.fecha_i,'DD/MM/YYYY'))",
                                    'FECHA_TURNADO' => "to_char(SdPregunta.fecha_turnado,'DD/MM/YYYY')",  'TURNADO' => "SdPregunta.turnado",
                                    'OBSERVACIONES' => "SdPregunta.observaciones", "to_char(SdPregunta.fecha_turnado,'DD/MM/YYYY') AS FECHA_TURNADO",
                                    'DESCRIPCION'=> 'SdPregunta.descripcion', 'ESTATUS'=>'SdPregunta.estatus', 'CONSENTIMIENTO' => "SdSolicitud.consentimiento"))
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
                                ->conditions("UPPER(translate(SdPregunta.descripcion, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:descripcion:) 
                                    AND SdSolicitud.id_solicitud=:id_solicitud: AND SdPregunta.estatus=:estatus:")
                                ->bind(['descripcion' =>  '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'id_solicitud' => $id, 'estatus'=>'AC'])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();

                            foreach ($preguntas as $pregunta){
                                //Hacemos la búsqueda de los comentarios por pregunta y dependencia
                                $comentarios = SdPreguntaComentario::find([
                                    'columns' => array('DEPENDENCIA' => "dependencia", 'COMENTARIO' => 'comentario', "FECHA_I" => "to_char(fecha_i,'DD/MM/YYYY')"),
                                    'conditions' => "id_pregunta=:id_pregunta:",
                                    'bind' => ['id_pregunta' => $pregunta['ID_PREGUNTA']],
                                ])->toArray();

                                $pregunta["comentarios"] = $comentarios;
                                $registros[] = $pregunta; //Llenamos el array con las preguntas
                            }
                            break;
                        case 2:
                            //Obtenemos la direccion donde se almacenaran los documentos de la solicitud
                            $ruta_documentos = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_documentos\'');

                            //Obtiene documentos por solicitud activa
                            $registros = SdDocumentoSolicitud::query()
                                ->columns(array('ID_DOCUMENTO'=>"id_documento",'ID_SOLICITUD'=>"id_solicitud", 'NOMBRE'=>'nombre', 'EXTENSION'=>'extension'))
                                ->conditions("nombre LIKE :nombre: AND ruta LIKE :ruta: AND id_solicitud=:id: AND estatus='AC'")
                                ->bind(['nombre' => '%'.strtolower(trim($search)).'%', 'ruta' => '%'.$ruta_documentos[0]->VALOR .'%', 'id' => $id])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();
                            break;
                        case 3:
                            $registros = SdMedioRespuesta::query()
                                ->columns(array('ID_MEDIO_RESPUESTA' => "SdSolicitudMedio.id_medio_respuesta", 'CANTIDAD' => "SdSolicitudMedio.cantidad",'MEDIO' => "SdMedioRespuesta.medio",
                                    'COSTO'=> 'SdMedioRespuesta.costo', 'TOTAL'=>'SdSolicitudMedio.cantidad * SdMedioRespuesta.costo'))
                                ->innerJoin('SdSolicitudMedio', "SdSolicitudMedio.id_medio_respuesta = SdMedioRespuesta.id_medio_respuesta", 'SdSolicitudMedio')
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdSolicitudMedio.id_solicitud", 'SdSolicitud')
                                ->conditions('SdMedioRespuesta.medio=:medio: AND SdSolicitud.id_solicitud=:id_solicitud: AND SdMedioRespuesta.estatus=:estatus:')
                                ->bind(['medio' => '%' . strtolower(trim($search)) . '%','id_solicitud' => $id, 'estatus'=>'AC'])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();
                            break;
                        case 4:
                            // Obtiene el historial de la solicitud
                            $registros = SdSolicitudHistorial::query()
                                ->columns(array('ID' => "SdSolicitudHistorial.id", 'ID_SOLICITUD' => "SdSolicitud.id_solicitud",
                                    'FOLIO' => "SdSolicitud.folio",'FECHA_I'=> "UPPER(to_char(SdSolicitudHistorial.fecha_i,'DD/MM/YYYY'))",
                                    'USUARIO' => "SdSolicitudHistorial.usuario_i", 'TRANSACCION'=> 'SdSolicitudHistorial.transaccion',
                                    'ETAPA'=> 'SdSolicitudHistorial.etapa', 'N_ETAPA'=> 'SdSolicitudHistorial.n_etapa',
                                    'ESTADO'=> 'SdSolicitudHistorial.estado', 'N_ESTADO'=> 'SdSolicitudHistorial.n_estado'))
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdSolicitudHistorial.id_solicitud", 'SdSolicitud')
                                ->conditions(' SdSolicitud.id_solicitud=:id_solicitud: AND SdSolicitudHistorial.estatus=:estatus:')
                                ->bind(['id_solicitud' => $id, 'estatus'=>'AC'])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();
                            break;
                        case 5:
                            //Obtiene el historial de comentarios de la solicitud
                            $registros = SdSolicitudComentario::query()
                                ->columns(array('USUARIO'=> 'SdSolicitudComentario.usuario_i', 'ID' => "SdSolicitudComentario.id",
                                    'FECHA_I'=> "UPPER(to_char(SdSolicitud.fecha_i,'DD-mon-YYYY'))",'COMENTARIO'=> 'SdSolicitudComentario.comentario'))
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdSolicitudComentario.id_solicitud", 'SdSolicitud')
                                ->conditions('SdSolicitudComentario.comentario LIKE :comentario: AND SdSolicitud.id_solicitud=:id_solicitud: AND SdSolicitudComentario.estatus=:estatus:')
                                ->bind(['comentario' => '%' . strtolower(trim($search)) . '%', 'id_solicitud' => $id, 'estatus'=>'AC'])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();

                            break;
                        case 6:
                            //Obtiene los medios de respuesta de la tabla
                            $registros = SdMedioRespuesta::find([
                                'columns' => array('ID_MEDIO_RESPUESTA' => "id_medio_respuesta", 'MEDIO' => 'medio',
                                    'COSTO' => 'costo','ESTATUS' => 'estatus', 'TOTAL' => '0', 'CANTIDAD'=> '0'),
                                'conditions' => 'estatus=:estatus: ',
                                'bind' => ['estatus' => 'AC'],
                                'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                            ])->toArray();
                            break;
                        case 8:
                            $solicitudesDependencia = [];
                            $registros = [];

                            //Consultamos las dependencias del usuario registrado
                            $dependencias = implode(',', array_map('intval',(array)$this->session->usuario['dependencias']));

                            //Hacemos la búsqueda de las solicitudes turnadas al usuario con el rol de dependencia
                            $solicitudes =  SdPregunta::query()
                                ->columns(array('ID_SOLICITUD' => "SdPregunta.id_solicitud"))
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
                                ->innerJoin('SdPreguntaDependencia', "SdPreguntaDependencia.id_pregunta = SdPregunta.id_pregunta", 'SdPreguntaDependencia')
                                ->conditions("SdPreguntaDependencia.id_dependencia IN (".$dependencias.") AND SdSolicitud.estatus=:estatus:")
                                ->bind(['descripcion' =>  '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'id_solicitud' => $id, 'estatus'=>'AC'])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();

                            if(count($solicitudes) > 0){
                                foreach ($solicitudes as $solicitud){
                                    $solicitudesDependencia[] = $solicitud["ID_SOLICITUD"];
                                }
                                //Consultamos las dependencias del usuario registrado
                                $solicitudesDependencia = implode(',', array_map('intval',($solicitudesDependencia)));

                                $phql= "SELECT H.id_solicitud AS ID_SOLICITUD, S.folio AS FOLIO, S.folio_externo AS FOLIO_EXTERNO, 
                                           H.id_flujo AS ID_FLUJO, ES.orden AS ORDEN, T.descripcion AS TIPO, antecedente AS ANTECEDENTE,
                                           H.id_etapa AS ID_ETAPA, E.nombre AS ETAPA, E.color AS COLOR_ETAPA, 
                                           H.n_etapa_id AS N_ETAPA_ID, NE.nombre AS N_ETAPA, NE.color AS COLOR_N_ETAPA,
                                           H.id_estado AS ID_ESTADO, ES.nombre AS ESTADO, ES.color AS COLOR_ESTADO,
                                           H.n_estado_id AS N_ESTADO_ID, NES.nombre AS N_ESTADO, NES.color AS COLOR_N_ESTADO,
                                           id_transaccion AS ID_TRANSACCION, transaccion AS TRANSACCION,  E.condicion  AS CONDICION, 
                                           to_char(S.fecha_i,'DD/MM/YYYY') AS FECHA_RECEPCION, fecha_prevencion AS FECHA_PREVENCION, 
                                           to_char(S.fecha_turnado,'DD/MM/YYYY') AS FECHA_TURNADO, to_char(S.fecha_i,'HH24:MI') AS HORA,
                                           dias_utpe AS DIAS_UTPE, medio AS MEDIO
                                     FROM SdSolicitudHistorial H
                                        INNER JOIN SdSolicitud S ON (H.id_solicitud = S.id_solicitud)
                                        INNER JOIN SdMedioRegistro MR ON (MR.id_medio_registro = S.id_medio_registro)
                                        INNER JOIN SdFlujoEtapa E ON (H.id_etapa = E.id)
                                        INNER JOIN SdFlujoEtapa NE ON (H.n_etapa_id = NE.id)
                                        INNER JOIN SdFlujoEstado ES ON (H.id_estado = ES.id)
                                        INNER JOIN SdFlujoEstado NES ON (H.n_estado_id = NES.id)
                                        INNER JOIN SdSolicitudTipo T ON (S.id_tipo = T.id_tipo)
                                        LEFT JOIN SdFlujoEstadoPlazos P ON (ES.id = P.id_estado)
                                    WHERE H.id IN(SELECT MAX (SdSolicitudHistorial.id) FROM SdSolicitudHistorial GROUP BY SdSolicitudHistorial.id_solicitud)
                                     AND S.estatus=:estatus: AND  S.turnado='1' AND (UPPER(translate(S.folio, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:folio:) 
                                    OR UPPER(translate(ES.nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:folio:) ) AND  S.id_solicitud IN (".$solicitudesDependencia.")
                                    ORDER BY :orden:";

                                //obtiene los registros del modelo solicitudes
                                $solicitudes = $this->modelsManager->executeQuery($phql,
                                    [ 'estatus'=>'AC', 'orden'=>trim($sort).' '.strtoupper(trim($order)), 'folio'=>'%'.strtr(strtoupper(trim($search)),"áéíóúÁÉÍÓÚ","aeiouAEIOU").'%']
                                );

                                //Consultamos los roles del usuario registrado
                                $roles= implode(',', array_map('intval',(array)$this->session->usuario['roles']));

                                foreach ($solicitudes as $solicitud){
                                    //Hacemos la búsqueda de las transacciones
                                    $transacciones = SdFlujoTransaccion::query()
                                        ->columns(array('BOTON' => "SdFlujoTransaccion.boton", 'NOMBRE' => "SdFlujoTransaccion.nombre", 'ID_TRANSACCION' => "SdFlujoTransaccion.id",
                                            'ICONO' => "SdFlujoTransaccion.icono",'FORMULARIO' => "SdFlujoTransaccion.formulario"))
                                        ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoEstadoTransaccion')
                                        ->innerJoin('SdFlujoEstado', "SdFlujoEstado.id = SdFlujoEstadoTransaccion.id_estado", 'SdFlujoEstado')
                                        ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                                        ->innerJoin('SdFlujoEtapa', "SdFlujoEtapa.id = SdFlujoEtapaEstado.id_etapa", 'SdFlujoEtapa')
                                        ->innerJoin('SdFlujoTransaccionRol', "SdFlujoTransaccionRol.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoTransaccionRol')
                                        ->conditions("SdFlujoTransaccion.id_flujo=:id_flujo: AND SdFlujoEtapa.id=:n_etapa_id:  
                                    AND SdFlujoEstado.id=:n_estado_id: AND SdFlujoTransaccionRol.id_rol IN (".$roles.") AND SdFlujoTransaccion.estatus=:estatus:")
                                        ->bind( ['id_flujo'=>$solicitud->ID_FLUJO,'n_etapa_id'=>$solicitud->N_ETAPA_ID,'n_estado_id'=>$solicitud->N_ESTADO_ID,'estatus'=>'AC'])
                                        ->groupBy("SdFlujoTransaccion.id, SdFlujoTransaccion.boton,  SdFlujoTransaccion.icono, SdFlujoTransaccion.nombre, SdFlujoTransaccion.formulario")
                                        ->orderBy("SdFlujoTransaccion.formulario")
                                        ->execute()->toArray();

                                    $solicitud->transacciones = $transacciones;
                                    $fecha = $funcion->getFechaHistorial($solicitud->ID_SOLICITUD);
                                    $solicitud->FECHA_PREVENCION = $funcion->getFechaPrevencion( $solicitud->DIAS_UTPE,$fecha, $solicitud->HORA);

                                    $registros[] = $solicitud; //Llenamos el array con las solicitudes
                                }
                            }
                            break;
                        case 9:
                            //Obtiene preguntas por solicitud activa
                            $preguntas = SdPregunta::query()
                                ->columns(array('ID_PREGUNTA' => "SdPregunta.id_pregunta",'ID_SOLICITUD' => "SdPregunta.id_solicitud",
                                    'FOLIO' => "SdSolicitud.folio", 'ANTECENDENTE' => "SdSolicitud.antecedente",
                                    'FECHA_I'=> "UPPER(to_char(SdSolicitud.fecha_i,'DD/MM/YYYY'))", 'OBSERVACIONES' => "SdPregunta.observaciones",
                                    'DESCRIPCION'=> 'SdPregunta.descripcion', 'ESTATUS'=>'SdPregunta.estatus', 'CONSENTIMIENTO' => "SdSolicitud.consentimiento"))
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
                                ->conditions("UPPER(translate(SdPregunta.descripcion, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:descripcion:) 
                                    AND SdSolicitud.id_solicitud=:id_solicitud: AND SdPregunta.estatus=:estatus:")
                                ->bind(['descripcion' =>  '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'id_solicitud' => $id, 'estatus'=>'AC'])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();

                            foreach ($preguntas as $pregunta){
                                //Consultamos las dependencias del usuario registrado
                                $dependencias = implode(',', array_map('intval',(array)$this->session->usuario['dependencias']));

                                //Hacemos la búsqueda de los comentarios por pregunta y dependencia
                                $comentarios = SdPreguntaComentario::find([
                                    'columns' => array('DEPENDENCIA' => "dependencia", 'COMENTARIO' => 'comentario', "FECHA_I" => "to_char(fecha_i,'DD/MM/YYYY')"),
                                    'conditions' => "id_pregunta=:id_pregunta: AND  id_dependencia IN (".$dependencias.") ",
                                    'bind' => ['id_pregunta' => $pregunta['ID_PREGUNTA']],
                                ])->toArray();

                                $pregunta["comentarios"] = $comentarios;
                                $registros[] = $pregunta; //Llenamos el array con las preguntas
                            }
                            break;
                        case 10:
                            //Obtenemos la direccion donde se almacenaran los documentos de la solicitud
                            $ruta_documentos = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_prevencion\'');

                            //Obtiene documentos por solicitud activa
                            $registros = SdDocumentoSolicitud::query()
                                ->columns(array('ID_DOCUMENTO'=>"id_documento",'NOMBRE'=>'nombre', 'EXTENSION'=>'extension', 'FECHA_I'=>'fecha_i'))
                                ->conditions("nombre LIKE :nombre: AND ruta LIKE :ruta: AND id_solicitud=:id: AND estatus='AC'")
                                ->bind(['nombre' => '%'.strtolower(trim($search)).'%', 'ruta' => '%'.$ruta_documentos[0]->VALOR .'%', 'id' => $id])
                                ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                                ->execute()->toArray();
                            break;
                    }
                    // Crear un paginador del modelo desde un array
                    $paginacion = new PaginatorArray(
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
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar acceder a los registros.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }

    /**
     *  Hace la búsqueda de los registros
     *  Retorna array en formato json con todos los registros
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
                        case 1:
                            //Obtiene las dependencias activas
                            $phql = "SELECT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION, hierarchy AS HIERARCHY, agrupador AS AGRUPADOR  
                              FROM XxhrPqHierarchyV 
                              WHERE (HIERARCHY = '17' OR HIERARCHY = '18') AND UPPER(translate(description, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(translate(:description:, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU'))
                              AND (flex_value LIKE '1%' OR flex_value LIKE '2%' OR flex_value LIKE '3%' OR flex_value LIKE '5%')
                              GROUP BY flex_value, flex_value_id, description, hierarchy, agrupador
                              ORDER BY flex_value";

                            //validamos que sea la solicitud seleccionada
                            $registros  = $query = $this->modelsManager->executeQuery($phql, ["description" =>'%'.$nombre.'%']);

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
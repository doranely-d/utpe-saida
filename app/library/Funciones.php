<?php
/*
 * COPYRIGHT © 2018. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * SAIDA IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

class Funciones extends \Phalcon\Mvc\User\Component
{
    /**
     *  genera el mensaje de respuesta
     *  @var string $mensaje con la información del mensaje
     *  @return array con el mensaje de respuesta
     *  @author Dora Nely Vega Gonzalez
     */
    public function getMensaje($mensaje)
    {
        $resultado = array();

        if($mensaje){
            $resultado['estatus'] = $mensaje[0]; // obtiene el estatus del mensaje en la posición 0
            $resultado['mensaje'] = $mensaje[1]; // obtiene el string del mensaje en la posición 1
            $resultado['datos'] = $mensaje[2]; // obtiene los datos del mensaje en la posición 2
        }

        return $resultado; //mensaje de respuesta
    }

    /**
     *  Retorna el estatus de la pregunta
     *  @var string $nombre del estatus que desea retornar
     *  @return integer con el estatus de la pregunta
     *  @author Dora Nely Vega Gonzalez
     */
    public function getEstatusPregunta($nombre)
    {
        $respuesta = 0;

        //obtiene el estatus de la solicitud
        $sdEstatusPregunta = SdEstatusPregunta::find([
            'columns' => array('ID_ESTATUS' => "id_estatus", 'NOMBRE'=> 'nombre', 'ESTATUS'=>'estatus'),
            'conditions' => 'nombre LIKE :nombre: AND estatus=:estatus:',
            'bind' => ['nombre' => '%'.$nombre.'%', 'estatus'=>'AC']
        ]);

        if ($sdEstatusPregunta) {
            $respuesta = $sdEstatusPregunta[0]->ID_ESTATUS;
        }
        return $respuesta;
    }

    /**
     *  Retorna el tipo de solicitud (SAI ó ARCO)
     *  @var string $tipo del tipo que se desea retornar
     *  @return integer con el tipo de solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function getTipo($tipo)
    {
        $respuesta = 0;

        //obtiene el tipo SAI para solicitudes de acceso a la información publica
        $sdTipoSolicitud = SdSolicitudTipo::find([
            'columns' => array('ID_TIPO' => "id_tipo", 'TIPO'=> 'tipo', 'ESTATUS'=>'estatus'),
            'conditions' => 'tipo LIKE :tipo: AND estatus=:estatus:',
            'bind' => ['tipo' => '%'.$tipo.'%', 'estatus'=>'AC']
        ]);

        if ($sdTipoSolicitud) {
            $respuesta = $sdTipoSolicitud[0]->ID_TIPO;
        }
        return $respuesta;
    }

    /**
     *  Retorna el flujo de solicitud en base al tipo (SAI ó ARCO)
     *  @var string $tipo del tipo que se desea retornar
     *  @return integer con el tipo de solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function obtenerFlujo($idtipo)
    {
        $respuesta = 0;

        //obtiene el tipo SAI para solicitudes de acceso a la información publica
        $sdFlujo = SdFlujo::find([
            'columns' => array('ID_FLUJO' => "id_flujo", 'ID_TIPO'=> 'id_tipo', 'ESTATUS'=>'estatus'),
            'conditions' => 'id_tipo=:id_tipo: AND estatus=:estatus:  AND aprobado=:aprobado:',
            'bind' => ['id_tipo' => $idtipo, 'estatus'=>'AC', 'aprobado'=>1]
        ]);


        if (count($sdFlujo) > 0) {
            $respuesta = $sdFlujo[0]->ID_FLUJO;
        }

        return $respuesta;
    }

    /**
     *  Retorna el medio de registro de solicitud (SAI ó ARCO)
     *  @var string $medio del medio de registro que se desea retornar
     *  @return integer con el id_medio de registro de la solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function getMedioRegistro($medio)
    {
        $respuesta = 0;

        //obtiene el medio de registro de la solicitud
        $sdMedioRegistro =  SdMedioRegistro::find([
            'columns' => array('ID_MEDIO_REGISTRO' => "id_medio_registro", 'MEDIO'=> 'medio', 'ESTATUS'=>'estatus'),
            'conditions' => 'medio LIKE :medio: AND estatus=:estatus:',
            'bind' => ['medio' => '%'.$medio.'%', 'estatus'=>'AC']
        ]);

        if ($sdMedioRegistro) {
            $respuesta = $sdMedioRegistro[0]->ID_MEDIO_REGISTRO;
        }
        return $respuesta;
    }

    /**
     *  Obtiene la fecha de prevencion de la solicitud en base al estatus
     *  @var integer $maxDias del plazo en base a la solicitud seleccionada
     *  @var string $fecha actual del flujo en el que se encuentra la solicitud
     *  @return string con la fecha de prevención de la solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function getFechaPrevencion($maxDias, $fecha, $hora)
    {
        //obtenemos los dias inhábiles del calendario
        $diasInhabiles = $this->getDiasInabiles();

        //convertimos la fecha actual en la que se encuentra la solicitud
        $fechaSiguiente = DateTime::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');

        //Validamos que el horario sea de 8:00 a 13:30
        if (!((strtotime('08:00') - strtotime('13:30')) > strtotime($hora)))
        {
            //Si la hora no se encuentra en el rango le sumamos un día habil
            $fechaSiguiente = date('d-m-Y', strtotime("+1 day", strtotime($fechaSiguiente)));
        }

        //validamos si el siguiente día actual es activo
        for ($i = 0; $i < $maxDias; $i++)
        {
            $fechaSiguiente = date('d-m-Y', strtotime("+1 day", strtotime($fechaSiguiente)));
            $nfecha = str_replace('-','/', $fechaSiguiente); //damos formato para comparar con la cadena de diasinhabiles

            // Validamos que el día no es ni sábado, ni domingo ni se encuentre en el array de días inhabiles.
            if(!(!in_array($nfecha, $diasInhabiles)&& (date('N',strtotime($fechaSiguiente)) != 6 && date('N',strtotime($fechaSiguiente)) != 7))){
                $maxDias++;
            }
        }
        $date = date_create($fechaSiguiente);

        return date_format($date, 'd/m/Y');
    }

    /**
     *  Obtiene los dias inhábiles del calendario
     *  @return array en formato json con todos los dias inhábiles del calendario
     *  @author Dora Nely Vega Gonzalez
     */
    public function getDiasInabiles()
    {
        $diasInhabiles = array();

        //Se realiza la búsqueda de los dias inhábiles del calendario
        $sdDiasInhabiles = SdDiasInhabiles::find([
            'columns' => array("FECHA"=> "to_char(fecha,'DD/MM/YYYY')"),
            'conditions' => "estatus='AC'"
        ]);

       ///llenamos el array de dias con la conversión de la fecha
        foreach ($sdDiasInhabiles as $dias){
            $diasInhabiles[]=   $dias->FECHA;
        }

        return $diasInhabiles;
    }

    /**
     *  Obtiene los estados activos para las solicitudes
     *  @return array en formato json con todos los estados activos
     *  @author Dora Nely Vega Gonzalez
     */
    public function obtenerEstados($idTipo)
    {
        $estados = SdFlujoEstado::query()
            ->columns(array('ID' => "SdFlujoEstado.id", 'NOMBRE'=> 'SdFlujoEstado.nombre', 'COLOR'=> 'SdFlujoEstado.color', 'ESTATUS'=>'SdFlujoEstado.estatus'))
            ->innerJoin('SdFlujo', "SdFlujo.id_flujo = SdFlujoEstado.id_flujo", 'SdFlujo')
            ->conditions('SdFlujo.aprobado=:aprobado: AND SdFlujoEstado.estatus=:estatus: AND SdFlujo.estatus=:estatus: AND SdFlujo.id_tipo=:id_tipo:')
            ->bind(['aprobado'=>1, 'estatus'=>'AC',  'id_tipo'=>$idTipo])
            ->execute()->toArray();

        return $estados;
    }

    /**
     *  Obtiene las solicitudes activas
     *  @var integer $tipo de la solicitud
     *  @return array en formato json con todos las solicitudes activas
     *  @author Dora Nely Vega Gonzalez
     */
    public function getSolicitudes($tipo)
    {
        $solicitudesdb = array();

        //Se realiza la búsqueda de las solicitudes en base al tipo de solicitud
        $phql= "SELECT H.id_solicitud AS ID_SOLICITUD,  S.folio AS FOLIO, H.id_flujo AS ID_FLUJO,
                id_etapa AS ID_ETAPA, E.nombre AS ETAPA,H.id_estado AS ID_ESTADO, ES.nombre AS ESTADO,
                 id_transaccion AS ID_TRANSACCION, transaccion AS TRANSACCION,  E.condicion  AS CONDICION,
                to_char(S.fecha_i,'DD/MM/YYYY') AS FECHA_I, to_char(S.fecha_i,'HH24:MI') AS HORA,
                 fecha_prevencion AS FECHA_PREVENCION, antecedente AS ANTECEDENTE, medio AS  MEDIO,
                E.color  AS COLOR_ETAPA, ES.color AS COLOR_ESTADO, tipo AS TIPO, dias_utpe AS  DIAS_UTPE
              FROM SdSolicitudHistorial H
                INNER JOIN SdSolicitud S ON (H.id_solicitud = S.id_solicitud)
                INNER JOIN SdMedioRegistro MR ON (MR.id_medio_registro = S.id_medio_registro)
                INNER JOIN SdFlujoEtapa E ON (H.id_etapa = E.id)
                INNER JOIN SdFlujoEstado ES ON (H.id_estado = ES.id)
                INNER JOIN SdSolicitudTipo T ON (S.id_tipo = T.id_tipo)
                LEFT JOIN SdFlujoEstadoPlazos P ON (ES.id = P.id_estado)
                WHERE H.id IN(SELECT MAX (SdSolicitudHistorial.id) FROM SdSolicitudHistorial   GROUP BY SdSolicitudHistorial.id_solicitud)
                AND T.tipo=:tipo: AND S.estatus=:estatus:
                ORDER BY S.id_solicitud";

        //obtiene los registros del modelo solicitudes
        $solicitudes = $this->modelsManager->executeQuery($phql,['tipo' =>$tipo, 'estatus' =>'AC']);

        foreach ($solicitudes as $solicitud){
            $fecha = $this->getFechaHistorial($solicitud->ID_SOLICITUD);
            $solicitud->FECHA_PREVENCION = $this->getFechaPrevencion($solicitud->DIAS_UTPE, $fecha, $solicitud->HORA);
            $solicitudesdb[] = $solicitud;
        }

        return $solicitudesdb;
    }
    /**
     *  Obtiene la última fecha del historial de la solicitud
     *  @var integer $idSolicitud de la solicitud
     *  @return string con la última fecha del historial de la solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function getFechaHistorial($idSolicitud)
    {
        $fecha = date('d/m/Y');;
        //Se realiza la búsqueda del historial de la solicitud
        $sdHistorial = SdSolicitudHistorial::find([
            'columns' => ['FECHA_I' => "to_char(fecha_i,'DD/MM/YYYY')"],
            'conditions' => 'id_solicitud=:id_solicitud: and estatus=:estatus: ',
            'bind' => ['id_solicitud'=>$idSolicitud, 'estatus'=>'AC'],
        ]);

        if(count($sdHistorial) > 0){
            //obtenemos el último registro del historial
            $sdHistorial = $sdHistorial->getLast();
            //obtenemos la última fecha del flujo en el historial
            $fecha = $sdHistorial->FECHA_I;
        }

        return $fecha;
    }

    /**
     *  Obtiene el catálogo de la solicitud
     *  @var integer $idSolicitud de la solicitud
     *  @return object con el catálogo de la solicitud
     *  @author Dora Nely Vega Gonzalez
     */
    public function getCatalogo($idSolicitud)
    {
        //Se realiza la búsqueda del catálogo de la solicitud seleccionada
        $catalogo = SdSolicitudCatalogo::query()
            ->columns(array('TEMA' => "SdTema.tema",'SUBTEMA'=> 'SdSubtema.subtema','TITULO'=> 'SdTitulo.titulo'))
            ->innerJoin('SdTema', "SdTema.id_tema = SdSolicitudCatalogo.id_tema", 'SdTema')
            ->innerJoin('SdSubtema', "SdSubtema.id_subtema = SdSolicitudCatalogo.id_subtema", 'SdSubtema')
            ->leftJoin('SdTitulo', "SdTitulo.id_titulo = SdSolicitudCatalogo.id_titulo", 'SdTitulo')
            ->conditions('SdSolicitudCatalogo.id_solicitud=:id_solicitud: AND SdTema.estatus=:estatus:')
            ->bind(['id_solicitud'=>$idSolicitud, 'estatus'=>'AC'])
            ->execute()->getFirst();

        return $catalogo;
    }

    /**
     *  Guarda comentario del solicitante
     *  @var integer $idSolicitante del solicitante
     *  @var string $comentario que se desea registrar
     *  @return boolean con la respuesta
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarComentarioSolicitante($idSolicitante, $comentario)
    {
        //Se realiza la búsqueda del solicitante seleccionado
        $dSolicitante = SdSolicitante::findFirst($idSolicitante);

        if ($dSolicitante) {
            //seleccionamos la siguiente secuencia
            $secuencia = $this->db->query('SELECT SD_COMENTARIOS_SOLICITANTE_SEQ.nextval FROM dual');
            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
            $secuencia = $secuencia->fetchAll($secuencia);

            //Registramos el comentario relacionado al solicitante
            $sdComentarios = new SdSolicitanteComentario();
            $sdComentarios->id = $secuencia[0]['NEXTVAL'];
            $sdComentarios->id_solicitante = $dSolicitante->id_solicitante;
            $sdComentarios->comentario = $comentario;
            $sdComentarios->usuario_i = $this->session->usuario['usuario'];
            $sdComentarios->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
            $sdComentarios->estatus = 'AC';

            if (!($sdComentarios->save())) {
                return false;
            }
        }else{
            return false;
        }
        return true;
    }

    /**
     *  Obtiene las etapas del flujo activo
     *  @return array en formato json con todas las etapas
     *  @author Dora Nely Vega Gonzalez
     */
    public function obtenerEtapas($id)
    {
        $registros = SdFlujoEtapa::find([
            'columns' => array('ID' => 'id', 'NOMBRE' =>'nombre', 'DESCRIPCION' =>'descripcion', 'COLOR' =>'color','PRINCIPAL' => 'principal'),
            'conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus:',
            'bind' => ['id_flujo' => (int)$id, 'estatus' => 'AC']
        ]);

        return $registros;
    }

    /**
     *  Valida que no exista otra etapa principal
     *  @return boolean con la respuesta
     *  @author Dora Nely Vega Gonzalez
     */
    public function validaPrincipal($id)
    {
        $etapas = SdFlujoEtapa::find([
            'conditions' => 'id_flujo=:id_flujo: AND estatus=:estatus: AND principal=:principal:',
            'bind' => ['id_flujo' => $id, 'estatus' => 'AC', 'principal' => 1]
        ]);

        foreach ($etapas AS $nEtapa){
            $etapa = SdFlujoEtapa::findFirst($nEtapa->id);
            $etapa->principal = 0;

            if ($etapa) {
                if ($etapa->save() == false) {
                    return false;
                }
            }else{ return false;}

        }
        return true;
    }

    /**
     *  Valida que no exista otra etapa principal
     *  @return boolean con la respuesta
     *  @author Dora Nely Vega Gonzalez
     */
    public function validarEstrados(){

        //Obtenemos las solicitudes activas del sistema
        $solicitudes = SdSolicitudHistorial::query()
            ->columns(array('ID_SOLICITUD' => "SdSolicitud.id_solicitud", 'FECHA_I' => "to_char(SdSolicitud.fecha_i,'DD/MM/YYYY')",
                'HORA_I' => "to_char(SdSolicitud.fecha_i,'HH24:MI')", 'FECHA_I_ESTRADOS' => "to_char(SdSolicitud.fecha_i_estrado,'HH24:MI')"))
            ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdSolicitudHistorial.id_solicitud", 'SdSolicitud')
            ->conditions("SdSolicitud.estatus='AC' AND SdSolicitud.estrado='1' AND 
            SdSolicitudHistorial.id IN(SELECT MAX (SdSolicitudHistorial.id) FROM SdSolicitudHistorial GROUP BY SdSolicitudHistorial.id_solicitud)")
            ->execute()->toArray();

        foreach ($solicitudes as $solicitud){

            //Hacemos la búsqueda de la solicitud
            $sdSolicitud = SdSolicitud::findFirst($solicitud['ID_SOLICITUD']);

            if($sdSolicitud) {
                //Obtenemos la fecha limite para publicar la solicitud en estrados
                $fecha_i_estrados = $this->getFechaPrevencion(5, $solicitud["FECHA_I"], $solicitud["HORA_I"]);

                //Validamos que las solicitudes no tengan más de 20 dias sin mostrar respuesta en estrados
                if (!empty($fecha_i_estrados) && empty($solicitud["FECHA_I_ESTRADOS"]) ) {
                    $hoy = date('d/m/Y');
                    $hoy = DateTime::createFromFormat("d/m/Y", $hoy);
                    $fecha_i_estrados = DateTime::createFromFormat("d/m/Y", $fecha_i_estrados);

                    if($hoy >$fecha_i_estrados){
                        //Si la solicitud no se ha mostrado en el plazo de 20 días se hace publica en estrados
                        $sdSolicitud->fecha_i_estrado = new \Phalcon\Db\RawValue('SYSDATE');
                    }
                }

                //Obtenemos la fecha limite para tener en el panel de estrados la solicitud
                $fecha_f_estrados = $this->getFechaPrevencion(50, $solicitud["FECHA_I"], $solicitud["HORA_I"]);

                //Agregamos fecha final de estrados
                if ($fecha_f_estrados) {
                    $sdSolicitud->fecha_f_estrado = new \Phalcon\Db\RawValue("TO_DATE('" . $fecha_f_estrados . "', 'DD/MM/YYYY')");
                }

                if ($sdSolicitud->save() == false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     *  Valida que las solicitudes tengan condicion
     *  @return boolean con la respuesta
     *  @author Dora Nely Vega Gonzalez
     */
    public function validarCondicion()
    {
        $phql = "SELECT H.id_solicitud AS ID_SOLICITUD, H.n_etapa_id AS N_ETAPA_ID, H.id_flujo AS ID_FLUJO
                 FROM SdSolicitudHistorial H
                 WHERE  H.id IN(SELECT MAX (SdSolicitudHistorial.id) FROM SdSolicitudHistorial GROUP BY SdSolicitudHistorial.id_solicitud)
                 ORDER BY  H.id_solicitud";

        //obtiene los registros del modelo solicitudes
        $solicitudes = $this->modelsManager->executeQuery($phql);

        foreach ($solicitudes as $solicitud){
            //Hacemos la búsqueda de las transacciones
            $transacciones = SdFlujoTransaccion::query()
                ->columns(array("ID_TRANSACCION"=>"SdFlujoTransaccion.id", "CONDICION"=>"SdFlujoCondicion.valor", "FORMULARIO"=>"SdFlujoTransaccion.formulario"))
                ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoEstadoTransaccion')
                ->innerJoin('SdFlujoEstado', "SdFlujoEstado.id = SdFlujoEstadoTransaccion.id_estado", 'SdFlujoEstado')
                ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                ->innerJoin('SdFlujoEtapa', "SdFlujoEtapa.id = SdFlujoEtapaEstado.id_etapa", 'SdFlujoEtapa')
                ->leftJoin('SdFlujoCondicion', "SdFlujoCondicion.id = SdFlujoTransaccion.condicion", 'SdFlujoCondicion')
                ->conditions("SdFlujoEtapa.id=:n_etapa_id:")
                ->bind(['n_etapa_id'=>$solicitud->N_ETAPA_ID])
                ->orderBy("SdFlujoTransaccion.formulario")
                ->execute();

            //Si la transaccion tiene una condición a validar
            if(!empty($transacciones[0]->CONDICION)){
                //Generamos la consulta para validar la condición
                $phql = trim($transacciones[0]->CONDICION);

                //Validamos que sea la solicitud seleccionada
                $aprobada  = $this->modelsManager->executeQuery($phql, ["id_solicitud" => $solicitud->ID_SOLICITUD]);

                if(count($aprobada) > 0){
                   $idTransaccion =  $transacciones[0]->ID_TRANSACCION;
                } else{
                    $idTransaccion =  $transacciones[1]->ID_TRANSACCION;
                }

                if ( $this->cambiarEtapa($solicitud->ID_SOLICITUD, $idTransaccion) == false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     *  Cambiamos etapa en base al flujo de la solciitud
     *  @return boolean respuesta
     *  @author Dora Nely Vega González
     *  @throws
     */
    public function cambiarEtapa($idSolicitud, $idTransaccion = '')
    {
        $respuesta = true;

        //Hacemos la búsqueda de la solicitud para obtener su etapa y transacciones
        $sdSolicitud = SdSolicitud::query()
            ->columns(array('ID_SOLICITUD'=>"SdSolicitud.id_solicitud",'FOLIO'=>'SdSolicitud.folio', 'NOMBRE'=> "SdSolicitante.nombre",
                'ID_FLUJO'=>"SdSolicitud.id_flujo",'TIPO'=>"SdSolicitudTipo.tipo", 'DESCRIPCION'=>"SdSolicitudTipo.descripcion",'ANONIMO'=>"SdSolicitante.anonimo",
                'CORREO'=>"SdSolicitante.correo", 'APELLIDO_PATERNO'=>"SdSolicitante.apellido_paterno",'APELLIDO_MATERNO'=>"SdSolicitante.apellido_materno"))
            ->innerJoin('SdSolicitudSolicitante', "SdSolicitudSolicitante.id_solicitud = SdSolicitud.id_solicitud", 'SdSolicitudSolicitante')
            ->innerJoin('SdSolicitante', "SdSolicitante.id_solicitante = SdSolicitudSolicitante.id_solicitante", 'SdSolicitante')
            ->innerJoin('SdSolicitudTipo', "SdSolicitudTipo.id_tipo = SdSolicitud.id_tipo", 'SdSolicitudTipo')
            ->conditions('SdSolicitud.id_solicitud=:id_solicitud:  AND SdSolicitud.estatus=:estatus: ')
            ->bind(['id_solicitud' => $idSolicitud, 'estatus'=>'AC'])
            ->execute()->getFirst();

        if($sdSolicitud) {
            //Validamos que  la variable de envio de alertas eeste en cero
            $solicitud = SdSolicitud::findFirst($sdSolicitud["ID_SOLICITUD"]);
            $solicitud->alerta = 0;

            if ($solicitud) {
                if (!$solicitud->save()) {
                    return false;
                }
            }
            //Validamos si se va a iniciar el flujo de la solicitud
            if (empty($idTransaccion)) {
                //Hacemos la búsqueda de las acciones de la etapa principal
                $etapaPrincipal = SdFlujoEtapa::query()
                    ->columns(array( 'ID_TRANSACCION' => 'SdFlujoEstadoTransaccion.id_transaccion'))
                    ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_etapa = SdFlujoEtapa.id", 'SdFlujoEtapaEstado')
                    ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_estado = SdFlujoEtapaEstado.id_estado", 'SdFlujoEstadoTransaccion')
                    ->conditions("SdFlujoEtapa.id_flujo=:id_flujo: AND SdFlujoEtapa.estatus=:estatus: AND SdFlujoEtapa.principal=:principal:")
                    ->bind(['id_flujo' => $sdSolicitud->ID_FLUJO, 'estatus' => 'AC', 'principal' => 1])
                    ->execute()->getFirst();

                if($etapaPrincipal){
                    $idTransaccion = $etapaPrincipal->ID_TRANSACCION;
                }
            }
            //Hacemos la búsqueda de las acciones en base a la transacción
            $acciones = SdFlujoAccion::query()
                ->columns(array(
                    'ID_ETAPA' => "SdFlujoEtapa.id", 'ETAPA' => 'SdFlujoEtapa.nombre',
                    'N_ETAPA_ID' => "SdFlujoAccion.n_etapa_id", 'N_ETAPA' => 'SdFlujoAccion.n_etapa',
                    'ID_ESTADO' => 'SdFlujoEstado.id','ESTADO' => 'SdFlujoEstado.nombre',
                    'N_ESTADO_ID' => 'SdFlujoAccion.n_estado_id','N_ESTADO' => 'SdFlujoAccion.n_estado',
                    'ID_TRANSACCION' => 'SdFlujoTransaccion.id', 'TRANSACCION' => 'SdFlujoTransaccion.nombre',
                    'TIPO' => "SdFlujoAccion.tipo", "PREVENCION" => "SdPrevencion.nombre"))
                ->innerJoin('SdFlujoTransaccionAccion', "SdFlujoTransaccionAccion.id_accion = SdFlujoAccion.id", 'SdFlujoTransaccionAccion')
                ->innerJoin('SdFlujoTransaccion', "SdFlujoTransaccion.id = SdFlujoTransaccionAccion.id_transaccion", 'SdFlujoTransaccion')
                ->innerJoin('SdFlujoEstadoTransaccion', "SdFlujoEstadoTransaccion.id_transaccion = SdFlujoTransaccion.id", 'SdFlujoEstadoTransaccion')
                ->innerJoin('SdFlujoEstado', "SdFlujoEstado.id = SdFlujoEstadoTransaccion.id_estado", 'SdFlujoEstado')
                ->innerJoin('SdFlujoEtapaEstado', "SdFlujoEtapaEstado.id_estado = SdFlujoEstado.id", 'SdFlujoEtapaEstado')
                ->innerJoin('SdFlujoEtapa', "SdFlujoEtapa.id = SdFlujoEtapaEstado.id_etapa", 'SdFlujoEtapa')
                ->leftJoin('SdPrevencion', "SdPrevencion.id = SdFlujoTransaccion.id_prevencion", 'SdPrevencion')
                ->conditions("SdFlujoEtapa.id_flujo=:id_flujo: AND SdFlujoEtapa.estatus=:estatus: AND SdFlujoTransaccion.id=:id_transaccion:")
                ->bind(['id_flujo' => $sdSolicitud->ID_FLUJO, 'estatus' => 'AC', 'id_transaccion' => $idTransaccion])
                ->execute()->toArray();

            if (count($acciones) > 0) {
                foreach ($acciones as $accion) {
                    switch ($accion['TIPO']) {
                        case 'INSERT':
                              $secuencia = $this->db->query('SELECT SD_SOLICITUD_HISTORIAL_SEQ.nextval FROM dual');
                              $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                              $secuencia = $secuencia->fetchAll($secuencia);

                              //Registramos en el historial la solicitud
                              $historial = new SdSolicitudHistorial();
                              $historial->id = $secuencia[0]['NEXTVAL'];
                              $historial->id_solicitud = $sdSolicitud->ID_SOLICITUD;
                              $historial->id_flujo =  $sdSolicitud->ID_FLUJO;
                              $historial->id_etapa =  $accion['ID_ETAPA'];
                              $historial->etapa =  $accion['ETAPA'];
                              $historial->n_etapa_id =  $accion['N_ETAPA_ID'];
                              $historial->n_etapa =  $accion['N_ETAPA'];
                              $historial->id_estado =  $accion['ID_ESTADO'];
                              $historial->estado=  $accion['ESTADO'];
                              $historial->n_estado_id =  $accion['N_ESTADO_ID'];
                              $historial->n_estado=  $accion['N_ESTADO'];
                              $historial->id_transaccion =  $accion['ID_TRANSACCION'];
                              $historial->transaccion =  $accion['TRANSACCION'];
                              $historial->usuario_i = $this->session->usuario['usuario'];
                              $historial->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                              $historial->estatus = 'AC';

                              if ($historial->save() ==false ) {
                                  $respuesta = false;
                              }
                              break;

                        case 'GENERAR':

                            require_once("autoload.php");

                            $folio = $sdSolicitud->FOLIO;
                            $ruta_solicitudes = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_solicitudes\'');
                            $ruta_prevencion = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_prevencion\'');
                            $path = $ruta_solicitudes[0]->VALOR . $folio;
                            $ruta = $ruta_solicitudes[0]->VALOR . $folio . $ruta_prevencion[0]->VALOR;
                            $nombreDocumento =  $folio . '_' . $accion['PREVENCION'];

                            if($sdSolicitud->TIPO == 'SAI'){
                                $html = $this->view->getRender('email_sai', $accion['PREVENCION'],["solicitud" => $sdSolicitud]);
                            }else{
                                $html = $this->view->getRender('email_arco', $accion['PREVENCION'],["solicitud" => $sdSolicitud]);
                            }

                            //Iniciamos la libreria para generar pdf
                            $mpdf = new \Mpdf\Mpdf();
                            $mpdf->WriteHTML($html);

                            //Encabezados necesarios para generar pdf
                            header('Content-Type: application/pdf');
                            header('Cache-Control: max-age=0');

                            //Almacenamos el documento en la carpeta temp
                            $location = __DIR__ . '/mpdf/mpdf/tmp/temp.pdf';
                            $mpdf->Output($location, \Mpdf\Output\Destination::FILE);

                            //iniciamos la conexión
                            $sftp = new Sftp();
                            $sftp->connect();

                            //Creamos el directorio de la solicitud en el servidor
                            $sftp->mkdir($path);
                            $sftp->mkdir($ruta);

                            //desconectamos
                            $sftp->disconnect();

                            //Hacemos la búsqueda del tipo de documento
                            $sdMimetype= SdDocumentoMimetype::findFirst([
                                'conditions' => 'extension=:extension: and estatus=:estatus: ',
                                'bind' => ['extension' => 'pdf', 'estatus'=>'AC']]);

                            if($sdMimetype) {
                                $secuencia = $this->db->query('SELECT SD_DOCUMENTO_SOLICITUD_SEQ.nextval FROM dual');
                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                $secuencia = $secuencia->fetchAll($secuencia);

                                //Almacenamos la información del documento en el historial de la solicitud
                                $sdDocumento = new SdDocumentoSolicitud();
                                $sdDocumento->id_documento = $secuencia[0]['NEXTVAL'];
                                $sdDocumento->id_solicitud = $sdSolicitud->ID_SOLICITUD;
                                $sdDocumento->nombre = $nombreDocumento;
                                $sdDocumento->extension = $sdMimetype->extension;
                                $sdDocumento->mimetype = $sdMimetype->id_mimetype;
                                $sdDocumento->ruta = $ruta;
                                $sdDocumento->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                                $sdDocumento->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                $sdDocumento->estatus = 'AC';

                                if ($sdDocumento) {
                                    if (!$sdDocumento->save()) {
                                        return false;
                                    }
                                    //Guardamos el documento en el servidor
                                    $sftp->putfile($location, $ruta . $nombreDocumento.'.pdf');
                                } else {
                                    return false;
                                }
                                return true;
                            }

                            break;

                        case 'NOTIFICACION':

                            //Inicializamos la libreria email
                            $mail = new Email();

                            $folio = $sdSolicitud->FOLIO;
                            $extension = 'pdf';
                            $ruta_solicitudes = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_solicitudes\'');
                            $ruta_prevencion = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_prevencion\'');
                            $remote_file = $ruta_solicitudes[0]->VALOR . $folio. $ruta_prevencion[0]->VALOR . $folio . '_' . $accion['PREVENCION'] . '.' . $extension;

                            //iniciamos la conexión
                            $sftp = new Sftp();
                            $sftp->connect();

                            if(!empty($remote_file)) {
                                $remote_file = $sftp->listPath($remote_file);
                            }

                            //desconectamos la conexión
                            $sftp->disconnect();

                            //datos para enviar el correo electronico
                            $datos = [
                                'to' => $sdSolicitud->CORREO,
                                'cc' => array('doronellvg@gmail.com'),
                                'subject' => $folio . ' Notificación de ' . $sdSolicitud->DESCRIPCION,
                                'attachment' => [
                                    'path' => $remote_file,
                                    'name' =>   $folio . '_' . $accion['PREVENCION'] . '.' . $extension,
                                    'encoding' => ' base64',
                                    'type' => 'application/pdf',
                                ]
                            ];

                            //Utilizamos el template del email
                            if($sdSolicitud->TIPO == 'SAI'){
                                $html = $this->view->getRender('email_sai', "template", $datos);
                            }else{
                                $html = $this->view->getRender('email_arco', "template", $datos);
                            }

                            //Enviamos el correo electronico
                            if (!$mail->sendEmail($datos['to'], $datos['cc'], $datos['subject'], $html, $datos['attachment'])) {
                                $respuesta = false;
                            }

                            break;

                        case 'TURNAR':

                            //Inicializamos la libreria email
                            $mail = new Email();

                            //Hacemos la búsqueda de las dependencias turnadas a la solicitud
                            $dependencias = SdPreguntaDependencia::query()
                                ->columns(array('ID_DEPENDENCIA' => "SdPreguntaDependencia.id_dependencia"))
                                ->innerJoin('SdPregunta', "SdPregunta.id_pregunta = SdPreguntaDependencia.id_pregunta", 'SdPregunta')
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
                                ->conditions('SdSolicitud.id_solicitud=:id_solicitud: AND SdPreguntaDependencia.estatus=:estatus:')
                                ->bind(['id_solicitud' => $idSolicitud, 'estatus' => 'AC'])
                                ->execute();

                            foreach ($dependencias as $dependencia){

                                //Hacemos la búsqueda de los usuarios a enviar el correo
                                $usuarios = SdUsuarioDependencia::query()
                                    ->columns(array('CORREO' => "SdUsuario.correo",'NOMBRE' => "SdUsuario.nombre"))
                                    ->innerJoin('SdUsuario', "SdUsuario.id = SdUsuarioDependencia.id_usuario", 'SdUsuario')
                                    ->innerJoin('SdUsuarioRol', "SdUsuarioRol.id_usuario = SdUsuario.id", 'SdUsuarioRol')
                                    ->innerJoin('SdRol', "SdRol.id = SdUsuarioRol.id_rol", 'SdRol')
                                    ->conditions('SdUsuarioDependencia.id_dependencia=:id_dependencia: AND 
                                    SdRol.nombre LIKE :nombre: AND SdUsuarioDependencia.estatus=:estatus:')
                                    ->bind(['id_dependencia' => $dependencia->ID_DEPENDENCIA, 'estatus' => 'AC', 'nombre' => 'DEPENDENCIA'])
                                    ->execute();

                                foreach ($usuarios as $usuario){
                                    //Datos para enviar el correo electronico
                                    $datos = [
                                        'to' => $usuario->CORREO,
                                        'cc' => array('doronellvg@gmail.com'),
                                        'subject' =>' Turnado de dependencia '
                                    ];

                                    //Utilizamos el template del email para el turnado
                                    if($sdSolicitud->TIPO == 'SAI'){
                                        $html = $this->view->getRender('email_sai', "turnado", $datos);
                                    }else{
                                        $html = $this->view->getRender('email_arco', "turnado", $datos);
                                    }

                                    //Enviamos el correo electronico
                                    if (!$mail->sendEmail($datos['to'], $datos['cc'], $datos['subject'], $html)) {
                                        $respuesta = false;
                                    }
                                }
                            }

                            break;

                        case 'TURNAR_UAR':

                            //Inicializamos la libreria email
                            $mail = new Email();

                            //Hacemos la búsqueda de las dependencias turnadas a la solicitud
                            $dependencias = SdPreguntaDependencia::query()
                                ->columns(array('ID_DEPENDENCIA' => "SdPreguntaDependencia.id_dependencia"))
                                ->innerJoin('SdPregunta', "SdPregunta.id_pregunta = SdPreguntaDependencia.id_pregunta", 'SdPregunta')
                                ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdPregunta.id_solicitud", 'SdSolicitud')
                                ->conditions('SdSolicitud.id_solicitud=:id_solicitud: AND SdPreguntaDependencia.estatus=:estatus:')
                                ->bind(['id_solicitud' => $idSolicitud, 'estatus' => 'AC'])
                                ->execute();

                            foreach ($dependencias as $dependencia){

                                //Hacemos la búsqueda de los usuarios a enviar el correo
                                $usuarios = SdUsuarioDependencia::query()
                                    ->columns(array('CORREO' => "SdUsuario.correo",'NOMBRE' => "SdUsuario.nombre"))
                                    ->innerJoin('SdUsuario', "SdUsuario.id = SdUsuarioDependencia.id_usuario", 'SdUsuario')
                                    ->innerJoin('SdUsuarioRol', "SdUsuarioRol.id_usuario = SdUsuario.id", 'SdUsuarioRol')
                                    ->innerJoin('SdRol', "SdRol.id = SdUsuarioRol.id_rol", 'SdRol')
                                    ->conditions('SdUsuarioDependencia.id_dependencia=:id_dependencia: AND
                                     SdRol.nombre LIKE :nombre: AND SdUsuarioDependencia.estatus=:estatus:')
                                    ->bind(['id_dependencia' => $dependencia->ID_DEPENDENCIA, 'estatus' => 'AC', 'nombre' => 'UAR'])
                                    ->execute();

                                foreach ($usuarios as $usuario){
                                    //Datos para enviar el correo electronico
                                    $datos = [
                                        'to' => $usuario->CORREO,
                                        'cc' => array('doronellvg@gmail.com'),
                                        'subject' =>' Turnado de dependencia '
                                    ];

                                    //Utilizamos el template del email para el turnado a la uar
                                    if($sdSolicitud->TIPO == 'SAI'){
                                        $html = $this->view->getRender('email_sai', "turnado_uar", $datos);
                                    }else{
                                        $html = $this->view->getRender('email_arco', "turnado_uar", $datos);
                                    }

                                    //Enviamos el correo electronico
                                    if (!$mail->sendEmail($datos['to'], $datos['cc'], $datos['subject'], $html)) {
                                        $respuesta = false;
                                    }
                                }
                            }

                            break;
                    }
                }
            }
        }
        return $respuesta;
    }

    /**
     *  Funcion que realiza la descarga del documento
     *  @author Dora Nely Vega González
     */
    public function descargarDoc($directorio, $documento, $mimetype)
    {
        require_once("autoload.php");

        try {
            $client = new \GuzzleHttp\Client();
            $user = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'server_usuario\'');
            $password = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'server_password\'');
            $ruta = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'server_ruta\'');

            $response = $client->request('GET', sprintf('%s%s%s', $ruta[0]->VALOR, $directorio, $documento), [
                'auth' => [$user[0]->VALOR, $password[0]->VALOR],
                'stream' => true
            ]);

            if ($response->getStatusCode() == '200') {
                $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Set-Cookie: fileDownload=true; path=/');
                header('Content-Description: File Transfer');
                header('Content-type:' . $mimetype);
                header('Content-Disposition: attachment;filename="' . $documento . '"');
                header('Set-Cookie: fileDownload=true; path=/');
                $body = $response->getBody();

                while (!$body->eof()) {
                    echo $body->read(1024);
                }
            } else {
                header('Content-type: text/html');
                echo sprintf('<span>Ocurrió un error al descargar el archivo %s.</span>', $documento);
            }
        } catch(Exception $e) {
            header('Content-type: text/html');
            echo sprintf('<span>Ocurrió un error al descargar el archivo %s.</span>', $documento);
        }
        return true;
    }
}
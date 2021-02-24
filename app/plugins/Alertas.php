<?php
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

/*
 * COPYRIGHT © 2019. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * SAIDA IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

class Alertas extends Plugin
{
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{   
	    \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $funcion = new Funciones();

        //Obtenemos las solicitudes activas del sistema
        $solicitudes = SdSolicitudHistorial::query()
            ->columns(array('ID_SOLICITUD' => "SdSolicitud.id_solicitud",  'FOLIO' => "SdSolicitud.folio",
                'FECHA_I' => "to_char(SdSolicitudHistorial.fecha_i,'DD/MM/YYYY')",'ETAPA' => "SdSolicitudHistorial.etapa",
                'HORA_I' => "to_char(SdSolicitudHistorial.fecha_i,'HH24:MI')", 'DIAS_UTPE' => "SdFlujoEstadoPlazos.dias_utpe"))
            ->innerJoin('SdSolicitud', "SdSolicitud.id_solicitud = SdSolicitudHistorial.id_solicitud", 'SdSolicitud')
            ->innerJoin('SdFlujoEstadoPlazos', "SdFlujoEstadoPlazos.id_estado = SdSolicitudHistorial.id_estado", 'SdFlujoEstadoPlazos')
            ->conditions("SdSolicitud.estatus='AC' AND SdSolicitud.alerta='0' AND
             SdSolicitudHistorial.id IN(SELECT MAX (SdSolicitudHistorial.id) FROM SdSolicitudHistorial GROUP BY SdSolicitudHistorial.id_solicitud)")
            ->execute()->toArray();

        foreach ($solicitudes as $solicitud){
            //Obtenemos la fecha limite del plazo seleccionado por estado
            $fecha_limite = $funcion->getFechaPrevencion($solicitud["DIAS_UTPE"], $solicitud["FECHA_I"], $solicitud["HORA_I"]);

            //Validamos que las solicitudes no tengan más dias de la fecha limite si no se envia correo de alerta
            if (!empty($fecha_limite) && !empty($solicitud["FECHA_I"])){

                $hoy = date('d/m/Y');
                $hoy = DateTime::createFromFormat("d/m/Y", $hoy);
                $fecha_limite = DateTime::createFromFormat("d/m/Y", $fecha_limite);

                if($hoy > $fecha_limite){

                    $mail = new Email();

                    $usuarios = SdUsuario::query()
                        ->columns(array('NOMBRE' => 'SdUsuario.nombre', 'CORREO' => 'SdUsuario.correo'))
                        ->innerJoin('SdUsuarioRol', "SdUsuarioRol.id_usuario = SdUsuario.id", 'SdUsuarioRol')
                        ->innerJoin('SdRol', "SdRol.id = SdUsuarioRol.id_rol", 'SdRol')
                        ->conditions("UPPER(translate(SdRol.nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:)
                         AND SdUsuario.estatus=:estatus: AND SdUsuarioRol.estatus=:estatus:")
                        ->bind(['nombre' => '%' . strtr(strtoupper(trim("UTPE")) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus' => 'AC'])
                        ->execute();

                    foreach ($usuarios as $usuario){

                        //Datos para enviar el correo electronico
                        $datos = [
                            'to' => $usuario->CORREO,
                            'cc' => array('doronellvg@gmail.com'),
                            'subject' => $solicitud["FOLIO"] . ' Notificación de alerta de plazos en etapa ' . $solicitud["ETAPA"]
                        ];
                    }

                    //Utilizamos el template del email
                    $html = $this->view->getRender('email', "alerta", $datos);

                    //Enviamos el correo electronico
                    if (!$mail->sendEmail($datos['to'], $datos['cc'], $datos['subject'], $html)) {
                        return false;
                    }else{
                        $sdSolicitud = SdSolicitud::findFirst($solicitud["ID_SOLICITUD"]);
                        $sdSolicitud->alerta = 1;
                        if ($sdSolicitud) {
                            if (!$sdSolicitud->save()) {
                                return false;
                            }
                        }
                    }
                }
            }
        }
        return true;
	}
}
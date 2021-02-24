<?php

/*
 * COPYRIGHT © 2019. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * SAIDA IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

/**
 *  lógica para enviar email dentro del sistema
 *  @author Raúl Alejandro Verde Martínez
 */
class Email extends Phalcon\Mvc\User\Component {

	public function __construct()
	{
		if (!isset($this->persistent->emailServer))
		{
		    //obtenemos los datos de conexión al servidor de email
			$server = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'email_servidor\'');
			$port = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'email_puerto\'');
			$user = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'email_usuario\'');
			$password = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'email_password\'');
			$from = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'email_from\'');
			$title = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'email_title\'');

			$emailServer = [
				'emailHost' => trim($server[0]->VALOR),
				'emailPort' => trim($port[0]->VALOR),
				'emailUser' => trim($user[0]->VALOR),
				'emailPass' => trim($password[0]->VALOR),
				'emailFrom' => trim($from[0]->VALOR),
				'emailTitle' => trim($title[0]->VALOR)
			];

			$this->persistent->emailServer = $emailServer;
		}
	}
    /**
     *  lógica para hacer el envío de email
     *  @author Raúl Alejandro Verde Martínez
     */
	function sendEmail($to, $cc = array(), $subject, $body, $attachment = array()) {
		$emailServer = $this->persistent->emailServer;
		$mail = new PHPMailer();

		try {
			//Server settings
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Host = $emailServer['emailHost'];
			$mail->SMTPAuth = false;
			$mail->Port =  $emailServer['emailPort'];

			//Recipients
			$mail->setFrom( $emailServer['emailFrom'],  $emailServer['emailTitle']);
			$mail->addAddress(trim($to));

			if (count($cc) > 0) {
				foreach ($cc as $key => $value) {
					if (!empty(trim($value))) {
						$mail->addCC(trim($value));
					}
				}
			}

			//Adjuntamos los documentos
			if (count($attachment) > 0) {
				foreach ($attachment as $key => $value) {
					if (isset($value)){
						$mail->addAttachment($value);
					}
				}
			}

			//Content
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';
			$mail->Subject = trim($subject);
			$mail->Body    = trim($body);
			$mail->send();

			return true;
		} catch (Exception $e) {
			return false;
		}
	}
}
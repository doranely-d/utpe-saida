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

class Headers extends Plugin
{
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
        //Se agregan los encabezados  sobre las Políticas de seguridad para servicios y aplicaciones web
        $this->response->setHeader('Content-Security-Policy', " frame-ancestors 'none'; script-src 'unsafe-eval' 'unsafe-inline' 'self' https://www.gstatic.com https://maps.googleapis.com; object-src 'none'; base-uri 'none'");
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader("X-XSS-Protection: 1","mode=block");
        $this->response->setHeader('Referrer-Policy', "no-referrer-when-downgrade");
        $this->response->setHeader('X-Frame-Options', 'DENY');
        $this->response->setHeader('Feature-Policy', "geolocation 'none'");
        $this->response->setHeader('X-Content-Type-Options', 'nosniff');
	}
}
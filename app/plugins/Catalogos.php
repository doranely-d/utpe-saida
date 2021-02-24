<?php
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

/*
 * COPYRIGHT © 2019. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

class Catalogos extends Plugin
{
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
        $registros = $this->modelsManager->executeQuery(
            'SELECT id_estado as ID_ESTADO, estado AS ESTADO FROM SdEstados WHERE estatus = \'AC\'  ORDER BY id_estado ASC'
        );

        file_put_contents('json/estados.json', json_encode($registros));

        $registros = $this->modelsManager->executeQuery(
            'SELECT id_tema as ID_TEMA, tema AS TEMA FROM SdTema WHERE estatus = \'AC\'  ORDER BY id_tema ASC'
        );

        file_put_contents('json/temas.json', json_encode($registros));

        $registros = $this->modelsManager->executeQuery(
            'SELECT id_medio_respuesta as ID_MEDIO_RESPUESTA, medio AS MEDIO, costo AS COSTO, 0 AS TOTAL, 0 as CANTIDAD
            FROM SdMedioRespuesta WHERE estatus = \'AC\'  ORDER BY id_medio_respuesta ASC'
        );

        file_put_contents('json/mediosRespuesta.json', json_encode($registros));

        $registros = $this->modelsManager->executeQuery(
            'SELECT id_medio_respuesta as ID_MEDIO_RESPUESTA, medio AS MEDIO, costo AS COSTO, 0 AS TOTAL, 0 as CANTIDAD
            FROM SdMedioRespuesta WHERE estatus = \'AC\'  ORDER BY id_medio_respuesta ASC'
        );

       /* $registros  = $query = $this->modelsManager->executeQuery("SELECT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION, hierarchy AS HIERARCHY, agrupador AS AGRUPADOR
                              FROM XxhrPqHierarchyV 
                              WHERE (HIERARCHY = '17' OR HIERARCHY = '18')
                              AND (flex_value LIKE '1%' OR flex_value LIKE '2%' OR flex_value LIKE '3%' OR flex_value LIKE '5%')
                              GROUP BY flex_value, flex_value_id, description, hierarchy, agrupador
                              ORDER BY flex_value");

        file_put_contents('json/dependencias.json', json_encode($registros));*/

    }
}
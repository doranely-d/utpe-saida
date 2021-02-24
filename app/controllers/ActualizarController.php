<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ActualizarController extends ControllerBase
{
	public $mensaje = ''; //mensaje del resultado
	public $resultado = array(); //respuesta
	public $msnError = ''; //mensaje de error

	public function initialize()
	{
		$this->tag->setTitle('Actualizar catálogo');
		parent::initialize();
	}

	/**  Vista donde se muestra el listado de acciones */
	public function indexAction()
    {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);

        $registros = $this->modelsManager->executeQuery(
            'SELECT id_estado as ID_ESTADO, estado AS ESTADO FROM SdEstados WHERE estatus = \'AC\'  ORDER BY id_estado ASC'
        );

        file_put_contents('json/estados.json', json_encode($registros));

        $registros = $this->modelsManager->executeQuery(
            'SELECT id_estado as ID_ESTADO, id_municipio AS ID_MUNICIPIO,  municipio AS MUNICIPIO FROM SdMunicipios WHERE estatus = \'AC\'  ORDER BY id_municipio ASC'
        );

        file_put_contents('json/municipios.json', json_encode($registros));

        $registros = $this->modelsManager->executeQuery(
            'SELECT id_tema as ID_TEMA, tema AS TEMA FROM SdTema WHERE estatus = \'AC\'  ORDER BY id_tema ASC'
        );

        file_put_contents('json/temas.json', json_encode($registros));

        // Llena el catalogo de sub_secretarias
        $registros = SdSubtema::query()
            ->columns(array('ID_SUBTEMA' => "SdSubtema.id_subtema",'SUBTEMA'=> 'SdSubtema.subtema', 'ID_TEMA' => "SdTema.id_tema",))
            ->innerJoin('SdTemaSubtema', "SdTemaSubtema.id_subtema = SdSubtema.id_subtema", 'SdTemaSubtema')
            ->innerJoin('SdTema', "SdTema.id_tema = SdTemaSubtema.id_tema", 'SdTema')
            ->conditions("SdSubtema.estatus='AC' AND SdTema.estatus='AC' AND SdTemaSubtema.estatus='AC'")
            ->execute();
        file_put_contents('json/subtemas.json', json_encode($registros));

        // Llena el catalogo de titulos
        $registros = SdTitulo::query()
            ->columns(array('ID_TITULO' => "SdTitulo.id_titulo",'TITULO'=> 'SdTitulo.titulo', 'ID_SUBTEMA' => "SdSubtema.id_subtema"))
            ->innerJoin('SdSubtemaTitulo', "SdSubtemaTitulo.id_titulo = SdTitulo.id_titulo", 'SdSubtemaTitulo')
            ->innerJoin('SdSubtema', "SdSubtema.id_subtema = SdSubtemaTitulo.id_subtema", 'SdSubtema')
            ->conditions("SdTitulo.estatus='AC' AND SdSubtemaTitulo.estatus='AC' AND SdSubtema.estatus='AC'")
            ->execute();
        file_put_contents('json/titulos.json', json_encode($registros));

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


        //obtiene los registros del modelo identidad_titular MAYOR_EDAD
        $identidadesMayor = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'MAYOR_EDAD', 'estatus'=>'AC'],
        ]);

        //obtiene los registros del modelo identidad_titular MENOR_EDAD
        $identidadesMenor = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'MENOR_EDAD', 'estatus'=>'AC'],
        ]);

        //obtiene los registros del modelo identidad_titular FALLECIDO
        $identidadesFallecido = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'FALLECIDO', 'estatus'=>'AC'],
        ]);

        //obtiene los registros del modelo identidad_titular PERSONA_FISICA
        $identidadesFisica = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'PERSONA_FISICA', 'estatus'=>'AC'],
        ]);

        //obtiene los registros del modelo identidad_titular PERSONA_MORAL
        $identidadesMoral = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'PERSONA_MORAL', 'estatus'=>'AC'],
        ]);

        //obtiene los registros del modelo identidad_titular PADRES
        $identidadesPadres = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'PADRES', 'estatus'=>'AC'],
        ]);

        //obtiene los registros del modelo identidad_titular TUTOR
        $identidadesTutor = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'TUTOR', 'estatus'=>'AC'],
        ]);
        //obtiene los registros del modelo identidad_titular TITULAR_FALLECIDO
        $identidadesTitularFallecido = SdAcreditacionIdentidad::find([
            'columns' => array('ID_DOCUMENTO' => "id_documento", 'DESCRIPCION'=> 'descripcion', 'ESTATUS_TITULAR' => 'estatus_titular', 'ESTATUS'=>'estatus'),
            'conditions' => 'estatus_titular=:estatus_titular: and estatus=:estatus: ',
            'bind' => ['estatus_titular' => 'TITULAR_FALLECIDO', 'estatus'=>'AC'],
        ]);

        if(count($identidadesMayor)  > 0 and count($identidadesMenor)  > 0 and count($identidadesFallecido)  > 0
            and count($identidadesFisica)  > 0 and count($identidadesMoral)  > 0
            and count($identidadesTutor)  > 0 and count($identidadesPadres)  > 0 and count($identidadesTitularFallecido)  > 0){
            $registros = ['MAYOR_EDAD' => $identidadesMayor, 'MENOR_EDAD' => $identidadesMenor, 'FALLECIDO' => $identidadesFallecido ,
                'PERSONA_FISICA' => $identidadesFisica,'PERSONA_MORAL' => $identidadesMoral,'PADRES' => $identidadesPadres ,
                'TUTOR' => $identidadesTutor, 'TITULAR_FALLECIDO' => $identidadesTitularFallecido];
            file_put_contents('json/campos.json', json_encode($registros));
        }

        return $this->response->redirect('admin');
    }
}
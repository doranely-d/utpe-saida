<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 22/05/2018
 * Time: 09:52 AM
 */

class SdPlazosPregunta extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Column(column="ID_ESTATUS", type="integer", length=7, nullable=false)
     */
    public $id_estatus;
    /**
     *
     * @var integer
     * @Column(column="ID_PREGUNTA", type="integer", length=7, nullable=false)
     */
    public $id_pregunta;

    /**
     *
     * @var integer
     * @Column(column="DIA_UTPE", type="integer", length=7, nullable=false)
     */
    public $dias_utpe;

    /**
     *
     * @var string
     * @Column(column="USUARIO_I", type="string", length=20, nullable=false)
     */
    public $usuario_i;

    /**
     *
     * @var string
     * @Column(column="FECHA_I", type="string", nullable=false)
     */
    public $fecha_i;

    /**
     *
     * @var string
     * @Column(column="USUARIO_U", type="string", length=20, nullable=false)
     */
    public $usuario_u;

    /**
     *
     * @var string
     * @Column(column="FECHA_U", type="string", nullable=false)
     */
    public $fecha_u;

    /**
     *
     * @var string
     * @Column(column="ESTATUS", type="string", length=5, nullable=false)
     */
    public $estatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("MGR_SAIDA");
        $this->setSource("sd_plazos_pregunta");
        $this->belongsTo('ID_ESTATUS', '\SdEstatusPregunta', 'ID_ESTATUS', ['alias' => 'SdEstatusPregunta']);
        $this->belongsTo('ID_PREGUNTA', '\SdPregunta', 'ID_PREGUNTA', ['alias' => 'SdPregunta']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_plazos_pregunta';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPlazosPregunta[]|SdPlazosPregunta|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPlazosPregunta|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_PLAZO' => 'id_plazo',
            'ID_ESTATUS' => 'id_estatus',
            'DIAS_UTPE' => 'dias_utpe',
            'DIAS_LEY' => 'dias_ley',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
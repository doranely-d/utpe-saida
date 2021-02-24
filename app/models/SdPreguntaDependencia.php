<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 16/05/2018
 * Time: 01:20 PM
 */

class SdPreguntaDependencia extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_PREGUNTA", type="integer", length=7, nullable=false)
     */
    public $id_pregunta;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_DEPENDENCIA", type="integer", length=7, nullable=false)
     */
    public $id_dependencia;
    /**
     *
     * @var string
     * @Column(column="FLEX_VALUE", type="string", length=15, nullable=false)
     */
    public $flex_value;
    /**
     *
     * @var string
     * @Column(column="DEPENDENCIA", type="string", length=250, nullable=false)
     */
    public $dependencia;

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
        $this->setSource("sd_pregunta_dependencia");
        $this->belongsTo('ID_PREGUNTA', '\SdPregunta', 'ID_PREGUNTA', ['alias' => 'SdPregunta']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_pregunta_dependencia';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPreguntaDependencia[]|SdPreguntaDependencia|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPreguntaDependencia|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_PREGUNTA' => 'id_pregunta',
            'ID_DEPENDENCIA' => 'id_dependencia',
            'FLEX_VALUE' => 'flex_value',
            'DEPENDENCIA' => 'dependencia',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 16/05/2018
 * Time: 01:20 PM
 */

class SdPregunta extends \Phalcon\Mvc\Model
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
     * @Column(column="ID_SOLICITUD", type="integer", length=7, nullable=false)
     */
    public $id_solicitud;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=250, nullable=false)
     */
    public $descripcion;

    /**
     *
     * @var string
     * @Column(column="OBSERVACIONES", type="string", length=250, nullable=false)
     */
    public $observaciones;

    /**
     *
     * @var integer
     * @Column(column="ID_ESTATUS", type="integer", length=5, nullable=false)
     */
    public $id_estatus;

    /**
     *
     * @var integer
     * @Column(column="TURNADO", type="integer", length=5, nullable=false)
     */
    public $turnado;

    /**
     *
     * @var integer
     * @Column(column="FECHA_TURNADO", type="string", length=8, nullable=false)
     */
    public $fecha_turnado;

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
        $this->setSource("sd_pregunta");
        $this->belongsTo('ID_SOLICITUD', '\SdSolicitud', 'ID_SOLICITUD', ['alias' => 'SdSolicitud']);
        $this->belongsTo('ID_ESTATUS', '\SdEstatusPregunta', 'ID_ESTATUS', ['alias' => 'SdEstatusPregunta']);
        $this->hasMany('ID_PREGUNTA', 'SdPreguntaDependencia', 'ID_PREGUNTA', ['alias' => 'SdPreguntaDependencia']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_pregunta';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPregunta[]|SdPregunta|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPregunta|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_PREGUNTA' => 'id_pregunta',
            'ID_SOLICITUD' => 'id_solicitud',
            'DESCRIPCION' => 'descripcion',
            'OBSERVACIONES' => 'observaciones',
            'ID_ESTATUS' => 'id_estatus',
            'TURNADO' => 'turnado',
            'FECHA_TURNADO' => 'fecha_turnado',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
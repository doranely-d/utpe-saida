<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 22/06/2018
 * Time: 11:49 AM
 */

class SdFlujo  extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_FLUJO", type="integer", length=7, nullable=false)
     */
    public $id_flujo;

    /**
     *
     * @var integer
     * @Column(column="ID_TIPO", type="integer", length=7, nullable=false)
     */
    public $id_tipo;

    /**
     *
     * @var string
     * @Column(column="NOMBRE", type="string", length=250, nullable=false)
     */
    public $nombre;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=250, nullable=false)
     */
    public $descripcion;

    /**
     *
     * @var string
     * @Column(column="APROBADO", type="string", length=5, nullable=false)
     */
    public $aprobado;

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
        $this->setSource("sd_flujo");
        $this->hasMany('ID_TIPO', 'SdSolicitudTipo', 'ID_TIPO', ['alias' => 'SdSolicitudTipo']);
        $this->hasMany('ID_FLUJO', 'SdFlujoAccion', 'ID_FLUJO', ['alias' => 'SdFlujoAccion']);
        $this->hasMany('ID_FLUJO', 'SdFlujoEstado', 'ID_FLUJO', ['alias' => 'SdFlujoEstado']);
        $this->hasMany('ID_FLUJO', 'SdFlujoEtapa', 'ID_FLUJO', ['alias' => 'SdFlujoEtapa']);
        $this->hasMany('ID_FLUJO', 'SdFlujoTransaccion', 'ID_FLUJO', ['alias' => 'SdFlujoTransaccion']);
        $this->hasMany('ID_FLUJO', 'SdSolicitud', 'ID_FLUJO', ['alias' => 'SdSolicitud']);
        $this->hasMany('ID_FLUJO', 'SdSolicitudHistorial', 'ID_FLUJO', ['alias' => 'SdSolicitudHistorial']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_flujo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdFlujo[]|SdFlujo|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdFlujo|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_FLUJO' => 'id_flujo',
            'ID_TIPO' => 'id_tipo',
            'NOMBRE' => 'nombre',
            'DESCRIPCION' => 'descripcion',
            'APROBADO' => 'aprobado',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
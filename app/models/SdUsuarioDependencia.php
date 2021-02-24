<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 03/05/2018
 * Time: 03:05 PM
 */

class SdUsuarioDependencia extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_USUARIO", type="integer", length=7, nullable=false)
     */
    public $id_usuario;

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
     * @Column(column="CLAVE", type="string", length=15, nullable=false)
     */
    public $clave;
    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=250, nullable=false)
     */
    public $descripcion;

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
        $this->setSource("sd_usuario_dependencia");
        $this->belongsTo('ID_USUARIO', '\SdUsuario', 'ID', ['alias' => 'SdUsuario']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_usuario_dependencia';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdUsuarioDependencia[]|SdUsuarioDependencia|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdUsuarioDependencia|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_USUARIO' => 'id_usuario',
            'ID_DEPENDENCIA' => 'id_dependencia',
            'CLAVE' => 'clave',
            'DESCRIPCION' => 'descripcion',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
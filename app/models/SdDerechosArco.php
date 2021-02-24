<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 14/05/2018
 * Time: 02:20 PM
 */

class SdDerechosArco extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_DEDECHO", type="integer", length=7, nullable=false)
     */
    public $id_derecho;

    /**
     *
     * @var string
     * @Column(column="DERECHO", type="string", length=250, nullable=false)
     */
    public $derecho;

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
        $this->setSource("sd_derechos_arco");
        $this->hasMany('ID_DERECHO', 'SdSolicitud', 'ID_DERECHO_ARCO', ['alias' => 'SdSolicitud']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_derechos_arco';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdDerechosArco[]|SdDerechosArco|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdDerechosArco|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_DERECHO' => 'id_derecho',
            'DERECHO' => 'derecho',
            'DESCRIPCION' => 'descripcion',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
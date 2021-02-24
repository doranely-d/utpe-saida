<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 19/06/2018
 * Time: 10:43 AM
 */

class SdSolicitanteHistorial  extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_HISTORIAL", type="integer", length=7, nullable=false)
     */
    public $id_historial;

    /**
     *
     * @var integer
     * @Column(column="ID", type="integer", length=7, nullable=false)
     */
    public $id;
    /**
     *
     * @var string
     * @Column(column="MENSAJE", type="string", length=250, nullable=false)
     */
    public $mensaje;
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
        $this->setSource("sd_solicitante_historial");
        $this->belongsTo('ID_SOLICITANTE', '\SdSolicitante', 'ID_SOLICITANTE', ['alias' => 'SdSolicitante']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_solicitante_historial';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitanteHistorial[]|SdSolicitanteHistorial|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitanteHistorial|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID' => 'id',
            'ID_SOLICITANTE' => 'id_solicitante',
            'MENSAJE' => 'mensaje',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
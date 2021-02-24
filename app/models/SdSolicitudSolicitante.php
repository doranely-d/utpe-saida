<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 12/06/2018
 * Time: 01:46 PM
 */

class SdSolicitudSolicitante extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_SOLICITANTE", type="double", length=65, nullable=false)
     */
    public $id_solicitante;

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_SOLICITUD", type="double", length=65, nullable=false)
     */
    public $id_solicitud;

    /**
     *
     * @var string
     * @Column(column="USUARIO_I", type="string", length=20, nullable=false)
     */
    public $usuario_i;

    /**
     *
     * @var string
     * @Column(column="FECHA_I", type="string", length=6, nullable=false)
     */
    public $fecha_i;

    /**
     *
     * @var string
     * @Column(column="USUARIO_U", type="string", length=20, nullable=true)
     */
    public $usuario_u;

    /**
     *
     * @var string
     * @Column(column="FECHA_U", type="string", length=6, nullable=true)
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
        $this->setSource("sd_solicitud_solicitante");
        $this->belongsTo('ID_SOLICITANTE', '\SdSolicitante', 'ID_SOLICITANTE', ['alias' => 'SdSolicitante']);
        $this->belongsTo('ID_SOLICITUD', '\SdSolicitud', 'ID_SOLICITUD', ['alias' => 'SdSolicitud']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_solicitud_solicitante';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudSolicitante[]|SdSolicitudSolicitante|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudSolicitante|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'ID_SOLICITANTE' => 'id_solicitante',
            'ID_SOLICITUD' => 'id_solicitud',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
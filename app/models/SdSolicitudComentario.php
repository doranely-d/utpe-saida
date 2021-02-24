<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 09/07/2018
 * Time: 09:47 AM
 */

class SdSolicitudComentario extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID", type="integer", length=7, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(column="ID_SOLICITUD", type="integer", length=7, nullable=false)
     */
    public $id_solicitud;

    /**
     *
     * @var string
     * @Column(column="COMENTARIO", type="string", length=250, nullable=false)
     */
    public $comentario;

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
        $this->setSource("sd_solicitud_comentario");
        $this->belongsTo('ID_SOLICITUD', '\SdSolicitud', 'ID_SOLICITUD', ['alias' => 'SdSolicitud']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_solicitud_comentario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudComentario[]|SdSolicitudComentario|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudComentario|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID' => 'id',
            'ID_SOLICITUD' => 'id_solicitud',
            'COMENTARIO' => 'comentario',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
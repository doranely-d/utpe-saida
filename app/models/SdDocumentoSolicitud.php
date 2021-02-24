<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 21/05/2018
 * Time: 03:46 PM
 */

class SdDocumentoSolicitud extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_DOCUMENTO", type="integer", length=7, nullable=false)
     */
    public $id_documento;

    /**
     *
     * @var integer
     * @Column(column="ID_SOLICITUD", type="integer", length=7, nullable=false)
     */
    public $id_solicitud;

    /**
     *
     * @var string
     * @Column(column="NOMBRE", type="string", length=250, nullable=false)
     */
    public $nombre;

    /**
     *
     * @var string
     * @Column(column="EXTENSION", type="string", length=50, nullable=false)
     */
    public $extension;

    /**
     *
     * @var integer
     * @Column(column="MIMETYPE", type="integer", length=7, nullable=false)
     */
    public $mimetype;
    /**
     *
     * @var string
     * @Column(column="RUTA", type="string", length=250, nullable=false)
     */
    public $ruta;

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
        $this->setSource("sd_documento_solicitud");
        $this->belongsTo('ID_SOLICITUD', '\SdSolicitud', 'ID_SOLICITUD', ['alias' => 'SdSolicitud']);
        $this->belongsTo('MIMETYPE', '\SdDocumentoMimetype', 'ID_MIMETYPE', ['alias' => 'SdDocumentoMimetype']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_documento_solicitud';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdDocumentoSolicitud[]|SdDocumentoSolicitud|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdDocumentoSolicitud|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_DOCUMENTO' => 'id_documento',
            'ID_SOLICITUD' => 'id_solicitud',
            'NOMBRE' => 'nombre',
            'EXTENSION' => 'extension',
            'MIMETYPE' => 'mimetype',
            'RUTA' => 'ruta',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 13/06/2018
 * Time: 04:07 PM
 */

class SdRepresentante extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_REPRESENTANTE", type="integer", length=7, nullable=false)
     */
    public $id_representante;

    /**
     *
     * @var string
     * @Column(column="NOMBRE", type="string", length=20, nullable=false)
     */
    public $nombre;

    /**
     *
     * @var string
     * @Column(column="APELLIDO_PATERNO", type="string", length=100, nullable=false)
     */
    public $apellido_paterno;

    /**
     *
     * @var string
     * @Column(column="APELLIDO_MATERNO", type="string", length=100, nullable=false)
     */
    public $apellido_materno;

    /**
     *
     * @var string
     * @Column(column="SE_ACREDITA", type="string", length=100, nullable=false)
     */
    public $se_acredita;

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
     * @Column(column="USUARIO_U", type="string", length=20, nullable=true)
     */
    public $usuario_u;

    /**
     *
     * @var string
     * @Column(column="FECHA_U", type="string", nullable=true)
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
        $this->setSource("sd_representante");
        $this->hasMany('ID_REPRESENTANTE', 'SdSolicitante', 'ID_REPRESENTANTE', ['alias' => 'SdSolicitante']);
        $this->hasMany('ID_REPRESENTANTE', 'SdAcreditacionRepresentante', 'ID_REPRESENTANTE', ['alias' => 'SdAcreditacionRepresentante']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_representante';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdRepresentante[]|SdRepresentante|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdRepresentante|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function columnMap()
    {
        return [
            'ID_REPRESENTANTE' => 'id_representante',
            'NOMBRE' => 'nombre',
            'APELLIDO_PATERNO' => 'apellido_paterno',
            'APELLIDO_MATERNO' => 'apellido_materno',
            'SE_ACREDITA' => 'se_acredita',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
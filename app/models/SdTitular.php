<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 14/05/2018
 * Time: 02:57 PM
 */

class SdTitular extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_TITULAR", type="integer", length=7, nullable=false)
     */
    public $id_titular;

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
     * @Column(column="FECHA_NACIMIENTO", type="date", length=100, nullable=false)
     */
    public $fecha_nacimiento;
    /**
     *
     * @var string
     * @Column(column="VIVE", type="string", length=2, nullable=false)
     */
    public $vive;

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
        $this->setSource("sd_titular");
        $this->hasMany('ID_TITULAR', 'SdSolicitud', 'ID_TITULAR', ['alias' => 'SdSolicitud']);
        $this->hasMany('ID_TITULAR', 'SdAcreditacionTitular', 'ID_TITULAR', ['alias' => 'SdAcreditacionTitular']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_titular';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdTitular[]|SdTitular|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdTitular|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function columnMap()
    {
        return [
            'ID_TITULAR' => 'id_titular',
            'NOMBRE' => 'nombre',
            'APELLIDO_PATERNO' => 'apellido_paterno',
            'APELLIDO_MATERNO' => 'apellido_materno',
            'FECHA_NACIMIENTO' => 'fecha_nacimiento',
            'VIVE' => 'vive',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
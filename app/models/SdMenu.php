<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 09/07/2018
 * Time: 01:43 PM
 */

class SdMenu extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_MENU", type="integer", length=7, nullable=false)
     */
    public $id_menu;

    /**
     *
     * @var integer
     * @Column(column="ID_PADRE", type="integer", length=7, nullable=false)
     */
    public $id_padre;

    /**
     *
     * @var string
     * @Column(column="ACCION", type="string", length=250, nullable=false)
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
     * @Column(column="DESCRIPCION", type="string", length=250, nullable=false)
     */
    public $url;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=250, nullable=false)
     */
    public $icono;

    /**
     *
     * @var string
     * @Column(column="ORDEN", type="string", length=250, nullable=false)
     */
    public $orden;

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
        $this->setSource("sd_menu");
        $this->hasMany('ID_MENU', 'SdMenuRol', 'ID_MENU', ['alias' => 'SdMenuRol']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_menu';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdMenu[]|SdMenu|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdMenu|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_MENU' => 'id_menu',
            'ID_PADRE' => 'id_padre',
            'NOMBRE' => 'nombre',
            'DESCRIPCION' => 'descripcion',
            'URL' => 'url',
            'ICONO' => 'icono',
            'ORDEN' => 'orden',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 09/07/2018
 * Time: 09:48 AM
 */

class SdPreguntaComentario extends \Phalcon\Mvc\Model
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
     * @Column(column="ID_PREGUNTA", type="integer", length=7, nullable=false)
     */
    public $id_pregunta;

    /**
     *
     * @var integer
     * @Column(column="ID_DEPENDENCIA", type="integer", length=7, nullable=false)
     */
    public $id_dependencia;

    /**
     *
     * @var string
     * @Column(column="FLEX_VALUE", type="string", length=15, nullable=false)
     */
    public $flex_value;

    /**
     *
     * @var string
     * @Column(column="DEPENDENCIA", type="string", length=250, nullable=false)
     */
    public $dependencia;

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
        $this->setSource("sd_pregunta_comentario");
        $this->belongsTo('ID_PREGUNTA', '\SdPregunta', 'ID_PREGUNTA', ['alias' => 'SdPregunta']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_pregunta_comentario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPreguntaComentario[]|SdPreguntaComentario|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdPreguntaComentario|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID' => 'id',
            'ID_PREGUNTA' => 'id_pregunta',
            'ID_DEPENDENCIA' => 'id_dependencia',
            'FLEX_VALUE' => 'flex_value',
            'DEPEDENDECIA' => 'dependencia',
            'COMENTARIO' => 'comentario',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 31/05/2018
 * Time: 11:16 AM
 */

class SdAcreditacionRepresentante extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_ACREDITACION", type="integer", length=7, nullable=false)
     */
    public $id_acreditacion;

    /**
     *
     * @var integer
     * @Column(column="ID_DOCUMENTO", type="integer", length=7, nullable=false)
     */
    public $id_documento;

    /**
     *
     * @var integer
     * @Column(column="ID_REPRESENTANTE", type="integer", length=7, nullable=false)
     */
    public $id_representante;

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
        $this->setSource("sd_acreditacion_representante");
        $this->belongsTo('ID_DOCUMENTO', '\SdAcreditacionIdentidad', 'ID_DOCUMENTO', ['alias' => 'SdAcreditacionIdentidad']);
        $this->belongsTo('ID_REPRESENTANTE', '\SdRepresentante', 'ID_REPRESENTANTE', ['alias' => 'SdRepresentante']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_acreditacion_representante';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdAcreditacionRepresentante[]|SdAcreditacionRepresentante|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdAcreditacionRepresentante|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_ACREDITACION' => 'id_acreditacion',
            'ID_DOCUMENTO' => 'id_documento',
            'ID_REPRESENTANTE' => 'id_representante',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus',
        ];
    }
}
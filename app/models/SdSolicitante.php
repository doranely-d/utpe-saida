<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 14/05/2018
 * Time: 03:08 PM
 */

class SdSolicitante extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_SOLICITANTE", type="integer", length=5, nullable=false)
     */
    public $id_solicitante;

    /**
     *
     * @var string
     * @Column(column="SEUDONIMO", type="string", length=50, nullable=false)
     */
    public $seudonimo;

    /**
     *
     * @var string
     * @Column(column="ANONIMO", type="string", length=2, nullable=false)
     */
    public $anonimo;

    /**
     *
     * @var string
     * @Column(column="NOMBRE", type="string", length=250, nullable=false)
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
     * @Column(column="TELEFONO_FIJO", type="string", length=50, nullable=false)
     */
    public $telefono_fijo;

    /**
     *
     * @var string
     * @Column(column="TELEFONO_CELULAR", type="string", length=50, nullable=false)
     */
    public $telefono_celular;

    /**
     *
     * @var string
     * @Column(column="CORREO", type="string", length=250, nullable=false)
     */
    public $correo;

    /**
     *
     * @var string
     * @Column(column="DOMICILIO", type="string", length=100, nullable=false)
     */
    public $domicilio;

    /**
     *
     * @var string
     * @Column(column="ENTRE_CALLES", type="string", length=250, nullable=false)
     */
    public $entre_calles;
    /**
     *
     * @var string
     * @Column(column="OTRA_REFERENCIA", type="string", length=250, nullable=false)
     */
    public $otra_referencia;
    /**
     *
     * @var string
     * @Column(column="COLONIA", type="string", length=250, nullable=false)
     */
    public $colonia;

    /**
     *
     * @var integer
     * @Column(column="ESTADO", type="integer", length=5, nullable=false)
     */
    public $estado;

    /**
     *
     * @var integer
     * @Column(column="MUNICIPIO", type="integer", length=5, nullable=false)
     */
    public $municipio;

    /**
     *
     * @var string
     * @Column(column="CODIGO_POSTAL", type="string", length=10, nullable=false)
     */
    public $codigo_postal;

    /**
     *
     * @var string
     * @Column(column="RAZON_SOCIAL", type="string", length=250, nullable=false)
     */
    public $razon_social;
    /**
     *
     * @var string
     * @Column(column="NOMBRE_PERSONA_A", type="string", length=250, nullable=false)
     */
    public $nombre_persona_a;

    /**
     *
     * @var string
     * @Column(column="APELLIDO_P_PERSONA_A", type="string", length=100, nullable=false)
     */
    public $apellido_p_persona_a;

    /**
     *
     * @var string
     * @Column(column="APELLIDO_M_PERSONA_A", type="string", length=100, nullable=false)
     */
    public $apellido_m_persona_a;

    /**
     *
     * @var string
     * @Column(column="SOLICITUD_ARCO", type="string", length=100, nullable=false)
     */
    public $solicitud_arco;

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
        $this->setSource("sd_solicitante");
        $this->hasMany('ID_SOLICITANTE', 'SdSolicitudSolicitante', 'ID_SOLICITANTE', ['alias' => 'SdSolicitudSolicitante']);
        $this->hasMany('ID_SOLICITANTE', 'SdSolicitanteHistorial', 'ID_SOLICITANTE', ['alias' => 'SdSolicitanteHistorial']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_solicitante';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitante[]|SdSolicitante|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitante|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_SOLICITANTE' => 'id_solicitante',
            'SEUDONIMO' => 'seudonimo',
            'ANONIMO' => 'anonimo',
            'NOMBRE' => 'nombre',
            'APELLIDO_PATERNO' => 'apellido_paterno',
            'APELLIDO_MATERNO' => 'apellido_materno',
            'TELEFONO_FIJO' => 'telefono_fijo',
            'TELEFONO_CELULAR' => 'telefono_celular',
            'CORREO' => 'correo',
            'DOMICILIO' => 'domicilio',
            'ENTRE_CALLES' => 'entre_calles',
            'OTRA_REFERENCIA' => 'otra_referencia',
            'COLONIA' => 'colonia',
            'ESTADO' => 'estado',
            'MUNICIPIO' => 'municipio',
            'CODIGO_POSTAL' => 'codigo_postal',
            'RAZON_SOCIAL' => 'razon_social',
            'NOMBRE_PERSONA_A' => 'nombre_persona_a',
            'APELLIDO_P_PERSONA_A' => 'apellido_p_persona_a',
            'APELLIDO_M_PERSONA_A' => 'apellido_m_persona_a',
            'SOLICITUD_ARCO' => 'solicitud_arco',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus',
        ];
    }
}
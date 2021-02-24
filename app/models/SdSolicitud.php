<?php
/**
 * Created by PhpStorm.
 * User: dvegag
 * Date: 14/05/2018
 * Time: 02:47 PM
 */

class SdSolicitud extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_SOLICITUD", type="integer", length=5, nullable=false)
     */
    public $id_solicitud;

    /**
     *
     * @var string
     * @Column(column="FOLIO", type="string", length=50, nullable=false)
     */
    public $folio;

   /**
     *
     * @var string
     * @Column(column="FOLIO_EXTERNO", type="string", length=50, nullable=false)
     */
    public $folio_externo;

    /**
     *
     * @var integer
     * @Column(column="ID_TIPO", type="integer", length=5, nullable=false)
     */
    public $id_tipo;

    /**
     *
     * @var integer
     * @Column(column="ID_MEDIO_REGISTRO", type="integer", length=5, nullable=false)
     */
    public $id_medio_registro;

    /**
     *
     * @var integer
     * @Column(column="ID_TITULAR", type="integer", length=5, nullable=false)
     */
    public $id_titular;

    /**
     *
     * @var integer
     * @Column(column="ID_DERECHO_ARCO", type="integer", length=5, nullable=false)
     */
    public $id_derecho_arco;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_REPRESENTANTE", type="integer", length=5, nullable=false)
     */
    public $id_representante;

    /**
     *
     * @var integer
     * @Column(column="FECHA_PREVENCION", type="string", length=8, nullable=false)
     */
    public $fecha_prevencion;

    /**
     *
     * @var integer
     * @Column(column="FECHA_TURNADO", type="string", length=8, nullable=false)
     */
    public $fecha_turnado;

    /**
     *
     * @var integer
     * @Column(column="ID_FLUJO", type="string", length=8, nullable=false)
     */
    public $id_flujo;

    /**
     *
     * @var string
     * @Column(column="ANTECEDENTE", type="string", length=8, nullable=false)
     */
    public $antecedente;
    /**
     *
     * @var integer
     * @Column(column="MOSTRAR_ANTECEDENTE", type="integer", length=8, nullable=false)
     */
    public $mostrar_antecedente;

    /**
     *
     * @var integer
     * @Column(column="CONSENTIMIENTO", type="integer", length=5, nullable=false)
     */
    public $consentimiento;

    /**
     *
     * @var integer
     * @Column(column="TURNADO", type="integer", length=5, nullable=false)
     */
    public $turnado;

    /**
     *
     * @var integer
     * @Column(column="ESTRADO", type="integer", length=5, nullable=false)
     */
    public $estrado;

    /**
     *
     * @var integer
     * @Column(column="ALERTA", type="integer", length=5, nullable=false)
     */
    public $alerta;

    /**
     *
     * @var string
     * @Column(column="FECHA_I_ESTRADO", type="string", length=5, nullable=false)
     */
    public $fecha_i_estrado;

    /**
     *
     * @var string
     * @Column(column="FECHA_F_ESTRADO", type="string", length=5, nullable=false)
     */
    public $fecha_f_estrado;

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
        $this->setSource("sd_solicitud");
        $this->hasMany('ID_SOLICITUD', 'SdDocumentoSolicitud', 'ID_SOLICITUD', ['alias' => 'SdDocumentoSolicitud']);
        $this->hasMany('ID_SOLICITUD', 'SdPregunta', 'ID_SOLICITUD', ['alias' => 'SdPregunta']);
        $this->hasMany('ID_SOLICITUD', 'SdSolicitudSolicitante', 'ID_SOLICITUD', ['alias' => 'SdSolicitudSolicitante']);
        $this->hasMany('ID_SOLICITUD', 'SdSolicitudCatalogo', 'ID_SOLICITUD', ['alias' => 'SdSolicitudCatalogo']);
        $this->hasMany('ID_SOLICITUD', 'SdHistorialSolicitud', 'ID_SOLICITUD', ['alias' => 'SdHistorialSolicitud']);
        $this->hasMany('ID_SOLICITUD', 'SdSolicitudMedio', 'ID_SOLICITUD', ['alias' => 'SdSolicitudMedio']);
        $this->hasMany('ID_SOLICITUD', 'SdSolicitudPrevencion', 'ID_SOLICITUD', ['alias' => 'SdSolicitudPrevencion']);
        $this->hasMany('ID_SOLICITUD', 'SdSolicitudComentario', 'ID_SOLICITUD', ['alias' => 'SdSolicitudComentario']);
        $this->hasMany('ID_SOLICITUD', 'SdSolicitudHistorial', 'ID_SOLICITUD', ['alias' => 'SdSolicitudHistorial']);
        $this->belongsTo('ID_REPRESENTANTE', '\SdRepresentante', 'ID_REPRESENTANTE', ['alias' => 'SdRepresentante']);
        $this->belongsTo('ID_FLUJO', '\SdFlujo', 'ID_FLUJO', ['alias' => 'SdFlujo']);
        $this->belongsTo('ID_TIPO', '\SdSolicitudTipo', 'ID_TIPO', ['alias' => 'SdSolicitudTipo']);
        $this->belongsTo('ID_DERECHO_ARCO', '\SdDerechosArco', 'ID_DERECHO_ARCO', ['alias' => 'SdDerechosArco']);
        $this->belongsTo('ID_TITULAR', '\SdTitular', 'ID_TITULAR', ['alias' => 'SdTitular']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_solicitud';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitud[]|SdSolicitud|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitud|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_SOLICITUD' => 'id_solicitud',
            'FOLIO' => 'folio',
            'FOLIO_EXTERNO' => 'folio_externo',
            'FECHA_I_ESTRADO' => 'fecha_i_estrado',
            'FECHA_F_ESTRADO' => 'fecha_f_estrado',
            'ID_TIPO' => 'id_tipo',
            'ID_FLUJO' => 'id_flujo',
            'ANTECEDENTE' => 'antecedente',
            'MOSTRAR_ANTECEDENTE' => 'mostrar_antecedente',
            'CONSENTIMIENTO' => 'consentimiento',
            'TURNADO' => 'turnado',
            'ESTRADO' => 'estrado',
            'ID_MEDIO_REGISTRO' => 'id_medio_registro',
            'ID_TITULAR' => 'id_titular',
            'ID_DERECHO_ARCO' => 'id_derecho_arco',
            'ID_REPRESENTANTE' => 'id_representante',
            'FECHA_PREVENCION' => 'fecha_prevencion',
            'FECHA_TURNADO' => 'fecha_turnado',
            'ALERTA' => 'alerta',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus',
        ];
    }
}
<?php

class SdSolicitudHistorial extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="ID", type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(column="ID_SOLICITUD", type="integer", length=11, nullable=false)
     */
    public $id_solicitud;

    /**
     *
     * @var integer
     * @Column(column="ID_FLUJO", type="integer", length=11, nullable=false)
     */
    public $id_flujo;

    /**
     *
     * @var integer
     * @Column(column="ID_ETAPA", type="integer", length=11, nullable=false)
     */
    public $id_etapa;

    /**
     *
     * @var string
     * @Column(column="ETAPA", type="string", length=255, nullable=false)
     */
    public $etapa;

    /**
     *
     * @var integer
     * @Column(column="N_ETAPA_ID", type="integer", length=11, nullable=false)
     */
    public $n_etapa_id;

    /**
     *
     * @var string
     * @Column(column="N_ETAPA", type="string", length=255, nullable=false)
     */
    public $n_etapa;

    /**
     *
     * @var integer
     * @Column(column="ID_TRANSACCION", type="integer", length=11, nullable=false)
     */
    public $id_transaccion;

    /**
     *
     * @var string
     * @Column(column="TRANSACCION", type="string", length=255, nullable=false)
     */
    public $transaccion;

    /**
     *
     * @var integer
     * @Column(column="ID_ESTADO", type="integer", length=11, nullable=false)
     */
    public $id_estado;

    /**
     *
     * @var string
     * @Column(column="ESTADO", type="string", length=255, nullable=false)
     */
    public $estado;

    /**
     *
     * @var integer
     * @Column(column="N_ESTADO_ID", type="integer", length=11, nullable=false)
     */
    public $n_estado_id;

    /**
     *
     * @var string
     * @Column(column="N_ESTADO", type="string", length=255, nullable=false)
     */
    public $n_estado;

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
        $this->setSource("sd_solicitud_historial");
        $this->belongsTo('ID_ESTADO', '\SdFlujoEstado', 'ID', ['alias' => 'SdFlujoEstado']);
        $this->belongsTo('ID_ETAPA', '\SdFlujoEtapa', 'ID', ['alias' => 'SdFlujoEtapa']);
        $this->belongsTo('ID_FLUJO', '\SdFlujo', 'ID_FLUJO', ['alias' => 'SdFlujo']);
        $this->belongsTo('ID_SOLICITUD', '\SdSolicitud', 'ID_SOLICITUD', ['alias' => 'SdSolicitud']);
        $this->belongsTo('ID_TRANSACCION', '\SdFlujoTransaccion', 'ID', ['alias' => 'SdFlujoTransaccion']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_solicitud_historial';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudHistorial[]|SdSolicitudHistorial|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudHistorial|\Phalcon\Mvc\Model\ResultInterface
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
            'ID' => 'id',
            'ID_SOLICITUD' => 'id_solicitud',
            'ID_FLUJO' => 'id_flujo',
            'ID_ETAPA' => 'id_etapa',
            'ETAPA' => 'etapa',
            'N_ETAPA_ID' => 'n_etapa_id',
            'N_ETAPA' => 'n_etapa',
            'ID_ESTADO' => 'id_estado',
            'ESTADO' => 'estado',
            'N_ESTADO_ID' => 'n_estado_id',
            'N_ESTADO' => 'n_estado',
            'ID_TRANSACCION' => 'id_transaccion',
            'TRANSACCION' => 'transaccion',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus',
        ];
    }
}
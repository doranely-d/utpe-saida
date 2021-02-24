<?php

class SdFlujoEstadoTransaccion extends \Phalcon\Mvc\Model
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
     * @Column(column="ID_ESTADO", type="integer", length=11, nullable=false)
     */
    public $id_estado;

    /**
     *
     * @var integer
     * @Column(column="ID_TRANSACCION", type="integer", length=11, nullable=false)
     */
    public $id_transaccion;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=255, nullable=false)
     */
    public $descripcion;

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
        $this->setSource("sd_flujo_estado_transaccion");
        $this->belongsTo('ID_ESTADO', '\SdFlujoEstado', 'ID', ['alias' => 'SdFlujoEstado']);
        $this->belongsTo('ID_TRANSACCION', '\SdFlujoTransaccion', 'ID', ['alias' => 'SdFlujoTransaccion']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_flujo_estado_transaccion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdFlujoEstadoTransaccion[]|SdFlujoEstadoTransaccion|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdFlujoEstadoTransaccion|\Phalcon\Mvc\Model\ResultInterface
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
            'ID_ESTADO' => 'id_estado',
            'ID_TRANSACCION' => 'id_transaccion',
            'DESCRIPCION' => 'descripcion',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
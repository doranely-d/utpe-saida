<?php

class SdFlujoEtapa extends \Phalcon\Mvc\Model
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
     * @Column(column="ID_FLUJO", type="integer", length=11, nullable=false)
     */
    public $id_flujo;

    /**
     *
     * @var string
     * @Column(column="NOMBRE", type="string", length=255, nullable=false)
     */
    public $nombre;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=255, nullable=false)
     */
    public $descripcion;

    /**
     *
     * @var integer
     * @Column(column="PRINCIPAL", type="integer", length=4, nullable=false)
     */
    public $principal;

    /**
     *
     * @var string
     * @Column(column="COLOR", type="string", length=255, nullable=false)
     */
    public $color;

    /**
     *
     * @var integer
     * @Column(column="CONDICION", type="integer", length=11, nullable=false)
     */
    public $condicion;

    /**
     *
     * @var string
     * @Column(column="ALTURA", type="string", length=50, nullable=false)
     */
    public $altura;

    /**
     *
     * @var string
     * @Column(column="IZQUIERDA", type="string", length=50, nullable=false)
     */
    public $izquierda;

    /**
     *
     * @var integer
     * @Column(column="EDITAR", type="integer", length=11, nullable=false)
     */
    public $editar;


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
        $this->setSource("sd_flujo_etapa");
        $this->hasMany('ID', 'SdFlujoEtapaEstado', 'ID_ETAPA', ['alias' => 'SdFlujoEtapaEstado']);
        $this->hasMany('ID', 'SdSolicitudHistorial', 'ID_ETAPA', ['alias' => 'SdSolicitudHistorial']);
        $this->belongsTo('ID_FLUJO', '\SdFlujo', 'ID_FLUJO', ['alias' => 'SdFlujo']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_flujo_etapa';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdFlujoEtapa[]|SdFlujoEtapa|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdFlujoEtapa|\Phalcon\Mvc\Model\ResultInterface
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
            'ID_FLUJO' => 'id_flujo',
            'NOMBRE' => 'nombre',
            'DESCRIPCION' => 'descripcion',
            'PRINCIPAL' => 'principal',
            'COLOR' => 'color',
            'CONDICION' => 'condicion',
            'ALTURA' => 'altura',
            'IZQUIERDA' => 'izquierda',
            'EDITAR' => 'editar',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
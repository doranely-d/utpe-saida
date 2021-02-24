<?php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

class SdEstatusPregunta extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_ESTATUS", type="integer", length=7, nullable=false)
     */
    public $id_estatus;

    /**
     *
     * @var string
     * @Column(column="NOMBRE", type="string", length=100, nullable=false)
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
     * @Column(column="COLOR", type="string", length=50, nullable=false)
     */
    public $color;

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
        $this->setSource("sd_estatus_pregunta");
        $this->hasMany('ID_ESTATUS', 'SdPregunta', 'ID_ESTATUS', ['alias' => 'SdPregunta']);
        $this->hasMany('ID_ESTATUS', 'SdPlazosPregunta', 'ID_ESTATUS', ['alias' => 'SdPlazosPregunta']);
        $this->hasMany('ID_ESTATUS', 'SdPreguntaHistorial', 'ID_ESTATUS', ['alias' => 'SdPreguntaHistorial']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_estatus_pregunta';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdEstatusPregunta[]|SdEstatusPregunta|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdEstatusPregunta|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_ESTATUS' => 'id_estatus',
            'NOMBRE' => 'nombre',
            'DESCRIPCION' => 'descripcion',
            'COLOR' => 'color',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
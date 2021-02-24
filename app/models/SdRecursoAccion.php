<?php

class SdRecursoAccion extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_RECURSO", type="integer", length=7, nullable=false)
     */
    public $id_recurso;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID_ACCION", type="integer", length=7, nullable=false)
     */
    public $id_accion;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=500, nullable=false)
     */
    public $descripcion;

    /**
     *
     * @var string
     * @Column(column="PRIVACIDAD", type="string", length=8, nullable=false)
     */
    public $privacidad;

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
        $this->setSource("sd_recurso_accion");
        $this->belongsTo('ID_RECURSO', '\SdRecurso', 'ID', ['alias' => 'SdRecurso']);
        $this->belongsTo('ID_ACCION', '\SdAccion', 'ID', ['alias' => 'SdAccion']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_recurso_accion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdRecursoAccion[]|SdRecursoAccion|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdRecursoAccion|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID_RECURSO' => 'id_recurso',
            'ID_ACCION' => 'id_accion',
            'DESCRIPCION' => 'descripcion',
            'PRIVACIDAD' => 'privacidad',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
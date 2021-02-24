<?php

class SdRecursoRol extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_RECURSO", type="double", length=65, nullable=false)
     */
    public $id_recurso;

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_ROL", type="double", length=65, nullable=false)
     */
    public $id_rol;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=500, nullable=false)
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
        $this->setSource("sd_recurso_rol");
        $this->belongsTo('ID_RECURSO', '\SdRecurso', 'ID', ['alias' => 'SdRecurso']);
        $this->belongsTo('ID_ROL', '\SdRol', 'ID', ['alias' => 'SdRol']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_recurso_rol';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdRecursoRol[]|SdRecursoRol|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdRecursoRol|\Phalcon\Mvc\Model\ResultInterface
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
            'ID_RECURSO' => 'id_recurso',
            'ID_ROL' => 'id_rol',
            'DESCRIPCION' => 'descripcion',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
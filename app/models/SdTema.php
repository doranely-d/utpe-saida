<?php

class SdTema extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_TEMA", type="double", length=65, nullable=false)
     */
    public $id_tema;

    /**
     *
     * @var string
     * @Column(column="TEMA", type="string", length=250, nullable=false)
     */
    public $tema;

    /**
     *
     * @var string
     * @Column(column="DESCRIPCION", type="string", length=250, nullable=false)
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
        $this->setSource("sd_tema");
        $this->hasMany('ID_TEMA', 'SdTemaSubtema', 'ID_TEMA', ['alias' => 'SdTemaSubtema']);
        $this->hasMany('ID_TEMA', 'SdSolicitudCatalogo', 'ID_TEMA', ['alias' => 'SdSolicitudCatalogo']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_tema';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdTema[]|SdTema|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdTema|\Phalcon\Mvc\Model\ResultInterface
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
            'ID_TEMA' => 'id_tema',
            'TEMA' => 'tema',
            'DESCRIPCION' => 'descripcion',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
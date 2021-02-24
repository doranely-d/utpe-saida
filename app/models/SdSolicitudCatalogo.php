<?php

class SdSolicitudCatalogo extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     * @Primary
     * @Column(column="ID", type="integer", length=5, nullable=false)
     */
    public $id;

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_SOLICITUD", type="double", length=65, nullable=false)
     */
    public $id_solicitud;

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_TEMA", type="double", length=65, nullable=false)
     */
    public $id_tema;

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_SUBTEMA", type="double", length=65, nullable=false)
     */
    public $id_subtema;

    /**
     *
     * @var double
     * @Primary
     * @Column(column="ID_TITULO", type="double", length=65, nullable=false)
     */
    public $id_titulo;

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
        $this->setSource("sd_solicitud_catalogo");
        $this->belongsTo('ID_SOLICITUD', '\SdSolicitud', 'ID_SOLICITUD', ['alias' => 'SdSolicitud']);
        $this->belongsTo('ID_TEMA', '\SdTema', 'ID_TEMA', ['alias' => 'SdTema']);
        $this->belongsTo('ID_SUBTEMA', '\SdSubtema', 'ID_SUBTEMA', ['alias' => 'SdSubtema']);
        $this->belongsTo('ID_TITULO', '\SdTitulo', 'ID_TITULO', ['alias' => 'SdTitulo']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_solicitud_catalogo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudCatalogo[]|SdSolicitudCatalogo|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdSolicitudCatalogo|\Phalcon\Mvc\Model\ResultInterface
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
            'ID_TEMA' => 'id_tema',
            'ID_SUBTEMA' => 'id_subtema',
            'ID_TITULO' => 'id_titulo',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus'
        ];
    }
}
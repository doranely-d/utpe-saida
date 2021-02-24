<?php

class SaidaSdDependenciasV extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var string
     * @Column(column="AREA", type="string", length=7, nullable=false)
     */
    public $area;

    /**
     *
     * @var string
     * @Column(column="DESCRIPTION", type="string", length=250, nullable=false)
     */
    public $description;

    /**
     *
     * @var integer
     * @Column(column="DEPENDENCIA", type="integer", length=20, nullable=false)
     */
    public $dependencia;
    /**
     *
     * @var string
     * @Column(column="DIRECCION", type="string", nullable=false)
     */
    public $direccion;

    /**
     *
     * @var string
     * @Column(column="AGRUPADOR", type="string", nullable=false)
     */
    public $agrupador;

    /**
     *
     * @var string
     * @Column(column="PRESUPUESTAL", type="string", length=7, nullable=false)
     */
    public $presupuestal;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("XXHR");
        $this->setSource("SAIDA_SD_DEPENDENCIAS_V");
        $this->setConnectionService('db_ebs');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'SAIDA_SD_DEPENDENCIAS_V';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return XxhrPqHierarchyV[]|XxhrPqHierarchyV|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return XxhrPqHierarchyV|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'AREA' => 'area',
            'DESCRIPCION' => 'descricion',
            'DEPENDENCIA' => 'dependencia',
            'DIRECCION' => 'direccion',
            'AGRUPADOR' => 'agrupador',
            'PRESUPUESTAL' => 'presupuestal'
        ];
    }
}
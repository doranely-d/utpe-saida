<?php

class XxhrPqHierarchyV extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var string
     * @Column(column="FLEX_VALUE", type="string", length=7, nullable=false)
     */
    public $flex_value;

    /**
     *
     * @var integer
     * @Column(column="FLEX_VALUE_ID", type="integer", length=250, nullable=false)
     */
    public $flex_value_id;

    /**
     *
     * @var string
     * @Column(column="DESCRIPTION", type="string", length=250, nullable=false)
     */
    public $description;

    /**
     *
     * @var integer
     * @Column(column="HIERARCHY", type="integer", length=20, nullable=false)
     */
    public $hierarchy;

    /**
     *
     * @var string
     * @Column(column="AGRUPADOR", type="string", nullable=false)
     */
    public $agrupador;

    /**
     *
     * @var string
     * @Column(column="CHILD_FLEX_VALUE_HIGH", type="string", length=7, nullable=false)
     */
    public $child_flex_value_high;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("XXHR");
        $this->setSource("XXHR_PQ_HIERARCHY_V");
        $this->setConnectionService('db_ebs');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'XXHR_PQ_HIERARCHY_V';
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
            'FLEX_VALUE' => 'flex_value',
            'FLEX_VALUE_ID' => 'flex_value_id',
            'DESCRIPTION' => 'description',
            'HIERARCHY' => 'hierarchy',
            'AGRUPADOR' => 'agrupador',
            'CHILD_FLEX_VALUE_HIGH' => 'child_flex_value_high'
        ];
    }
}
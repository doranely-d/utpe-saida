<?php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness;

class SdUsuario extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(column="USUARIO", type="string", length=250, nullable=false)
     */
    public $usuario;

    /**
     *
     * @var string
     * @Column(column="PASSWORD", type="string", length=250, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(column="NOMBRE", type="string", length=250, nullable=false)
     */
    public $nombre;
    /**
     *
     * @var string
     * @Column(column="CORREO", type="string", length=250, nullable=false)
     */
    public $correo;

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
        $this->setSource("sd_usuario");
        $this->hasMany('ID', 'SdUsuarioRol', 'ID_USUARIO', ['alias' => 'SdUsuarioRol']);
        $this->hasMany('ID', 'SdUsuarioDependencia', 'ID_USUARIO', ['alias' => 'SdUsuarioDependencia']);
        $this->hasMany('ID', 'SdDocumentoUsuario', 'ID_USUARIO', ['alias' => 'SdDocumentoUsuario']);
    }
    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();
        $validator->add('correo', new EmailValidator());
        $validator->add('usuario',   new Uniqueness([
                'message' => 'error',
            ])
        );

        return $this->validate($validator);
    }


    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sd_usuario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdUsuario[]|SdUsuario|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SdUsuario|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'ID' => 'id',
            'USUARIO' => 'usuario',
            'PASSWORD' => 'password',
            'NOMBRE' => 'nombre',
            'CORREO' => 'correo',
            'USUARIO_I' => 'usuario_i',
            'FECHA_I' => 'fecha_i',
            'USUARIO_U' => 'usuario_u',
            'FECHA_U' => 'fecha_u',
            'ESTATUS' => 'estatus',
        ];
    }
}
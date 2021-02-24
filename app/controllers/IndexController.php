<?php

class IndexController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Unidad de Tranparencia del estado Ejecutivo');
        parent::initialize();
    }

    /**  Vista donde se muestra la página de login*/
    public function indexAction(){}

    /**   Vista donde se muestra el perfil de usuario */
    public function registroAction(){}

}
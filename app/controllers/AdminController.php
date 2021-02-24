<?php

class AdminController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Administrador');
        parent::initialize();
    }

    /**  Vista donde se muestra la página principal del administrador*/
    public function indexAction(){}

}
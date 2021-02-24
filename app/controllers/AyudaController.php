<?php

class AyudaController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Ayuda');
        parent::initialize();
    }
    /** Vista donde se muestra el manual de ayuda*/
    public function indexAction(){}
}
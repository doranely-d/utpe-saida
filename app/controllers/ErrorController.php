<?php

class ErrorController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Error');
        parent::initialize();
    }
    /**  Vista donde se muestra la  página de excepcion 403 */
    public function deniedAction(){}

    /** Vista donde se muestra la  página de excepcion 404  */
    public function show404Action(){}

    /**  Vista donde se muestra la  página de excepcion 401  */
    public function show401Action(){}

    /** Vista donde se muestra la  página de excepcion 500  */
    public function show500Action(){}
}
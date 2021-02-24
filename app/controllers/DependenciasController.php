<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class DependenciasController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Dependencias');
        parent::initialize();
    }
    /** Vista donde se muestra el listado de las dependencias */
    public function indexAction(){
        $this->view->pick('administracion/dependencias/index');
    }

    /**
     *  Hace un listado con las dependencias activas en formato json
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        //Defición de Variables al realizar el filtro
        $limit = $this->request->get('limit', null, 0);
        $offset = $this->request->get('offset', null, 0);
        $order = $this->request->get('order', null, '');
        $sort = $this->request->get('sort', null, '');
        $search = $this->request->get('search', null, '');
        $currentPage =  (($offset/$limit) + 1);
        $total = 0;
        $rows = array();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{

                    $phql = "SELECT DISTINCT flex_value AS FLEX_VALUE, flex_value_id AS FLEX_VALUE_ID, UPPER(description) AS DESCRIPTION, hierarchy AS HIERARCHY, agrupador AS AGRUPADOR  
                                  FROM XxhrPqHierarchyV 
                                  WHERE UPPER(translate(description, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(translate(:description:, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) 
                                  OR flex_value LIKE UPPER(:flex_value:)";

                    $sdDependencia  = $query = $this->modelsManager->executeQuery($phql,
                        [
                            "description" =>'%' . strtoupper(trim($search)) . '%',
                            "flex_value" =>'%' . strtoupper(trim($search)) . '%',
                        ]
                    );

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $sdDependencia,
                            'limit' => $limit,
                            'page'  => $currentPage,
                        ]
                    );

                    //Obtiene el total de registros
                    $total = $paginacion->getPaginate()->total_items;

                    // Obtener los resultados paginados
                    $rows = $paginacion->getPaginate()->items;

                    $this->response->setContentType('application/json', 'UTF-8');
                    $this->response->setJsonContent(array('total' => $total, 'rows' => $rows));
                    $this->response->setStatusCode(200, "OK");
                    $this->response->send();
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las dependencias.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
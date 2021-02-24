<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class EstradosController extends ControllerBase
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

    /**
     *  Obtiene todas las solicitudes por tipo y estatus
     *  Retorna array en formato json con todas las solicitudes
     *  @author Dora Nely Vega Gonzalez
     */
    public function listarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        //Defición de Variables al realizar el filtro
        $limit = $this->request->get('limit', null, 0);
        $offset = $this->request->get('offset', null, 0);
        $order = $this->request->get('order', null, '');
        $sort = $this->request->get('sort', null, '');
        $search = $this->request->get('search', null, '');
        $currentPage =  (($offset/$limit) + 1);
        $total = 0;
        $rows = array();
        $registros = [];
        $roles = [];

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{

                    $phql= "SELECT H.id_solicitud AS ID_SOLICITUD, S.folio AS FOLIO, S.folio_externo AS FOLIO_EXTERNO, 
                                          T.descripcion AS TIPO, ES.nombre AS ESTADO, ES.color AS COLOR_ESTADO,
                                           to_char(S.fecha_i,'DD/MM/YYYY') AS FECHA_RECEPCION, D.nombre As DOCUMENTO, D.id_documento As ID_DOCUMENTO
                                     FROM SdSolicitudHistorial H
                                        INNER JOIN SdSolicitud S ON (H.id_solicitud = S.id_solicitud)
                                        INNER JOIN SdFlujoEstado ES ON (H.id_estado = ES.id)
                                        INNER JOIN SdSolicitudTipo T ON (S.id_tipo = T.id_tipo)
                                        INNER JOIN SdDocumentoSolicitud D ON (D.id_solicitud = S.id_solicitud and D.ruta like '%prevencion%' )
                                    WHERE H.id IN(SELECT MAX (SdSolicitudHistorial.id)
                                                    FROM SdSolicitudHistorial GROUP BY SdSolicitudHistorial.id_solicitud)
                                                    and  D.id_documento  IN(SELECT MAX (SdDocumentoSolicitud.id_documento)
                                                                        FROM SdDocumentoSolicitud GROUP BY SdDocumentoSolicitud.id_solicitud)  
                                            AND S.folio LIKE :folio: AND S.estatus='AC' AND S.estrado='1' AND S.fecha_i_estrado IS NOT NULL
                                    ORDER BY  H.id_solicitud";

                    //obtiene los registros del modelo solicitudes
                    $solicitudes = $this->modelsManager->executeQuery($phql,
                        ['folio'=>'%'.strtr(strtoupper(trim($search)),"áéíóúÁÉÍÓÚ","aeiouAEIOU").'%']
                    );

                    // Crear un paginador del modelo desde un array
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $solicitudes,
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
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar acceder a los registros.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
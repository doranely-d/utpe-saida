<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class DiasinhabilesController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Días Inhábiles');
        parent::initialize();
    }
    /**   Vista donde se muestra el listado de los días inhábiles */
    public function indexAction(){
        $this->view->pick('administracion/diasinhabiles/index');
    }

    /**
     *  Muestra el modal para agregar y modificar diasinhabiles días hábiles
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/diasinhabiles/modal');
        $this->view->id = $this->request->get('ID', null, '');
        $this->view->fecha = $this->request->get('FECHA', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
    }
    /**
     *  Guarda /Modifica el día hábil seleccionada en base a su id
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos las variables
                    $id = $this->request->getPost('txtIdDiaInhabil', null, 0);
                    $fecha = $this->request->getPost('txtFecha', null, '');
                    $descripcion = $this->request->getPost('txtDescripcion', null, '');

                    if(!empty($fecha)) {
                        //convertimos la fecha para saber si es en fin de semana
                        $nfecha = date('Y-m-d', strtotime(str_replace('/','-', $fecha)));

                        if(date('N',strtotime($nfecha)) != 6 && date('N',strtotime($nfecha)) != 7){
                            if (empty($id)) {
                                $secuencia = $this->db->query('SELECT SD_DIAS_INHABILES_SEQ.nextval FROM dual');
                                $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                $secuencia = $secuencia->fetchAll($secuencia);

                                $sdCalendario = new SdDiasInhabiles();
                                $sdCalendario->id =  $secuencia[0]['NEXTVAL'];
                                $sdCalendario->fecha = new \Phalcon\Db\RawValue('TO_DATE(\''.$fecha.'\', \'dd/mm/yyyy\')');
                                $sdCalendario->descripcion = $descripcion;
                                $sdCalendario->usuario_i = $this->session->usuario['usuario'];
                                $sdCalendario->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                                $sdCalendario->estatus = 'AC';
                            } else {
                                //Seleccionamos el día hábil en diasinhabiles
                                $sdCalendario = SdDiasInhabiles::findFirst($id);

                                $sdCalendario->fecha = new \Phalcon\Db\RawValue('TO_DATE(\''.$fecha.'\', \'dd/mm/yyyy\')');
                                $sdCalendario->descripcion = $descripcion;
                                $sdCalendario->usuario_u = $this->session->usuario['usuario'];
                                $sdCalendario->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                            }
                            if ($sdCalendario) {
                                if ($sdCalendario->save()) {
                                    $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                } else {
                                    foreach ($sdCalendario->getMessages() as $message) {
                                        $this->msnError .= $message->getMessage() . "<br/>";
                                    }
                                    $this->logger->error($this->msnError);
                                    $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                                }
                            } else {
                                $this->mensaje = ['warning', 'El día inhábil seleccionado no se encuentra en el sistema.', null];
                            }
                        }else {
                            $this->mensaje = ['warning', 'El día inhábil seleccionado no puede ser en fin de semana.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los registros.', null];
                }
                //obtenemos el mensaje de respuesta
                $this->resultado = $funcion->getMensaje($this->mensaje);
                $this->response->setContentType('application/json', 'UTF-8');
                $this->response->setJsonContent($this->resultado);
                $this->response->setStatusCode(200, "OK");
                $this->response->send();
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
    /**
     *  Borrar el día hábil seleccionado en base a id
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del día inhábil
                    $idDiaInhabil = $this->request->get('txtIdDiaInhabil', null, 0);

                    //Se realiza la búsqueda del día hábil en diasinhabiles
                    $sdCalendario = SdDiasInhabiles::findFirst($idDiaInhabil);

                    if ($sdCalendario) {
                        $sdCalendario->estatus = 'IN';
                        $sdCalendario->usuario_u = $this->session->usuario['usuario'];
                        $sdCalendario->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdCalendario->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el día hábil seleccionado.', null];
                        } else {
                            foreach ($sdCalendario->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el día hábil seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El día hábil no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los días hábiles.', null];
                }
                //obtenemos el mensaje de respuesta
                $funcion = new Funciones();
                $this->resultado = $funcion->getMensaje($this->mensaje);
                $this->response->setContentType('application/json', 'UTF-8');
                $this->response->setJsonContent($this->resultado);
                $this->response->setStatusCode(200, "OK");
                $this->response->send();
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
    /**
     *  Hace un listado con los días hábiles activos en formato json
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

                    //obtiene los registros del modelo SdDiasInhabiles
                    $calendario = SdDiasInhabiles::find([
                        'columns' => array('ID' => "id",'FECHA' => "to_char(fecha,'DD/MM/YYYY')", 'DESCRIPCION' => "descripcion"),
                        'conditions' => 'fecha LIKE :fecha: and estatus=:estatus: ',
                        'bind' => ['fecha' => '%' . strtolower(trim($search)) . '%', 'estatus'=>'AC'],
                        'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                    ]);

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $calendario,
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
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los días hábiles.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }
}
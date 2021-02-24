<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class MenusController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Menú');
        parent::initialize();
    }

    /**  Vista donde se muestra el listado de los items del menu */
    public function indexAction(){
        $this->view->pick('administracion/menus/index');
    }

    /**
     *  Muestra el modal para agregar y modifica sir items del menú
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction()
    {
        $this->view->pick('administracion/menus/modal');
        $this->view->id_menu = $this->request->get('ID_MENU', null, 0);
        $this->view->id_padre = $this->request->get('ID_PADRE', null, 0);
        $this->view->padre = $this->request->get('PADRE', null, '');
        $this->view->nombre = $this->request->get('NOMBRE', null, '');
        $this->view->descripcion = $this->request->get('DESCRIPCION', null, '');
        $this->view->url = $this->request->get('URL', null, '');
        $this->view->icono = $this->request->get('ICONO', null, '');
        $this->view->orden = (int)$this->request->get('ORDEN', null, 0);
    }
    /**
     *  Guarda / Modifica item de menú
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $idMenu = $this->request->getPost('txtIdMenu', null, 0);
                    $idPadre =  $this->request->getPost('slPadre', null, 0);
                    $nombre =  $this->request->getPost('txtNombre', null, '');
                    $descripcion =  $this->request->getPost('txtDescripcion', null, '');
                    $url =  $this->request->getPost('txtUrl', null, '');
                    $icono =  $this->request->getPost('txtIcono', null, '');
                    $orden =  $this->request->getPost('txtOrden', null, '');

                    if(!empty($nombre) & !empty($descripcion) & !empty($url) & !empty($icono) & !empty($orden)) {
                        if (empty(($idMenu))) {
                            $secuencia = $this->db->query('SELECT SD_MENU_SEQ.nextval FROM dual');
                            $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                            $secuencia = $secuencia->fetchAll($secuencia);

                            $sdMenu = new SdMenu();
                            $sdMenu->id_menu =  $secuencia[0]['NEXTVAL'];
                            $sdMenu->id_padre = $idPadre;
                            $sdMenu->nombre = $nombre;
                            $sdMenu->descripcion = $descripcion;
                            $sdMenu->url = $url;
                            $sdMenu->icono = $icono;
                            $sdMenu->orden = $orden;
                            $sdMenu->usuario_i = $this->session->usuario['usuario'];
                            $sdMenu->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdMenu->estatus = 'AC';
                        } else {
                            $sdMenu = SdMenu::findFirst($idMenu);
                            $sdMenu->id_padre = $idPadre;
                            $sdMenu->nombre = $nombre;
                            $sdMenu->descripcion = $descripcion;
                            $sdMenu->url = $url;
                            $sdMenu->icono = $icono;
                            $sdMenu->orden = $orden;
                            $sdMenu->usuario_u = $this->session->usuario['usuario'];
                            $sdMenu->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }

                        if ($sdMenu) {
                            if ($sdMenu->save()) {
                                $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                            } else {
                                foreach ($sdMenu->getMessages() as $message) {
                                    $this->msnError .= $message->getMessage() . "<br/>";
                                }
                                $this->mensaje = ['danger', 'Ocurrio un error al agregar los registos.', null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El item del menú seleccionado no se encuentra en el sistema.', null];
                        }
                    }else {
                        $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                    }
                } catch (\Exception $e) {
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los items del menú.', null];
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
     *  Borra el item del menú seleccionado en base a id_menu
     *  @var integer $id del item del menpu
     *  @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del item del menú
                    $idMenu = $this->request->get('txtIdMenu', null, 0);

                    //Se realiza la búsqueda del menú
                    $sdMenu = SdMenu::findFirst($idMenu);

                    if ($sdMenu) {
                        $sdMenu->estatus = 'IN';  //cambiamos el estatus a INACTIVO
                        $sdMenu->usuario_u = $this->session->usuario['usuario'];
                        $sdMenu->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($sdMenu->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el item del menú seleccionado.', null];
                        } else {
                            foreach ($sdMenu->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el item del menú seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'El item del menú no se encuentra en base de datos.', null];
                    }
                }catch (\Exception $e) {
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los items del menú.', null];
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
     *  Hace un listado con  los items del menú activos en formato json
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

                //Se realiza la búsqueda de los items del menu
                $sdMenu = SdMenu::find([
                    'columns' => array('ID_MENU' => "id_menu", 'NOMBRE'=> 'nombre', 'DESCRIPCION' => 'descripcion', 'ID_PADRE' => 'id_padre',
                        'PADRE' => ' (SELECT MM.nombre FROM SdMenu MM WHERE MM.id_menu= SdMenu.id_padre)',
                        'URL' => 'url', 'ICONO' => 'icono', 'ORDEN' => 'orden','ESTATUS'=>'estatus'),
                    'conditions' => "UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:)  and estatus=:estatus:",
                    'bind' => ['nombre' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU") . '%', 'estatus'=>'AC'],
                    'order' => trim($sort) . ' ' . strtoupper(trim($order)),
                ]);

                // Crear un paginador del modelo
                $paginacion = new PaginatorModel(
                    [
                        'data'  => $sdMenu,
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
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }

    /**
     *  Obtiene los items del menú activos
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    $nombre = $this->request->get('txtNombre', null, 0);

                    //obtiene los registros del modelo menu
                    $sdMenu = SdMenu::find([
                        'columns' => array('ID_MENU' => "id_menu", 'NOMBRE'=> 'nombre'),
                        'conditions' => "UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:) AND estatus='AC'",
                        'bind' => ['nombre' => '%' . strtr(strtoupper(trim($nombre)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU"). '%'],
                    ]);

                    if($sdMenu){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $sdMenu]; //enviar los items del menú
                    }else{
                        $this->mensaje = ['danger', 'No hay registros disponibles en la tabla de items.', null];
                    }
                }catch (\Exception $e) {
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los items del menú.', null];
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
}
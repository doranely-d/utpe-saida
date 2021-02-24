<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use GuzzleHttp\Client;

class DocumentosController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Documentos');
        parent::initialize();
    }

    /**  Vista donde se muestra el listado de documentos */
    public function indexAction(){}

    /**
     *  Muestra el modal para agregar y  modificar el documento
     *  @author Dora Nely Vega Gonzalez
     */
    public function modalAction(){
        $this->view->id_documento =  $this->request->get('ID_DOCUMENTO', null, '');
        $this->view->id_solicitud = $this->request->get('ID_SOLICITUD', null, '');
        $this->view->documento =  $this->request->get('DOCUMENTO', null, '');
        $this->view->nombre =  $this->request->get('NOMBRE', null, '');
    }

    /**
     *  Guarda / Modifica el documento seleccionado en base a su id
     *  @author Dora Nely Vega Gonzalez
     */
    public function guardarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->hasFiles() == true) {
            if ($this->request->isAjax() == true) {
                try {
                    //obtenemos el valor de las variables
                    $id = $this->request->getPost('id', null, 0);
                    $opt = $this->request->get('opt', null, 0);
                    $idDocumento = $this->request->getPost('idDocumento', null, 0);
                    $nombre = $this->request->getPost('txtNombre', null, '');//Obtenemos el nombre del documento
                    $documento = $this->request->getUploadedFiles(); //Obtenemos el documento
                    $ruta = '';

                    //Obtenemos la direccion donde se almacenaran los documentos de la solicitud
                    $ruta_documentos = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_documentos\'');
                    //Obtenemos la ruta donde sera almacenadas las solicitudes
                    $ruta_solicitudes = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_solicitudes\'');
                    //Obtenemos la direccion donde se almacenaran los documentos de prevencion de la solicitud
                    $ruta_prevencion = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ruta_prevencion\'');


                    //iniciamos la conexión
                    $sftp = new Sftp();
                    $sftp->connect();

                    $sdMimetype= SdDocumentoMimetype::findFirst([
                        'conditions' => 'extension=:extension: and estatus=:estatus: ',
                        'bind' => ['extension' => $documento[0]->getExtension(), 'estatus'=>'AC']]);

                    if($sdMimetype){
                        if (empty(($idDocumento))) {
                            switch ($opt) {
                                case '1':
                                    //Ruta donde se almanenaran los documentos
                                    $ruta = $ruta_documentos[0]->VALOR;

                                    //AGREGAR DOCUMENTO (NORMAS Y LINEAMIENTOS)
                                    $secuencia = $this->db->query('SELECT SD_DOCUMENTOS_SEQ.nextval FROM dual');
                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                    $secuencia = $secuencia->fetchAll($secuencia);

                                    $sdDocumento = new SdDocumentos();
                                    break;

                                case '2':
                                    //Hacemos la búsqueda del folio de la solicitud
                                    $solicitud = SdSolicitud::findFirst($id);
                                    //ruta donde se almacenara la solicitud
                                    $path = $ruta_solicitudes[0]->VALOR . $solicitud->folio;
                                    //Ruta donde se almanenaran los documentos
                                    $ruta = $ruta_solicitudes[0]->VALOR . $solicitud->folio . $ruta_documentos[0]->VALOR;

                                    //AGREGAR DOCUMENTO ANEXO SOLICITUD
                                    $secuencia = $this->db->query('SELECT SD_DOCUMENTO_SOLICITUD_SEQ.nextval FROM dual');
                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                    $secuencia = $secuencia->fetchAll($secuencia);

                                    $sdDocumento = new SdDocumentoSolicitud();
                                    $sdDocumento->id_solicitud = $solicitud->id_solicitud;

                                    //Creamos la carpeta de la solicitud
                                    $sftp->mkdir($path);
                                break;

                                case '3':
                                    //Hacemos la búsqueda del folio de la solicitud
                                    $solicitud = SdSolicitud::findFirst($id);
                                    //ruta donde se almacenara la solicitud
                                    $path = $ruta_solicitudes[0]->VALOR . $solicitud->folio;
                                    //Ruta donde se almanenaran los documentos
                                    $ruta = $ruta_solicitudes[0]->VALOR . $solicitud->folio . $ruta_prevencion[0]->VALOR;

                                    //AGREGAR DOCUMENTO ANEXO SOLICITUD
                                    $secuencia = $this->db->query('SELECT SD_DOCUMENTO_SOLICITUD_SEQ.nextval FROM dual');
                                    $secuencia->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                                    $secuencia = $secuencia->fetchAll($secuencia);

                                    $sdDocumento = new SdDocumentoSolicitud();
                                    $sdDocumento->id_solicitud = $solicitud->id_solicitud;

                                    //Creamos la carpeta de la solicitud
                                    $sftp->mkdir($path);
                                    break;
                            }
                            $sdDocumento->id_documento =  $secuencia[0]['NEXTVAL'];
                            $sdDocumento->nombre = $nombre;
                            $sdDocumento->extension = $documento[0]->getExtension();
                            $sdDocumento->mimetype = $sdMimetype->id_mimetype;
                            $sdDocumento->ruta = $ruta;
                            $sdDocumento->usuario_i = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                            $sdDocumento->fecha_i = new \Phalcon\Db\RawValue('SYSDATE');
                            $sdDocumento->estatus = 'AC';
                        } else {

                            switch ($opt) {
                                case '1':
                                    //BÚSCAMOS DOCUMENTO (NORMAS Y LINEAMIENTOS)
                                    $sdDocumento = SdDocumentos::findFirst($idDocumento);

                                    //Ruta donde se almanenaran los documentos
                                    $ruta = $sdDocumento->ruta;
                                    break;

                                case '2':
                                    //BÚSCAMOS DOCUMENTO ANEXO SOLICITUD
                                    $sdDocumento = SdDocumentoSolicitud::findFirst($idDocumento);

                                    //Ruta donde se almanenaran los documentos
                                    $ruta = $sdDocumento->ruta;
                                    break;
                            }

                            //Eliminamos el documento antes de ser modificado
                            $sftp->unlink($ruta . $sdDocumento->nombre. "." . $sdDocumento->extension);

                            $sdDocumento->nombre = $nombre;
                            $sdDocumento->extension = $documento[0]->getExtension();
                            $sdDocumento->mimetype = $sdMimetype->id_mimetype;
                            $sdDocumento->ruta = $ruta;
                            $sdDocumento->usuario_u = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                            $sdDocumento->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');
                        }
                        if ($sdDocumento) {
                            //creamos el directorio de la solicitud
                            $sftp->mkdir($ruta);

                            //guardamos el documento en el servidor
                            if(!empty($nombre)){
                                $sftp->putfile($documento[0]->getTempName(), $ruta . $nombre. "." . $documento[0]->getExtension());
                            }
                            if(count($documento) > 0) {
                                if ($sdDocumento->save()) {
                                    $this->mensaje = ['success', 'Se guardaron correctamente los registros.', null];
                                } else {
                                    foreach ($sdDocumento->getMessages() as $message) {
                                        $this->msnError .= $message->getMessage() . "<br/>";
                                    }
                                    $this->logger->error($this->msnError);
                                    $this->mensaje = ['danger',  $this->msnError, null];
                                }
                            }else {
                                $this->mensaje = ['warning', 'Los campos * son requeridos.', null];
                            }
                        } else {
                            $this->mensaje = ['warning', 'El documento seleccionado no se encuentra en el sistema.', null];
                        }
                    }else{
                        $this->mensaje = ['warning', 'El mimetype seleccionado no se encuentra en el sistema.', null];
                    }
                    $sftp->disconnect();
                } catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los documentos.', null];
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
     *  Borra el documento en base a su id_documento
     *  @var integer $id de la documento
     * @author Dora Nely Vega Gonzalez
     */
    public function borrarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isPut() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtenemos el id del documento
                    $idDocumento = $this->request->get('txtIdDocumento', null, 0);
                    $opt = $this->request->get('opt', null, 0);

                    switch ($opt) {
                        case '1':
                            //BORRAR DOCUMENTO (NORMAS Y LINEAMIENTOS)
                            $SdDocumentos = SdDocumentos::findFirst($idDocumento);
                            break;

                        case '2':
                            //BORRAR DOCUMENTO ANEXO SOLICITUD
                            $SdDocumentos = SdDocumentoSolicitud::findFirst($idDocumento);
                            break;
                    }

                    if ($SdDocumentos) {
                        $SdDocumentos->estatus = 'IN'; //cambiamos el estatus a INACTIVO
                        $SdDocumentos->usuario_u = (!empty($this->session->usuario['usuario'])) ? $this->session->usuario['usuario'] : "INVITADO";
                        $SdDocumentos->fecha_u = new \Phalcon\Db\RawValue('SYSDATE');

                        if ($SdDocumentos->save()) {
                            $this->mensaje = ['success', 'Se borro correctamente el documento seleccionado.', null];
                        } else {
                            foreach ($SdDocumentos->getMessages() as $message) {
                                $this->msnError .= $message->getMessage() . "<br/>";
                            }
                            $this->logger->error($this->msnError);
                            $this->mensaje = ['danger', 'Ocurrio un problema al intentar borrar el documento seleccionado.', null];
                        }
                    } else {
                        $this->mensaje = ['warning', 'el documento no se encuentra en base de datos.', null];
                    }

                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los documentos.', null];
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
     *  Descarga el documento
     * @author Dora Nely Vega Gonzalez
     */
    public function descargarAction() {
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();
        
        if ($this->request->isGet() == true) {
            try{
                $id = $this->request->get('id', null, 0);
                $opt = $this->request->get('opt', null, 0);

                if(!empty($id) & !empty($opt)){
                    switch ($opt) {
                        case '1':
                            //DESCARGAR DOCUMENTO (NORMAS Y LINEAMIENTOS)
                            $sdDocumentos = SdDocumentos::query()
                                ->columns(array('NOMBRE' => "nombre",'EXTENSION'=> 'extension', 'MIMETYPE'=> 'mimetype','RUTA'=> 'ruta'))
                                ->conditions('id_documento=:id_documento: AND estatus=:estatus:')
                                ->bind(['id_documento' => $id,  'estatus'=>'AC'])
                                ->execute();
                            break;

                        case '2':
                            //DESCARGAR DOCUMENTO ANEXO SOLICITUD
                            $sdDocumentos = SdDocumentoSolicitud::query()
                            ->columns(array('NOMBRE' => "nombre",'EXTENSION'=> 'extension', 'MIMETYPE'=> 'mimetype','RUTA'=> 'ruta'))
                            ->conditions('id_documento=:id_documento: AND  estatus=:estatus:')
                            ->bind(['id_documento' => $id,  'estatus'=>'AC'])
                            ->execute();
                            break;
                    }

                    //hacemos la búsqueda del tipo de documento
                    $sdDocMimetype= SdDocumentoMimetype::findFirst($sdDocumentos[0]->MIMETYPE);

                    if ($sdDocumentos && $sdDocMimetype) {
                        $nombre = $sdDocumentos[0]->NOMBRE;
                        $extension =  $sdDocumentos[0]->EXTENSION;
                        $mimetype =  $sdDocMimetype->texto;
                        $directorio =  $sdDocumentos[0]->RUTA;
                        $documento =$nombre . "." . $extension;

                        if(!$funcion->descargarDoc($directorio, $documento, $mimetype)){
                            $this->mensaje = ['warning', 'Ocurrió un error al descargar el archivo.', null];
                        }
                    }
                }
            }catch (\Exception $e) {
                $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                header('Content-type: text/html');
                echo sprintf('<span>Ocurrió un error al descargar el archivo %s.</span>', $documento);
            }
       } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }

    /**
     * Hace un listado con los documentos activos en formato json
     * @author Dora Nely Vega Gonzalez
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

                    //obtiene los registros del modelo documento
                    $documentos = SdDocumentos::query()
                        ->columns(array('ID_DOCUMENTO' => "id_documento",'NOMBRE'=> 'nombre', 'EXTENSION'=> 'extension'))
                        ->conditions("UPPER(translate(nombre, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU')) LIKE UPPER(:nombre:) and estatus=:estatus:")
                        ->bind(['nombre' => '%' . strtr(strtoupper(trim($search)) , "áéíóúÁÉÍÓÚ", "aeiouAEIOU")  . '%', 'estatus'=>'AC'])
                        ->orderBy(trim($sort) . ' ' . strtoupper(trim($order)))
                        ->execute();

                    // Crear un paginador del modelo
                    $paginacion = new PaginatorModel(
                        [
                            'data'  => $documentos,
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
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a los documentos.', null];
                }
            }
        } else {
            $this->response->setStatusCode(404, "Página no encontrada.");
        }
    }

    /**
     *  Obtiene las extensiones de documentos activos
     *  @author Dora Nely Vega Gonzalez
     */
    public function buscarAction(){
        \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);
        $this->view->disable();
        $funcion = new Funciones();

        if ($this->request->isGet() == true) {
            if ($this->request->isAjax() == true) {
                try{
                    //obtiene los registros del modelo SdDocumentoMimetype
                    $sdDocumentoMimetype = SdDocumentoMimetype::find([
                             'columns' => array('ID_MIMETYPE' => "id_mimetype", 'EXTENSION'=> 'extension'),
                             'conditions' => "estatus='AC'"
                         ]);
                    if($sdDocumentoMimetype){
                        $this->mensaje = ['success', 'Datos correctamente obtenidos.', $sdDocumentoMimetype];
                    }else{
                        $this->mensaje = ['danger', 'No hay registros disponibles en la tabla de tipo de extensiones de documentos.', null];
                    }
                }catch (\Exception $e) {
                    $this->logger->error($e->getFile() . '::' . $e->getLine() . '::' . $e->getMessage());
                    $this->mensaje = ['danger', 'Ocurrio algo mal al intentar accesar a las extensiones de documentos.', null];
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
}
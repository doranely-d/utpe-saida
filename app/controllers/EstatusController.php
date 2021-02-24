<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class EstatusController extends ControllerBase
{
    public $mensaje = ''; //mensaje del resultado
    public $resultado = array(); //respuesta
    public $msnError = ''; //mensaje de error

    public function initialize()
    {
        $this->tag->setTitle('Estatus');
        parent::initialize();
    }

    /** Vista donde se muestra el listado de estatus*/
    public function indexAction(){
        $error = "";
        $db = "ERROR";
        $db2= "ERROR";
        $apache = "ERROR";
        $respuesta = "OK";
        $estatusDB2 = false;
        $estatusDB = false;
        $estatusApache = false;

        //Base de datos PRODUCCION
        try {
            $conn = new PDO("oci:dbname=//10.16.103.1:1512/DBINTEGD", "MGR_SAIDA",'HAzwpk36Sq');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($conn){
                $db= "OK";
                $estatusDB =true;
            }
        } catch (PDOException $pe) {
            $error = "No se conecta a la db DB DBINTEGD :" . $pe->getMessage();
        }

        //Base de datos HISTORICO
        try {
            $conn = new PDO("oci:dbname=//10.16.103.7:1547/DBAPP12D", "INT_SAIDA", 'E3swp8eqD7');
            if($conn){
                $db2= "OK";
                $estatusDB2 =true;
            }
        } catch (PDOException $pe) {
            $error="No se conecta a la db DB DBAPP12D (dependencias) :" . $pe->getMessage();
        }

        //SERVIDOR APACHE
        $url = "https://ccontacto.queretaro.gob.mx/";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (200==$retcode) {
            $apache = "OK";
            $estatusApache = true;
        }

        if(!$estatusDB || !$estatusDB2 || !$estatusApache){
            $respuesta = "ERROR";
        }

        echo "<p>";
        echo "<p>";
        echo "<p>";
        echo "<h1>ESTATUS: $respuesta</h1>";
        echo "<p>";
        echo "<p>";
        echo "<p>Base de datos DBINTEGD: " .$db .'</p>';
        echo "<p>Base de datos DBAPP12D (DEPENDENCIAS): " .$db2 .'</p>';
        echo "<p>Servidor apache: " .$apache .'</p>';
        echo "<p>";
        if($error){
            echo "<h2>Error:</h2>";
            echo "<p>$error</p>";
        }
    }
}
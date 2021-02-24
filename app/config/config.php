<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
use Phalcon\Db\Adapter\Pdo\Oracle;
use Phalcon\Db\Adapter\Pdo\Oracle as Connection;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    /** CONFIGURACIÓN DE LA BASE DE DATOS SAIDA LOCAL*/
      /*  'database' => [
        'adapter'     => 'Oracle',
        'host'        => '10.1.201.238:1521/XE',
        'username'    => 'SAIDA',
        'password'    => 'proyectos$aida',
        'schema'      => 'SAIDA',
        'dbname'      => '(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST =10.1.201.238)(PORT = 1521))) (CONNECT_DATA=(SID=XE)))',
        'charset'     => 'utf8',
    ],*/
    /** CONFIGURACIÓN DE LA BASE DE DATOS APPS PARA LAS DEPENDENCIAS*/
   /* 'database_ebs' => [
        'adapter'     => 'Oracle',
        'host'        => '10.16.103.7:1547/DBAPP12D',
        'username'    => 'INT_SAIDA',
        'password'    => 'E3swp8eqD7',
        'schema'      => 'XXHR',
        'dbname'      => '(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.16.103.7)(PORT = 1547))) (CONNECT_DATA=(SID=DBAPP12D)))',
        'charset'     => 'utf8',
    ],*/

    /** CONFIGURACIÓN DE LA BASE DE DATOS SAIDA DESAROLLO*/
    'database' => [
        'adapter'     => 'Oracle',
        'host'        => '10.16.103.1:1512/DBINTEGD',
        'username'    => 'MGR_SAIDA',
        'password'    => 'HAzwpk36Sq',
        'schema'      => 'MGR_SAIDA',
        'dbname'      => '(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST =10.16.103.1)(PORT = 1512))) (CONNECT_DATA=(SID=DBINTEGD)))',
        'charset'     => 'utf8',
    ],
    /** CONFIGURACIÓN DE LA BASE DE DATOS APPS */
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'formsDir'       => APP_PATH . '/forms/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        'logPath'        => BASE_PATH  . '/logs/error.log',
        'logSQL'         => BASE_PATH  . '/logs/sql.log',
    ]
]);
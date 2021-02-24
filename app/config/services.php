<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as LogFileAdapter;
// use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                // 'compileAlways' => (ENVIRONMENT == 'development' ? true : false)
            ]);

            // Extended functions
            $compiler = $volt->getCompiler();
            $compiler->addFunction('in_array', 'in_array');

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    } else if ($config->database->adapter == 'Oracle') {
        $params['dialectClass'] = Phalcon\Db\Dialect\Oracle::class;
    }

    $connection = new $class($params);

    return $connection;
});

//Conexion con la base de datos de atencionciudadana2
$di->setShared('db_ebs', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database_ebs->adapter;
    $params = [
        'host'     => $config->database_ebs->host,
        'username' => $config->database_ebs->username,
        'password' => $config->database_ebs->password,
        'dbname'   => $config->database_ebs->dbname,
        'charset'  => $config->database_ebs->charset
    ];

    $connection = new $class($params);
    $eventsManager = new \Phalcon\Events\Manager();

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    return $connection;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {

    $session = new Phalcon\Session\Adapter\Files(array(
        'uniqueId' => 'SAIDA' //identificador de las sessiones
    ));

    $session->start();

    return $session;
}, true);

/**
 * Registramos el gestor de eventos
 */
$di->set('dispatcher', function() {
    $eventsManager = new EventsManager();

    /*Escuchamos eventos en el componente dispatcher usando el plugin Roles*/
    $eventsManager->attach('dispatch:beforeDispatch', new Permissions());

    /* Mostramos los Headers*/
    $eventsManager->attach('dispatch:beforeDispatch', new Headers());

    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

/**
 * Registramos el gestor de logs
 */
$di->set('logger', function () {
    $config = $this->getConfig();
    return new LogFileAdapter($config->application->logPath);
});

/**
 * Registramos el gestor de acl
 */
$di->set('acl', $di->getShared('session')->get('Permissions')['acl']);

/**
 * Registramos el gestor del menú del sistema
 */
$di->set("elements", function() {
    return new Menus();
});
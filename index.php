<?php

use core\exception\WFEDefinitionException;
use core\router\WFERouter;
use core\WFEAutoload;
use core\WFEConfig;
use core\WFELoader;
use core\WFERequest;
use core\WFEsession;

// Constante system
define('SERVER_ROOT', str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . '/'));
define('ROOT', str_replace('\\', '/', __DIR__));
define('RELATIVE_ROOT', str_replace(SERVER_ROOT, '', ROOT));
define('APP_PATH', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . RELATIVE_ROOT);

// include core files
require_once('core/WFEAutoload.php');

// set exception handler
set_exception_handler(function(Exception $e) {
    
    if(WFEConfig::get('env') == 'dev') {
        exit($e->getMessage());
    }
    elseif(WFEConfig::get('env') == 'prod') {
        $response = WFERouter::run( new WFERequest('GET', 'WFE500') );
        $response->send();
    }
});


// Register autoload
WFEAutoload::register(__NAMESPACE__);

// Load main config
WFELoader::load('app/config/config.php');

// Load Database
\core\ORM\WFEDb::connect();

// Load smarty
WFELoader::load('core/libs/smarty/Smarty.class.php');

// set environment spec
if(WFEConfig::get('env') == 'dev') {
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_ALL);
}
elseif(WFEConfig::get('env') == 'prod') {
    error_reporting(0);
}
else {
    throw new WFEDefinitionException('Config settings env is not set properly (must be dev or prod)');
}

// init session
WFEsession::init();

// init request data
$request = new WFERequest();

// Routes request and get response
WFERouter::run($request);


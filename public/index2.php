<?php
use Kaiser\Response;

define ( 'ROOT_PATH', dirname ( __FILE__ ) );
define ( 'BASE_PATH', dirname ( ROOT_PATH ) );

$loader = require_once BASE_PATH . '/vendor/autoload.php';

// use Kaiser\Router;

// phpinfo();
// var_dump ( Router::getInstance()->getLocalReferer () );

use Aura\Web\WebFactory;

$web_factory = new WebFactory ( $GLOBALS );
$response = $web_factory->newResponse ();

$response->redirect->found( '/hello' );
echo $response->status->getCode ();
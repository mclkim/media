<?php
define ( 'ROOT_PATH', dirname ( __FILE__ ) );
define ( 'BASE_PATH', dirname ( ROOT_PATH ) );

$loader = require_once BASE_PATH . '/vendor/autoload.php';

use Aura\Web\WebFactory;

$web_factory = new WebFactory(array(
		'_ENV' => $_ENV,
		'_GET' => $_GET,
		'_POST' => $_POST,
		'_COOKIE' => $_COOKIE,
		'_SERVER' => $_SERVER
));

$request = $web_factory->newRequest();
$response = $web_factory->newResponse();
?>
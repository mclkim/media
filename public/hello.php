<?php
error_reporting ( E_ALL & ~ E_NOTICE );
/**
 * |-------------------------------------------------------------------
 * |주 경로 상수를 설정
 * |-------------------------------------------------------------------
 */
define ( 'ROOT_PATH', dirname ( __FILE__ ) );
define ( 'BASE_PATH', dirname ( ROOT_PATH ) );

$loader = require_once BASE_PATH . '/vendor/mclkim/kaiser/vendor/autoload.php';
// include '/su/vendor/autoload.php';
use Aura\Web\WebFactory;

$web_factory = new WebFactory ( $GLOBALS );
$request = $web_factory->newRequest ();
$response = $web_factory->newResponse ();

// use Aura\Web\WebFactory;

$web_factory = new WebFactory ( array (
		'_ENV' => $_ENV,
		'_GET' => $_GET,
		'_POST' => $_POST,
		'_COOKIE' => $_COOKIE,
		'_SERVER' => $_SERVER 
) );

$request = $web_factory->newRequest ();
$response = $web_factory->newResponse ();

// var_dump ( $request );
// var_dump ( $response );

// var_dump ( $request->cookies );
// var_dump ( $request->env );
// var_dump ( $request->files );
// var_dump ( $request->post );
// var_dump ( $request->post->count() );
// var_dump ( $request->server );
// var_dump ( $request->client );
// var_dump ( $request->content );
var_dump ( $request->headers );
// var_dump ( $request->method->get() );
// var_dump ( $request->params );
// var_dump ( $request->url );

?>
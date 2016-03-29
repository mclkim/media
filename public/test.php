<?php
define ( 'ROOT_PATH', dirname ( __FILE__ ) );
define ( 'BASE_PATH', dirname ( ROOT_PATH ) );
$http = require BASE_PATH . '/vendor/mclkim/kaiser/vendor/aura/http/scripts/instance.php';

$request = $http->newRequest ();

var_dump ( $request->cookies );
var_dump ( $request->env );
var_dump ( $request->files );
var_dump ( $request->post );
var_dump ( $request->query );
var_dump ( $request->server );

var_dump ( $request->client );
var_dump ( $request->content );
var_dump ( $request->headers );
var_dump ( $request->method );
var_dump ( $request->accept );
var_dump ( $request->params );
var_dump ( $request->url );

if ($request->method->isPost()) {
	// perform POST actions
}
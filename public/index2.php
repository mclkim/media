<?php
define ( 'ROOT_PATH', dirname ( __FILE__ ) );
define ( 'BASE_PATH', dirname ( ROOT_PATH ) );

$loader = require_once BASE_PATH . '/vendor/autoload.php';

use Pimple\Container as PimpleContainer;
class Test {
	function index() {
		phpinfo ();
	}
}
$container = new PimpleContainer ();
$container ['class_name'] = 'Test';
// $container ['object_name'] = function ($c) {
// return new $c ['class_name'] ();
// };

$container ['object_name'] = $container->factory ( function ($c) {
	return new $c ['class_name'] ();
} );

$controllerObj = $container ['object_name'];

// call_user_func_array ( [
// $controllerObj,
// $action
// ], [ ] );
$controllerObj->index ();
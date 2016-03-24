<?php
use \Kaiser\Controller;
// use \Aura\Http\Message\Request;
/**
 * http://localhost/test/public/?hello.world
 */
class hello extends Controller {
	protected function requireLogin() {
		return false;
	}
	function world() {
		echo 'hello world~~~';
	}
	function request() {
		$http = require BASE_PATH . '/vendor/mclkim/kaiser/vendor/aura/http/scripts/instance.php';
		
		$response = $http->newResponse ();
		$html = '<html>' . '<head><title>Test</title></head>' . '<body>Hello World!</body>' . '</html>';
		$response->setContent ( $html );
		
		// change the status text to something else
		$response->setStatusText ( 'Same As It Ever Was' );
		$http->send ( $response );
	}
}
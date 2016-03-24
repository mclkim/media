<?php
define ( 'ROOT_PATH', dirname ( __FILE__ ) );
define ( 'BASE_PATH', dirname ( ROOT_PATH ) );
// $http = require 'path/to/Aura.Http/scripts/instance.php';
$http = require BASE_PATH . '/vendor/mclkim/kaiser/vendor/aura/http/scripts/instance.php';

// send a response
// $response = $http->newResponse();
// $response->headers->set('Content-Type', 'text/plain');
// $response->setContent('Hello World!');
// $http->send($response);

// make a request and get a response stack
// $request = $http->newRequest ();
// $request->setUrl ( 'http://example.com' );
// $stack = $http->send ( $request );
// echo $stack [0]->content;

$response = $http->newResponse ();
// // $response->headers->set('Content-Type', 'text/plain');
// $html = '<html>' . '<head><title>Test</title></head>' . '<body>Hello World!</body>' . '</html>';
// $response->setContent ( $html );

$html = '<html>' . '<head><title>Test</title></head>' . '<body>Hello World!</body>' . '</html>';
$response->setContent ( $html );

$response->headers->setAll ( [ 
		'Header-One' => 'header one value',
		'Header-Two' => [ 
				'header two value A',
				'header two value B',
				'header two value C' 
		] 
] );

$response->cookies->setAll ( [ 
		'cookie_foo' => [ 
				'value' => 'value for cookie foo' 
		],
		'cookie_bar' => [ 
				'value' => 'value for cookie bar' 
		] 
] );
// automatically sets the status text to 'Not Modified'
$response->setStatusCode ( 304 );

// change the status text to something else
$response->setStatusText ( 'Same As It Ever Was' );
$http->send ( $response );

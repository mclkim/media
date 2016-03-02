<?php
/**
 * |-------------------------------------------------------------------
 * |주 경로 상수를 설정
 * |-------------------------------------------------------------------
 */
define ( 'ROOT_PATH', dirname ( __FILE__ ) );
define ( 'BASE_PATH', dirname ( ROOT_PATH ) );

/**
 * |---------------------------------------------------------------
 * |ini_set('date.timezone', 'Asia/Seoul'); //한국시간(timezone)설정
 * |---------------------------------------------------------------
 */
date_default_timezone_set ( 'Asia/Seoul' ); // 한국시간(timezone)설정

/**
 * |--------------------------------------------------------------------------
 * | Register Core Helpers
 * |--------------------------------------------------------------------------
 * |
 * | We cannot rely on Composer's load order when calculating the weight of
 * | each package. This line ensures that the core global helpers are
 * | always given priority one status.
 * |
 */
$helperPath = BASE_PATH . '/vendor/mclkim/kaiser/src/Helpers.php';
if (! file_exists ( $helperPath )) {
	exit ( 'Missing vendor files, try running "composer install"' . PHP_EOL );
}

/**
 * |-------------------------------------------------------------------
 * |ClassLoader implements a PSR-0, PSR-4 and classmap class loader.
 * |-------------------------------------------------------------------
 * |
 */
$loader = require_once BASE_PATH . '/vendor/autoload.php';
// Application Controller
$loader->addPsr4 ( 'App\\', BASE_PATH . '/app' ); 
$loader->addClassMap ( [ 
		'PluploadHandler' => BASE_PATH . '/vendor/mclkim/kaiser/src/Plupload/PluploadHandler.php' 
]
 );
/**
 * |-------------------------------------------------------------------
 * |Set up dependencies
 * |-------------------------------------------------------------------
 */
require_once BASE_PATH . '/app/dependencies.php';

/**
 * |-------------------------------------------------------------------
 * |Instantiate the app
 * |-------------------------------------------------------------------
 */
$app = new Kaiser\App ( $container, BASE_PATH );

$app->setAppDir ( [ 
		__DIR__ . '/../app' 
] );

/**
 * |-------------------------------------------------------------------
 * |Run app
 * |-------------------------------------------------------------------
 */
$app->run ();
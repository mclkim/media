<?php
// DIC configuration
$container = new \Kaiser\Container ();

// -----------------------------------------------------------------------------
// Service providers & factories
// -----------------------------------------------------------------------------
// www.xtac.net
$container ['template'] = function ($c) {
	$tpl = new \Template_ ();
	// $tpl->skin = 'mediamanager';
	return $tpl;
};

// logger
$container ['logger'] = function ($c) {
	$logger = new Kaiser\Manager\LogManager ( __DIR__ . '/../logs' );
	return $logger;
};
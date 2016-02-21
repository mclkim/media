<?php
return [ 
		'displayErrorDetails' => true,
		
		'configuration' => __DIR__ . '/../config/config.php',
		
		'log' => [ 
				'path' => __DIR__ . '/../logs',
				'level' => \Psr\Log\LogLevel::DEBUG 
		] 
];


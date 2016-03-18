<?php
return [ 
		'displayErrorDetails' => true,
		
		'configuration' => __DIR__ . '/../config/config.php',
		
		'path' => [ 
				'temp' => __DIR__ . '/../tmp' 
		],
		
		'session' => [ 
				'path' => __DIR__ . '/../tmp' 
		],
		
		'log' => [ 
				'path' => __DIR__ . '/../logs',
				'level' => \Psr\Log\LogLevel::DEBUG 
		] 
];


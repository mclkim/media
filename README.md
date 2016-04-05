# media

Installation
------------

**1**. Grab with git clone

```
git clone https://github.com/mclkim/media.git
```

**2**. run composer install
```
cd media
composer install
```

**3**. Grab with git submodule update
```
git submodule update --init --recursive
```

**4**. Edit config.php
config/config.php
```
<?php
return [
		'enableCsrfProtection' => true,
		
		// ftp settings
		'ftp' => [ 
				'scheme' => 'ftp',
				'host' => 'localhost',
				'port' => 21,
				'user' => '',
				'pass' => '',
				'path' => '/',
				'timeout' => 90,
				'passive' => true 
		],
		
		// plupload
		'plupload' => [ 
				'chunk_size' => '1mb',
				'max_file_size' => '2gb',
				'max_file_count' => 20,
				'default_expire' => 365,
				'default_size' => 100 ,

				'allow_extensions' => false,
				'cb_check_file' => false,
				'cb_sanitize_file_name' => array (
						'sanitize_file_name',
						__CLASS__,
				),
				'chunk' => isset ( $_REQUEST ['chunk'] ) ? intval ( $_REQUEST ['chunk'] ) : 0,
				'chunks' => isset ( $_REQUEST ['chunks'] ) ? intval ( $_REQUEST ['chunks'] ) : 0,
				'cleanup' => true,
				'delay' => 0,
				'file_data_name' => 'file_data',
				'file_name' => isset ( $_REQUEST ['name'] ) ? $_REQUEST ['name'] : false,
				'max_file_age' => 5 * 3600,
				'target_dir' => false,
				'tmp_dir' => ini_get ( "upload_tmp_dir" ) . DIRECTORY_SEPARATOR . "plupload",
				'tmp_name' => false,
		]
		
];
```

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
				'default_size' => 100 
		]
		
];
```

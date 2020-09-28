<?php

	return array(
		'cache_enabled'	=> false,
		'cache_driver'	=> 'php',		// php, json, mongo, memcached
		'cache_ttl'		=> 86400,
		'cache_dir'		=> 'system/cache',
		'mongo'		=> array(
			'user'	=> null,
			'pass'	=> null,
			'host'	=> '127.0.0.1',
			'port'	=> 27017,
		),
		'memcached'	=> array(
			'user'	=> null,
			'pass'	=> null,
			'host'	=> '127.0.0.1',
			'port'	=> 11211,
		)
	);
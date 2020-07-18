<?php

	return array(
		'mysqli'	=> array(
			'host'			=> 'localhost',
			'port'			=> '3306',
			'user'			=> 'root',
			'pass'			=> '123',
			'base'			=> 'new_database',
			'socket'		=> '',
			'engine'		=> 'MyISAM',
			'clear_sql_mode'=> false,
			'sql_charset'	=> 'utf8mb4', 				// utf8
			'collate'		=> 'utf8mb4_unicode_ci',	// utf8_unicode_ci
			'lc_messages'	=> 'ru_RU',
		),
	/*	'mongodb'	=> array(
			'host'			=> '127.0.0.1',
			'port'			=> '27017',
			'user'			=> null,
			'pass'			=> null,
			'base'			=> 'new_database',
			'socket'		=> '',
			'engine'		=> '',
			'clear_sql_mode'=> false,
			'sql_charset'	=> '',
			'collate'		=> '',
			'lc_messages'	=> '',
		)
	*/
	);
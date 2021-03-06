<?php

	return array(
		'mysql'	=> array(
			'host'	=> 'localhost',
			'port'	=> '3306',
			'user'	=> 'root',
			'pass'	=> '123',
			'base'	=> 'new_database',
			'socket'	=> '',
			'engine'	=> 'MyISAM',
			'clear_sql_mode'	=> 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION',
			'sql_charset'	=> 'utf8mb4',
			'collate'	=> 'utf8mb4_unicode_ci',
			'lc_messages'	=> 'ru_RU',
		),
		'pgsql'	=> array(
			'host'	=> 'localhost',
			'port'	=> '5432',
			'user'	=> 'root',
			'pass'	=> '123',
			'base'	=> 'new_database',
			'default_db_con'	=> 'postgres',
			'socket'	=> '',
			'engine'	=> 'InnoDB',
			'clear_sql_mode'	=> false,
			'sql_charset'	=> 'utf8mb4',
			'collate'	=> 'utf8mb4_unicode_ci',
			'lc_messages'	=> 'ru_RU',
		),
	);

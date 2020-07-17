<?php

	return array(
		array(
			'command'		=> 'alter table [table_name]:[alter_description]',
			'class'			=> '\\System\\Console\\Make\\DB_Alter',
			'method'		=> 'execute',
			'status'		=> 1,
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'i',
			'description'	=> 'Create Database Migration Alter Table',
			'example'		=> 'php cli alter table users:add_users_id_field',
		),
		array(
			'command'		=> 'make table [table_name]',
			'class'			=> '\\System\\Console\\Make\\DB_Table',
			'method'		=> 'execute',
			'status'		=> 1,
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'i',
			'description'	=> 'Create Database Migration New Table',
			'example'		=> 'php cli make table users',
		),
		array(
			'command'		=> 'migrate',
			'class'			=> '\\System\\Console\\Migration\\Run',
			'method'		=> 'execute',
			'status'		=> 1,
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'i',
			'description'	=> 'migration all migrations files to db',
			'example'		=> 'php cli migration run',
		),
	);
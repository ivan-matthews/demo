<?php

	use Core\Classes\Kernel;

	return array(
		'home_index_before' 	=> array(),
		'home_index_instead' 	=> array(),
		'home_index_after' 		=> array(),

		'load_system_before'	=> array(),
		'load_system_after'		=> array(
			'class'		=> Core\Hooks\Load_Script_After::class,
			'method'	=> 'run',
			'status'	=> Kernel::STATUS_ACTIVE,
		),

		'session_start_before'	=> array(),
		'session_start_after'	=> array(
			'class'		=> Core\Hooks\Session_Start_After::class,
			'method'	=> 'run',
			'status'	=> Kernel::STATUS_ACTIVE,
		),

		'set_language_before'	=> array(),
		'set_language_after'	=> array(),

		'parse_url_before'		=> array(),
		'parse_url_after'		=> array(),

		'controller_run_before'	=> array(),
		'controller_run_after'	=> array(),

		'render_data_before'	=> array(),
		'render_data_after'		=> array(),
	);
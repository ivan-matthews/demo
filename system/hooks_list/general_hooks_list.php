<?php

	use Core\Classes\Kernel;

	return array(
		'load_system_after_hook'	=> array(
			'class'			=> Core\Hooks\Load_System_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'session_start_before_hook'	=> array(
			'class'			=> Core\Hooks\Session_Start_Before_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'session_start_after_hook'	=> array(
			'class'			=> Core\Hooks\Session_Start_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'render_data_before_hook'	=> array(
			'class'			=> \Core\Hooks\Render_Data_Before_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'cli_composer_update_before_hook'	=> array(
			'class'			=> \Core\Hooks\Cli_Composer_Update_Before_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'cli_engine_install_after_hook'	=> array(
			'class'			=> \Core\Hooks\Cli_Engine_Install_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);
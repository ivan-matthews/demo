<?php

	use Core\Classes\Kernel;

	return array(
		'load_system_after_hook'	=> array(
			'class'			=> Core\Hooks\Load_System_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'session_start_before_hook'	=> array(
			'class'			=> Core\Hooks\Session_Start_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'session_start_after_hook'	=> array(
			'class'			=> Core\Hooks\Session_Start_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'render_data_before_hook'	=> array(
			'class'			=> \Core\Hooks\Render_Data_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
	);
<?php

	use Core\Classes\Kernel;

	$active = Kernel::STATUS_ACTIVE;

	return array(
		'load_system_after_hook'	=> array(
			'class'			=> Core\Hooks\Load_System_After_Hook::class,
			'method'		=> 'run',
			'status'		=> $active,
			'controller'	=> 'home',
			'action'		=> 'index',
		),

		'session_start_before_hook'	=> array(
			'class'			=> Core\Hooks\Session_Start_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> $active,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'session_start_after_hook'	=> array(
			'class'			=> Core\Hooks\Session_Start_After_Hook::class,
			'method'		=> 'run',
			'status'		=> $active,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'home_index_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Home_Index_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> $active,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'controller_run_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Controller_Run_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_INACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'render_data_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Render_Data_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> $active,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
	);
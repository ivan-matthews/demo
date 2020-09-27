<?php

	use Core\Classes\Kernel;

	return array(
		'widgets_run_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Widgets_Run_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'home_index_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Home_Index_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'controller_run_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Controller_Run_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
		'render_data_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Render_Data_Before_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
	);

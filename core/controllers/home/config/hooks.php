<?php

	use Core\Classes\Kernel;

	return array(
		'widgets_run_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Widgets_Run_Before_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'home_index_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Home_Index_Before_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'controller_run_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Controller_Run_Before_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'render_data_before_hook'	=> array(
			'class'			=> \Core\Controllers\Home\Hooks\Render_Data_Before_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);

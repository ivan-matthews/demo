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

	);

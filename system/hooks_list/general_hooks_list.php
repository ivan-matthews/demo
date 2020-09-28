<?php

	use Core\Classes\Kernel;

	return array(
		'load_system_after_hook'	=> array(
			'class'			=> Core\Hooks\Load_System_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_INACTIVE,
			'controller'	=> 'home',
			'action'		=> 'index',
		),
	);

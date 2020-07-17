<?php

	use Core\Classes\Kernel;

	return array(
		'home_index_get_before' => array(
			'class'		=> Core\Controllers\Home\Hooks\Home_Index_Get_Before::class,
			'method'	=> 'run',
			'status'	=> Kernel::STATUS_ACTIVE,
		),
		'home_index_get_instead' => array(
			'class'		=> Core\Controllers\Home\Hooks\Home_Index_Get_Instead::class,
			'method'	=> 'run',
			'status'	=> Kernel::STATUS_ACTIVE,
		),
		'home_index_get_after' => array(
			'class'		=> Core\Controllers\Home\Hooks\Home_Index_Get_After::class,
			'method'	=> 'run',
			'status'	=> Kernel::STATUS_ACTIVE,
		),
	);
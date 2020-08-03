<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'avatar.controller_name',
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'index'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'item'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
		),
		'file_types'	=> array('jpg','jpeg','png','bmp'),
		'file_size'		=> 2*1024*1024,
		'image_params'	=> array(
			'micro'	=> array(
				'width'		=> 24,
				'height'	=> 24,		// квадраты
			),
			'small'	=> array(
				'width'		=> 64,
				'height'	=> 64,		// квадраты
			),
			'medium'=> array(
				'width'		=> 96,
				'height'	=> 96,		// квадраты
			),
			'normal'=> array(
				'width'		=> 240,
				'height'	=> 320,		// 0 - оригинальная высота
			),
			'big'	=> array(
				'width'		=> 360,
				'height'	=> 480,		// 0 - оригинальная высота
			),
		),
	);
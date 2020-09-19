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
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'item'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'add'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'delete'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'edit'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'images'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'set'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'unlink'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
		),
		'file_types'	=> array('jpg','jpeg','png','bmp'),
		'file_size'		=> 2*1024*1024,
		'image_params'	=> array(
			'micro'	=> array(
				'width'		=> 32,
				'height'	=> 32,
			),
			'small'	=> array(
				'width'		=> 64,
				'height'	=> 64,
			),
			'medium'=> array(
				'width'		=> 128,
				'height'	=> 128,
			),
			'normal'=> array(
				'width'		=> 240,
				'height'	=> 320,
			),
			'big'	=> array(
				'width'		=> 360,
				'height'	=> 480,
			),
		),
		'sorting_panel'	=> array(
			'all'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'avatar.all_avatars_sorting',
				'link'	=> array('avatar','index','%current_user_id%','all'),
				'icon'	=> null,
			),
			'created'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'avatar.created_avatars_sorting',
				'link'	=> array('avatar','index','%current_user_id%','created'),
				'icon'	=> null,
			),
			'updated'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'avatar.updated_avatars_sorting',
				'link'	=> array('avatar','index','%current_user_id%','updated'),
				'icon'	=> null,
			),
			'random'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'avatar.random_avatars_sorting',
				'link'	=> array('avatar','index','%current_user_id%','random'),
				'icon'	=> null,
			),
		),
	);
<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'photos.controller_name',
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
			'user'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
		),
		'sorting_panel'	=> array(
			'all'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'photos.all_photos_sorting',
				'link'	=> array('photos','index','all'),
				'icon'	=> null,
			),
			'created'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'photos.created_photos_sorting',
				'link'	=> array('photos','index','created'),
				'icon'	=> null,
			),
			'updated'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'photos.updated_photos_sorting',
				'link'	=> array('photos','index','updated'),
				'icon'	=> null,
			),
			'random'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'photos.random_photos_sorting',
				'link'	=> array('photos','index','random'),
				'icon'	=> null,
			),
		),
	);
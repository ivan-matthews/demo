<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'videos.controller_name',
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
				'title'	=> 'videos.all_videos_sorting',
				'link'	=> array('videos','index','all'),
				'icon'	=> null,
			),
			'created'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'videos.created_videos_sorting',
				'link'	=> array('videos','index','created'),
				'icon'	=> null,
			),
			'updated'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'videos.updated_videos_sorting',
				'link'	=> array('videos','index','updated'),
				'icon'	=> null,
			),
			'random'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'videos.random_videos_sorting',
				'link'	=> array('videos','index','random'),
				'icon'	=> null,
			),
		),
		'enable_comments'	=> true,
	);
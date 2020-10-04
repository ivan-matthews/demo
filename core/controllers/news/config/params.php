<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'news.controller_name',
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'add'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(0),
			),
			'delete'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(0),
			),
			'edit'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(0),
			),
			'index'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'item'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
		),
		'sorting_panel'	=> array(
			'all'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'news.all_posts_sorting',
				'link'	=> array('news','index','all'),
				'icon'	=> null,
			),
			'my'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'news.my_posts_sorting',
				'link'	=> array('news','index','my'),
				'icon'	=> null,
			),
			'created'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'news.created_posts_sorting',
				'link'	=> array('news','index','created'),
				'icon'	=> null,
			),
			'updated'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'news.updated_posts_sorting',
				'link'	=> array('news','index','updated'),
				'icon'	=> null,
			),
			'random'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'news.random_posts_sorting',
				'link'	=> array('news','index','random'),
				'icon'	=> null,
			),
		),
	);
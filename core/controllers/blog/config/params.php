<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'blog.controller_name',
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'add'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'delete'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'edit'	=> array(
				'groups_enabled'	=> array(),
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
				'title'	=> 'blog.all_posts_sorting',
				'link'	=> array('blog','index','all'),
				'icon'	=> null,
			),
			'my'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'blog.my_posts_sorting',
				'link'	=> array('blog','index','my'),
				'icon'	=> null,
			),
			'created'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'blog.created_posts_sorting',
				'link'	=> array('blog','index','created'),
				'icon'	=> null,
			),
			'updated'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'blog.updated_posts_sorting',
				'link'	=> array('blog','index','updated'),
				'icon'	=> null,
			),
			'random'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'blog.random_posts_sorting',
				'link'	=> array('blog','index','random'),
				'icon'	=> null,
			),
		),
	);
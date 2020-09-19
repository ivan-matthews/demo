<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'files.controller_name',
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
				'title'	=> 'files.all_files_sorting',
				'link'	=> array('files','index','all'),
				'icon'	=> null,
			),
			'created'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'files.created_files_sorting',
				'link'	=> array('files','index','created'),
				'icon'	=> null,
			),
			'updated'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'files.updated_files_sorting',
				'link'	=> array('files','index','updated'),
				'icon'	=> null,
			),
			'random'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'files.random_files_sorting',
				'link'	=> array('files','index','random'),
				'icon'	=> null,
			),
		),
		'enable_comments'	=> true,
	);
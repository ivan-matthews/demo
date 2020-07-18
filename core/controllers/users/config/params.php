<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'users.controller_name',
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
		'sorting_panel'	=> array(
			'all'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'users.users_index_all_title',
				'link'	=> array('users','index','all'),
			),
			'online'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'users.users_index_online_title',
				'link'	=> array('users','index','online')
			),
			'last_visit'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'users.users_index_last_visit_title',
				'link'	=> array('users','index','last_visit')
			),
			'registration'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_registration_title',
				'link'	=> array('users','index','registration')
			),
			'active'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_active_title',
				'link'	=> array('users','index','active')
			),
			'inactive'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_inactive_title',
				'link'	=> array('users','index','inactive')
			),
			'locked'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_locked_title',
				'link'	=> array('users','index','locked')
			),
		),
	);
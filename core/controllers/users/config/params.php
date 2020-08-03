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
				'icon'	=> null,
			),
			'online'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'users.users_index_online_title',
				'link'	=> array('users','index','online'),
				'icon'	=> null,
			),
			'last_visit'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'users.users_index_last_visit_title',
				'link'	=> array('users','index','last_visit'),
				'icon'	=> null,
			),
			'avatar'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'users.users_with_avatar_title',
				'link'	=> array('users','index','avatar'),
				'icon'	=> null,
			),
			'random'	=> array(
				'status'=> Kernel::STATUS_ACTIVE,
				'title'	=> 'users.users_random_title',
				'link'	=> array('users','index','random'),
				'icon'	=> null,
			),
			'registration'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_registration_title',
				'link'	=> array('users','index','registration'),
				'icon'	=> null,
			),
			'active'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_active_title',
				'link'	=> array('users','index','active'),
				'icon'	=> null,
			),
			'inactive'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_inactive_title',
				'link'	=> array('users','index','inactive'),
				'icon'	=> null,
			),
			'locked'	=> array(
				'status'=> Kernel::STATUS_INACTIVE,
				'title'	=> 'users.users_index_locked_title',
				'link'	=> array('users','index','locked'),
				'icon'	=> null,
			),
		),
		'header_bar_user_edit'	=> array(
			'field_set_name'	=> array(
				'title'	=> 'users.header_bar_name',
				'link'	=> array(),
			),
			'geo_info'	=> array(
				'title'	=> 'users.header_bar_geo',
				'link'	=> array(),
			),
			'field_set_birth_date'	=> array(
				'title'	=> 'users.header_bar_old',
				'link'	=> array(),
			),
			'field_set_contacts'	=> array(
				'title'	=> 'users.header_bar_contacts',
				'link'	=> array(),
			),
			'field_set_activities'	=> array(
				'title'	=> 'users.header_bar_about',
				'link'	=> array(),
			),
		)
	);
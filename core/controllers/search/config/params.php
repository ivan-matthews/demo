<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'search.controller_name',
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

		'header_bar'	=> array(
			'users'	=> array(
				'title'	=> 'search.find_by_users_table_head',
				'link'	=> array(),
				'fields'=> array(
					'id'		=> 'u_id',
					'title'		=> 'u_full_name',
					'content'	=> 'u_about',
					'image'		=> 'u_avatar_id',
					'date' 		=> 'u_date_created',
				),
				'search_fields'		=> array('u_full_name','u_about'),
			),
			/*'status'	=> array(
				'title'	=> 'search.find_by_status_table_head',
				'link'	=> array(),
				'fields'=> array(
					'id'		=> 's_id',
					'title'		=> '',
					'content'	=> 's_content',
					'image'		=> '',
					'date' 		=> 's_date_created',
				),
				'search_fields'		=> array('s_content'),
			),*/
			/*'photos'	=> array(
				'title'	=> 'search.find_by_photos_table_head',
				'link'	=> array(),
				'fields'=> array(
					'id'		=> 'p_id',
					'title'		=> '',
					'content'	=> 'p_description',
					'image'		=> 'p_medium',
					'date' 		=> 'p_date_created',
				),
				'search_fields'		=> array('p_description'),
			),*/
		)
	);
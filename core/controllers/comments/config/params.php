<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'comments.controller_name',
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'add'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'reply'	=> array(
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
		'allowed_controllers'	=> array(
			'blog'	=> array(
				'table_name'	=> 'blog',
				'id_field'		=> 'b_id',
				'count_field'	=> 'b_total_comments',
				'author_field'	=> 'b_user_id',
				'status_field'	=> 'b_status',
			),
			'avatar'	=> array(
				'table_name'	=> 'photos',
				'id_field'		=> 'p_id',
				'count_field'	=> 'p_total_comments',
				'author_field'	=> 'p_user_id',
				'status_field'	=> 'p_status',
			),
			'photos'	=> array(
				'table_name'	=> 'photos',
				'id_field'		=> 'p_id',
				'count_field'	=> 'p_total_comments',
				'author_field'	=> 'p_user_id',
				'status_field'	=> 'p_status',
			),
			'files'	=> array(
				'table_name'	=> 'files',
				'id_field'		=> 'f_id',
				'count_field'	=> 'f_total_comments',
				'author_field'	=> 'f_user_id',
				'status_field'	=> 'f_status',
			),
			'audios'	=> array(
				'table_name'	=> 'audios',
				'id_field'		=> 'au_id',
				'count_field'	=> 'au_total_comments',
				'author_field'	=> 'au_user_id',
				'status_field'	=> 'au_status',
			),
			'videos'	=> array(
				'table_name'	=> 'videos',
				'id_field'		=> 'v_id',
				'count_field'	=> 'v_total_comments',
				'author_field'	=> 'v_user_id',
				'status_field'	=> 'v_status',
			),
		),
	);
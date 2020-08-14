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
			)
		),
	);
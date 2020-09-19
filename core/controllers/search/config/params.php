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
		'default_controller'	=> 'users',
		'header_bar'	=> array(
			'users'		=> array(),
			'blog'		=> array(),
//			'faq'		=> array(),
			'comments'	=> array(),
			'photos'	=> array(),
			'videos'	=> array(),
			'audios'	=> array(),
			'files'		=> array(),
		),
	);
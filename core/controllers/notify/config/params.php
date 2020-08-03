<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'notify.controller_name',
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
				'title'	=> 'notify.all_notices_sorting',
				'link'	=> array('notify','index','%current_user_id%','all'),
			),
			'unreaded'	=> array(
				'title'	=> 'notify.unreaded_notices_sorting',
				'link'	=> array('notify','index','%current_user_id%','created'),
			),
			'readed'	=> array(
				'title'	=> 'notify.readed_notices_sorting',
				'link'	=> array('notify','index','%current_user_id%','updated'),
			),
		),
	);
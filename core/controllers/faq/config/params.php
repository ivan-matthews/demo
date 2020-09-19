<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'faq.controller_name',
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
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'edit'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
			'delete'	=> array(
				'groups_enabled'	=> array(5),
				'groups_disabled'	=> array(),
			),
		)
	);
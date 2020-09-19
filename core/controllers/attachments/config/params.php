<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'attachments.controller_name',
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'index'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'item'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'audios'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'files'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'photos'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'photo'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'videos'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
		)
	);
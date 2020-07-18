<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> fx_lang('home.controller_name'),
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'index'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
		),
		'just_widgets'	=> Kernel::STATUS_INACTIVE,
		'another_controller'	=> array(
			'class'		=> '',
			'method'	=> 'methodGet',
			'params'	=> 1
		)
	);
<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'home.controller_name',
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

		'just_widgets'	=> false,
		'another_controller'	=> array(
			'run'		=> false,
			'class'		=> '',
			'method'	=> 'methodGet',
			'params'	=> array(

			)
		)
	);
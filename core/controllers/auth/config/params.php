<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> fx_lang('auth.controller_name'),
		'groups_after_registration'	=> array(1),		// guest
		'groups_after_verification'	=> array(2),		// user
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'		=> array(
			'index'				=> array(
				'enable_captcha'	=> false,
				'groups_enabled'	=> array(0),
				'groups_disabled'	=> array(),
			),
			'item'				=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'logout'			=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'registration'		=> array(
				'enable_captcha'	=> false,
				'groups_enabled'	=> array(0),
				'groups_disabled'	=> array(),
			),
			'resend_email'		=> array(
				'enable_captcha'	=> true,
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(0),
			),
			'restore_password'	=> array(
				'groups_enabled'	=> array(0),
				'groups_disabled'	=> array(),
			),
			'restore_password_confirm'	=> array(
				'groups_enabled'	=> array(0),
				'groups_disabled'	=> array(),
			),
			'verify_account'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
		)
	);
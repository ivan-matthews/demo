<?php

	use Core\Classes\Kernel;

	return array(
		'auth_index_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Index_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'auth',
			'action'		=> 'index',
		),
		'auth_registration_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Registration_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'auth',
			'action'		=> 'registration',
		),
		'auth_item_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Item_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'auth',
			'action'		=> 'item',
		),
		'auth_verify_account_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Verify_Account_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'auth',
			'action'		=> 'verify_account',
		),
		'controller_run_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Controller_Run_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'auth',
			'action'		=> 'verify_account',
		),
	);
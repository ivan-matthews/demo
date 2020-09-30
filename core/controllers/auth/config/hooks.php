<?php

	use Core\Classes\Kernel;

	return array(
		'auth_index_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Index_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'auth_registration_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Registration_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'auth_item_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Item_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'auth_verify_account_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Auth_Verify_Account_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'controller_run_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Controller_Run_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'cli_engine_install_after_hook'	=> array(
			'class'			=> \Core\Controllers\Auth\Hooks\Cli_Engine_Install_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 4,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);
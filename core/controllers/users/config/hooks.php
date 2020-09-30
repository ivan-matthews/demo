<?php

	use Core\Classes\Kernel;

	return array(
		'session_start_after_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Session_Start_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 9999,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'users_item_after_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Users_Item_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'sitemap_generate_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Generate_Users_Sitemap::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'search_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Search_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'cli_engine_install_after_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Cli_Engine_Install_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 5,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);
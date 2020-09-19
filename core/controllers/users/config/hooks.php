<?php

	use Core\Classes\Kernel;

	return array(
		'session_start_after_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Session_Start_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'users',
			'action'		=> 'index',
		),
		'users_item_after_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Users_Item_After_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'users',
			'action'		=> 'index',
		),
		'sitemap_generate_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Generate_Users_Sitemap::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'users',
			'action'		=> 'index',
		),
		'search_hook'	=> array(
			'class'			=> \Core\Controllers\Users\Hooks\Search_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'users',
			'action'		=> 'index',
		),
	);
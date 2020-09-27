<?php

	use Core\Classes\Kernel;

	return array(
		'sitemap_generate_hook'	=> array(
			'class'			=> \Core\Controllers\Pages\Hooks\Generate_Blog_Sitemap::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'pages',
			'action'		=> 'index',
		),
		'search_hook'	=> array(
			'class'			=> \Core\Controllers\Pages\Hooks\Search_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'pages',
			'action'		=> 'index',
		),
	);
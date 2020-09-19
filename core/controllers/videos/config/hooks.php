<?php

	use Core\Classes\Kernel;

	return array(
		'sitemap_generate_hook'	=> array(
			'class'			=> \Core\Controllers\Videos\Hooks\Generate_Videos_Sitemap::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'videos',
			'action'		=> 'index',
		),
		'search_hook'	=> array(
			'class'			=> \Core\Controllers\Videos\Hooks\Search_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'videos',
			'action'		=> 'index',
		),
	);

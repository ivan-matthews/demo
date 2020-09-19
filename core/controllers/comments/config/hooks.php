<?php

	use Core\Classes\Kernel;

	return array(
		'sitemap_generate_hook'	=> array(
			'class'			=> \Core\Controllers\Comments\Hooks\Generate_Comments_Sitemap::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'comments',
			'action'		=> 'index',
		),
		'search_hook'	=> array(
			'class'			=> \Core\Controllers\Comments\Hooks\Search_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'comments',
			'action'		=> 'index',
		),
	);

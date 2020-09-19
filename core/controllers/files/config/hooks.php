<?php

	use Core\Classes\Kernel;

	return array(
		'sitemap_generate_hook'	=> array(
			'class'			=> \Core\Controllers\Files\Hooks\Generate_Files_Sitemap::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'files',
			'action'		=> 'index',
		),
		'search_hook'	=> array(
			'class'			=> \Core\Controllers\Files\Hooks\Search_Hook::class,
			'method'		=> 'run',
			'status'		=> Kernel::STATUS_ACTIVE,
			'controller'	=> 'files',
			'action'		=> 'index',
		),
	);

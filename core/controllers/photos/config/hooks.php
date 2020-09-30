<?php

	use Core\Classes\Kernel;

	return array(
		'sitemap_generate_hook'	=> array(
			'class'			=> \Core\Controllers\Photos\Hooks\Generate_Photos_Sitemap::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'search_hook'	=> array(
			'class'			=> \Core\Controllers\Photos\Hooks\Search_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);

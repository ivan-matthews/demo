<?php

	use Core\Classes\Kernel;

	return array(
		'sitemap_generate_after_hook'	=> array(
			'class'			=> \Core\Controllers\Sitemap\Hooks\Create_Root_XML::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_INACTIVE,
		),
	);
<?php

	use Core\Classes\Kernel;

	return array(
		'status'	=> Kernel::STATUS_ACTIVE,
		'controller_name'	=> 'sitemap.controller_name',
		'controller'	=> array(
			'groups_enabled'	=> array(),
			'groups_disabled'	=> array(),
		),
		'actions'	=> array(
			'index'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
			'item'	=> array(
				'groups_enabled'	=> array(),
				'groups_disabled'	=> array(),
			),
		),
		'site_map_root_path'	=> 'public/sitemaps',
	);
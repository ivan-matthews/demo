<?php

	use Core\Classes\Kernel;
	use Core\Classes\Request;

	return array(
		array(
			'url'			=> 'rules',
			'controller'	=> 'pages',
			'action'		=> 'item',
			'params'		=> array(1),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> 'terms',
			'controller'	=> 'pages',
			'action'		=> 'item',
			'params'		=> array(2),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> 'privacy',
			'controller'	=> 'pages',
			'action'		=> 'item',
			'params'		=> array(3),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> 'cookie',
			'controller'	=> 'pages',
			'action'		=> 'item',
			'params'		=> array(4),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> 'site-news',
			'controller'	=> 'pages',
			'action'		=> 'index',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> function(){
				Request::getInstance()->set('cat','6');
			},
			'status'		=> Kernel::STATUS_ACTIVE,
		),

	);

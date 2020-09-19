<?php

	use Core\Classes\Kernel;

	return array(
		array(
			'url'			=> 'rules',
			'controller'	=> 'blog',
			'action'		=> 'item',
			'params'		=> array(1),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_INACTIVE,
		),
	);
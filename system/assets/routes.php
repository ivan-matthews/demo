<?php

	use Core\Classes\Kernel;

	return array(
		array(
			'url'			=> 'id[id]',
			'controller'	=> 'users',
			'action'		=> 'item',
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);
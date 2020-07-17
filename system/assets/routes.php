<?php

	return array(
		0	=> array(
			'url'			=> '@[id]',
			'controller'	=> 'home',
			'action'		=> 'item',
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> \Core\Classes\Kernel::STATUS_ACTIVE,
		),
	);
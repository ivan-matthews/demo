<?php

	use Core\Classes\Kernel;

	return array(

		array(
			'url'			=> 'journal-[статус чтения]',
			'controller'	=> 'notify',
			'action'		=> 'index',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),

	);

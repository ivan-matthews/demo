<?php

	use Core\Classes\Kernel;

	return array(
		array(
			'url'			=> 'contact[id]',
			'controller'	=> 'messages',
			'action'		=> 'item',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> 'contacts',
			'controller'	=> 'messages',
			'action'		=> 'index',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> 'msg[id]-send',
			'controller'	=> 'messages',
			'action'		=> 'add',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);

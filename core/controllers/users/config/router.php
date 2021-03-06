<?php

	use Core\Classes\Kernel;

	return array(
		array(
			'url'			=> '№[ID пользователя]',
			'controller'	=> 'users',
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
			'url'			=> '@[ID пользователя]-photos',
			'controller'	=> 'users',
			'action'		=> 'photos',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> '@[ID пользователя]-videos',
			'controller'	=> 'users',
			'action'		=> 'videos',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> '@[ID пользователя]-audios',
			'controller'	=> 'users',
			'action'		=> 'audios',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> '@[ID пользователя]-files',
			'controller'	=> 'users',
			'action'		=> 'files',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> '@[ID пользователя]-blog',
			'controller'	=> 'users',
			'action'		=> 'blog',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> '@[ID пользователя]-edit',
			'controller'	=> 'users',
			'action'		=> 'edit',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		array(
			'url'			=> '@[ID пользователя]-edit-[блок, который будем редактировать]',
			'controller'	=> 'users',
			'action'		=> 'edit',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);

<?php

	use Core\Classes\Kernel;

	return array(

		array(
			'url'			=> 'post/[post id].php',
			'controller'	=> 'blog',
			'action'		=> 'post',
			'params'		=> array(),
			'pattern'		=> '([a-zа-я0-9-_.]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_ACTIVE,
		),

	);

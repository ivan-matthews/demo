<?php

	use Core\Classes\Kernel;

	return array(

		array(
			'url'			=> 'news-post/[post id].html',
			'controller'	=> 'news',
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

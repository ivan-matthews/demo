<?php

	use Core\Classes\Kernel;

	return array(
		array(
			'url'			=> 'audios-add',
			'controller'	=> 'audios',
			'action'		=> 'add',
			'params'		=> array(),
			'pattern'		=> '([a-z]+)',
			'modifier'		=> 'iu',
			'sorting'		=> 1,
			'before'		=> null,
			'after'			=> null,
			'status'		=> Kernel::STATUS_INACTIVE,
		),

	);

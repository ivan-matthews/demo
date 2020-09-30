<?php

	use Core\Classes\Kernel;

	return array(

		'users_item_after_hook'	=> array(
			'class'			=> \Core\Controllers\Messages\Hooks\Users_Item_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),

		'users_index_after_hook'	=> array(
			'class'			=> \Core\Controllers\Messages\Hooks\Users_Index_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);
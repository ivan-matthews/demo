<?php

	use Core\Classes\Kernel;

	return array(
		'cli_engine_install_after_hook'	=> array(
			'class'			=> \Core\Hooks\Cli_Engine_Install_After_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);

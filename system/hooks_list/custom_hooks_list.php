<?php

	use Core\Classes\Kernel;

	return array(
		'load_system_after_hook'	=> array(
			'class'			=> Core\Active_Hooks\Set_Back_URL_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'session_start_before_hook'	=> array(
			'class'			=> Core\Active_Hooks\Check_Session_File_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'session_start_after_hook'	=> array(
			'class'			=> Core\Active_Hooks\Check_Authorize_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
		'render_data_before_hook'	=> array(
			'class'			=> \Core\Active_Hooks\Send_Message_To_New_User_Hook::class,
			'method'		=> 'run',
			'relevance'		=> 10000,
			'status'		=> Kernel::STATUS_ACTIVE,
		),
	);
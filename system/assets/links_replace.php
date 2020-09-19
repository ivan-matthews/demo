<?php

	use Core\Classes\Config;

	$config = Config::getInstance();

	return array(
		'%csrf_token%'	=> fx_csrf(),
		'%csrf_name%'	=> $config->session['csrf_key_name'],
	);

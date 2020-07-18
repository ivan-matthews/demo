<?php

	use Core\Classes\Session;
	use Core\Classes\Config;

	$session = Session::getInstance();
	$config = Config::getInstance();

	return array(
		'%csrf_token%'	=> fx_csrf(),
		'%csrf_name%'	=> $config->session['csrf_key_name'],
		'%user_id%'		=> $session->get('u_id',Session::PREFIX_AUTH),
	);
<?php

	use Core\Classes\Session;

	$session = Session::getInstance();

	return array(
		'%user_id%'		=> $session->get('u_id',Session::PREFIX_AUTH),
	);

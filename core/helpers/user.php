<?php

	use Core\Classes\Request;
	use Core\Classes\Session;

	function fx_csrf_equal(){
		$request = Request::getInstance();
		$session = Session::getInstance();
		$request_csrf = $request->get('csrf');
		$session_csrf = $session->get('csrf',Session::PREFIX_CONF);
		if(fx_equal(fx_encode($session_csrf),$request_csrf)){
			return true;
		}
		return false;
	}
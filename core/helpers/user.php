<?php

	use Core\Classes\Request;
	use Core\Classes\Config;
	use Core\Classes\User;
	use Core\Classes\Form\Validator;

	function fx_csrf_equal($csrf_field_name='csrf'){
		$request = Request::getInstance();
		$request_csrf = $request->get($csrf_field_name);
		if(!$request_csrf){
			return Validator::CSRF_TOKEN_NOT_FOUND;
		}
		if(fx_equal(fx_csrf(),$request_csrf)){
			return Validator::CSRF_TOKEN_EQUAL;
		}
		return Validator::CSRF_TOKEN_NOT_EQUAL;
	}

	function fx_csrf(){
		$user = User::getInstance();
		$csrf = $user->getCSRFToken();
		return fx_encode($csrf);
	}

	function fx_get_csrf_field(){
		$config = Config::getInstance();
		$csrf_token = fx_csrf();
		$field = "<input type=\"hidden\" ";
		$field .= "name=\"{$config->session['csrf_key_name']}\" ";
		$field .= "value=\"{$csrf_token}\"";
		$field .= "/>";
		return $field;
	}
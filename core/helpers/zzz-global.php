<?php

	if(!function_exists('fx_get_server')){
		function fx_get_server($variable=false){
			if(!$variable){ return $_SERVER; }
			if(isset($_SERVER[$variable])){
				return $_SERVER[$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_server')){
		function fx_set_server($variable,$new_value){
			$_SERVER[$variable] = $new_value;
			return $_SERVER[$variable];
		}
	}

	if(!function_exists('fx_get_request')){
		function fx_get_request($variable=false){
			if(!$variable){ return $_REQUEST; }
			if(isset($_REQUEST[$variable])){
				return $_REQUEST[$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_request')){
		function fx_set_request($variable,$new_value){
			$_REQUEST[$variable] = $new_value;
			return $_REQUEST[$variable];
		}
	}

	if(!function_exists('fx_get_get')){
		function fx_get_get($variable=false){
			if(!$variable){ return $_GET; }
			if(isset($_GET[$variable])){
				return $_GET[$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_get')){
		function fx_set_get($variable,$new_value){
			$_GET[$variable] = $new_value;
			return $_GET[$variable];
		}
	}

	if(!function_exists('fx_get_post')){
		function fx_get_post($variable=false){
			if(!$variable){ return $_POST; }
			if(isset($_POST[$variable])){
				return $_POST[$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_post')){
		function fx_set_post($variable,$new_value){
			$_POST[$variable] = $new_value;
			return $_POST[$variable];
		}
	}

	if(!function_exists('fx_is_cli')){
		function fx_is_cli(){
			if(fx_equal(PHP_SAPI,'cli')){
				return true;
			}
			return false;
		}
	}

	if(!function_exists('fx_get_const')){
		function fx_get_const($constant){
			if(defined($constant)){
				return $constant;
			}
			return null;
		}
	}

	if(!function_exists('fx_get_global')){
		function fx_get_global($key){
			if(isset($GLOBALS[$key])){
				return $GLOBALS[$key];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_global')){
		function fx_set_global($key,$value){
			$GLOBALS[$key] = $value;
			return $GLOBALS[$key];
		}
	}
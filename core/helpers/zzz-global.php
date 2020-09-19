<?php

	if(!function_exists('fx_get_server')){
		function fx_get_server($variable=false){
			if(!$variable){ return $GLOBALS['_SERVER']; }
			if(isset($GLOBALS['_SERVER'][$variable])){
				return $GLOBALS['_SERVER'][$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_server')){
		function fx_set_server($variable,$new_value){
			$GLOBALS['_SERVER'][$variable] = $new_value;
			return $GLOBALS['_SERVER'][$variable];
		}
	}

	if(!function_exists('fx_get_request')){
		function fx_get_request($variable=false){
			if(!$variable){ return $GLOBALS['_REQUEST']; }
			if(isset($GLOBALS['_REQUEST'][$variable])){
				return $GLOBALS['_REQUEST'][$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_request')){
		function fx_set_request($variable,$new_value){
			$GLOBALS['_REQUEST'][$variable] = $new_value;
			return $GLOBALS['_REQUEST'][$variable];
		}
	}

	if(!function_exists('fx_get_get')){
		function fx_get_get($variable=false){
			if(!$variable){ return $GLOBALS['_GET']; }
			if(isset($GLOBALS['_GET'][$variable])){
				return $GLOBALS['_GET'][$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_get')){
		function fx_set_get($variable,$new_value){
			$GLOBALS['_GET'][$variable] = $new_value;
			return $GLOBALS['_GET'][$variable];
		}
	}

	if(!function_exists('fx_get_post')){
		function fx_get_post($variable=false){
			if(!$variable){ return $GLOBALS['_POST']; }
			if(isset($GLOBALS['_POST'][$variable])){
				return $GLOBALS['_POST'][$variable];
			}
			return null;
		}
	}

	if(!function_exists('fx_set_post')){
		function fx_set_post($variable,$new_value){
			$GLOBALS['_POST'][$variable] = $new_value;
			return $GLOBALS['_POST'][$variable];
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

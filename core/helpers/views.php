<?php

	function fx_get_preparing_url(...$link_args){
		$router = \Core\Classes\Router::getInstance();
		$config = \Core\Classes\Config::getInstance();
		if(isset($link_args[1])){
			if(($response_url = $router->searchURLInRoutesList(...$link_args))){
				return $response_url;
			}
			if(fx_equal($link_args[1],'index') && !isset($link_args[2])){
				return $link_args[0];
			}
			if(fx_equal($link_args[1],'item')){
				unset($link_args[1]);
			}
			return implode($config->router['url_delimiter'],$link_args);
		}
		if(isset($link_args[0])){
			return str_replace('.',$config->router['url_delimiter'],$link_args[0]);
		}
		return null;
	}

	function fx_get_url(...$link_args){
		$url = fx_get_preparing_url(...$link_args);
		return "/{$url}";
	}

	function fx_get_web_dir_name(){
		return trim(dirname(fx_get_server('PHP_SELF')),DIRECTORY_SEPARATOR);
	}
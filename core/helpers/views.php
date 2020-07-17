<?php

	function fx_get_preparing_url(...$link_args){
		$router = \Core\Classes\Router::getInstance();
		$config = \Core\Classes\Config::getInstance();
		if(isset($link_args[1])){
			if(($response_url = $router->searchURLInRoutesList(...$link_args))){
				return $response_url;
			}
			return implode($config->router['url_delimiter'],$link_args);
		}
		return str_replace('.',$config->router['url_delimiter'],$link_args[0]);
	}

	function fx_get_url(...$link_args){
		$url = fx_get_preparing_url(...$link_args);
		return "/{$url}";
	}

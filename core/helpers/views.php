<?php

	use Core\Classes\Router;
	use Core\Classes\Config;
	use Core\Classes\Kernel;
	use Core\Classes\User;

	function fx_get_preparing_url(...$link_args){
		$router = Router::getInstance();
		$config = Config::getInstance();
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

	function fx_get_web_dir_name(){
		return trim(dirname(fx_get_server('PHP_SELF')),DIRECTORY_SEPARATOR);
	}

	function fx_get_url(...$link_args){
		$url = fx_get_preparing_url(...$link_args);
		return "/{$url}";
	}

	function fx_url($link=array()){
		if(isset($link['link'])){
			$kernel = Kernel::getInstance();
			$url = fx_get_url(...$link['link']);
			if(isset($link['query']) && $link['query']){
				$url .= "?";
				$url .= http_build_query($link['query']);
			}
			return str_replace(
				array_keys($kernel->link_replacer_list),
				array_values($kernel->link_replacer_list),
				urldecode($url)
			);
		}
		return fx_get_url(...$link);
	}

	function fx_make_url(array $link, $query=array(), $merge_query=true){
		if($merge_query){
			$request = Router::getInstance()->getRequest();
			$query = array_merge($request,$query);
		}
		return fx_url(array(
			'link'	=> $link,
			'query'	=> $query
		));
	}

	function fx_is_online($date_log){
		if($date_log < time()){
			return false;
		}
		return true;
	}

	function fx_online_status($date_log){
		if(!fx_is_online($date_log)){
			return fx_lang('users.user_is_offline');
		}
		return fx_lang('users.user_is_online');
	}

	function fx_get_icon_logged($user_log_type){
		$icons = array(
			User::LOGGED_DESKTOP	=> '<i class="fas fa-desktop" aria-hidden="true"></i>',
			User::LOGGED_APPLE		=> '<i class="fab fa-apple" aria-hidden="true"></i>',
			User::LOGGED_ANDROID	=> '<i class="fab fa-android" aria-hidden="true"></i>',
			User::LOGGED_TABLET		=> '<i class="fas fa-tablet-alt" aria-hidden="true"></i>',
			User::LOGGED_MOBILE		=> '<i class="fas fa-mobile-alt" aria-hidden="true"></i>',
			User::LOGGED_DEFAULT	=> '<i class="far fa-circle" aria-hidden="true"></i>',
		);
		if(isset($icons[$user_log_type])){
			return $icons[$user_log_type];
		}
		return $icons[User::LOGGED_DEFAULT];
	}

	function fx_avatar($avatars=array(),$size='normal',$gender=3){

	}












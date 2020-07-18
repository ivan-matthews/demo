<?php

	use Core\Classes\Router;
	use Core\Classes\Config;
	use Core\Classes\Kernel;

	function fx_get_web_dir_name(){
		return trim(dirname(fx_get_server('PHP_SELF')),DIRECTORY_SEPARATOR);
	}

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

	function fx_make_url($link=array(), $query=array(), $merge_query=true){
		if(fx_equal($link,'#')){
			return "javascript:void(0)";
		}
		if($merge_query){
			$request = Router::getInstance()->getRequest();
			$query = array_merge($request,$query);
		}
		return fx_url(array(
			'link'	=> $link,
			'query'	=> $query
		));
	}

	function fx_make_external_url(array $link, $query=array(), $merge_query=true){
		$config = Config::getInstance();
		$url_prefix = "{$config->core['site_scheme']}://{$config->core['site_host']}";
		return $url_prefix . fx_make_url($link, $query,$merge_query);
	}

	//	fx_get_external_link(
	//		array('users','item',1),
	//		array('id'=>$u_first_name),
	//		$u_full_name,
	//		array('id'=>$u_last_name)
	//	)
	function fx_get_link(array $link, $query=array(), $value, array $attributes, $merge_query=true){
		$default_attributes = array(
			'accesskey'	=> '',
			'coords'	=> '',
			'download'	=> '',
			'href'		=> 'javascript:void(0)',
			'hreflang'	=> '',
			'name'		=> '',
			'rel'		=> '',
			'rev'		=> '',
			'shape'		=> '',
			'tabindex'	=> '',
			'target'	=> '',
			'title'		=> '',
			'type'		=> 'text/html',
			'id'		=> 'link',
			'class'		=> 'link',
			'onclick'	=> '',
		);
		$attributes = array_merge($default_attributes,$attributes);
		$attributes = array_diff($attributes,array(''));
		$attributes['href'] = fx_make_url($link, $query,$merge_query);
		$result_link = '<a';
		foreach($attributes as $link_key=>$link_value){
			$result_link .= " {$link_key}=\"{$link_value}\"";
		}
		$result_link .= ">{$value}</a>";
		return $result_link;
	}

	function fx_get_external_link(array $link, $query=array(), $value, array $attributes, $merge_query=true){
		$default_attributes = array(
			'accesskey'	=> '',
			'coords'	=> '',
			'download'	=> '',
			'href'		=> 'javascript:void(0)',
			'hreflang'	=> '',
			'name'		=> '',
			'rel'		=> '',
			'rev'		=> '',
			'shape'		=> '',
			'tabindex'	=> '',
			'target'	=> '',
			'title'		=> '',
			'type'		=> 'text/html',
			'id'		=> 'link',
			'class'		=> 'link',
			'onclick'	=> '',
		);
		$attributes = array_merge($default_attributes,$attributes);
		$attributes = array_diff($attributes,array(''));
		$attributes['href'] = fx_make_external_url($link, $query,$merge_query);
		$result_link = '<a';
		foreach($attributes as $link_key=>$link_value){
			$result_link .= " {$link_key}=\"{$link_value}\"";
		}
		$result_link .= ">{$value}</a>";
		return $result_link;
	}






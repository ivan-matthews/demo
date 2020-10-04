<?php

	use Core\Classes\Router;
	use Core\Classes\Config;
	use Core\Classes\Kernel;

	if(!function_exists('fx_get_web_dir_name')){
		function fx_get_web_dir_name(){
			return trim(dirname(fx_get_server('PHP_SELF')),DIRECTORY_SEPARATOR);
		}
	}
	if(!function_exists('fx_get_preparing_url')){
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
	}
	if(!function_exists('fx_get_url')){
		function fx_get_url(...$link_args){
			$url = fx_get_preparing_url(...$link_args);
			return "/{$url}";
		}
	}
	if(!function_exists('fx_url')){
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
	}
	if(!function_exists('fx_make_url')){
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
	}
	if(!function_exists('fx_make_external_url')){
		function fx_make_external_url(array $link, $query=array(), $merge_query=true){
			$config = Config::getInstance();
			$url_prefix = "{$config->core['site_scheme']}://{$config->core['site_host']}";
			return $url_prefix . fx_make_url($link, $query,$merge_query);
		}
	}
	if(!function_exists('fx_get_link')){
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
	}
	if(!function_exists('fx_get_external_link')){
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
	}
	if(!function_exists('fx_crop_string')){
		function fx_crop_string($string,$length=200,$with_points="..."){
			$string = strip_tags($string);
			if(mb_strlen($string) > $length){
				return mb_substr($string,0,$length) . $with_points;
			}
			return $string;
		}
	}
	if(!function_exists('fx_crop_file_name')){
		function fx_crop_file_name($file_name,$length=200,$with_points="..."){
			$file_info = pathinfo($file_name);
			if(!isset($file_info['extension'])){
				if(isset($file_info['filename'])){
					return fx_crop_string($file_info['filename'],$length,$with_points);
				}
				return fx_crop_string($file_name,$length,$with_points);
			}
			$file_short_name = fx_crop_string($file_info['filename'],$length,$with_points);
			return "{$file_short_name}.{$file_info['extension']}";
		}
	}
	if(!function_exists('fx_replace_to_space')){
		function fx_replace_to_space($string,array $replace_data){
			return str_replace($replace_data,' ',$string);
		}
	}
	if(!function_exists('fx_get_file_icon')){
		function fx_get_file_icon($file_name){
			$files_icons = Config::getInstance()->view['files_icons'];
			$file_extension = pathinfo($file_name,PATHINFO_EXTENSION);
			if(isset($files_icons[$file_extension])){
				return "<i class=\"{$files_icons[$file_extension]}\"></i>";
			}
			return "<i class=\"{$files_icons['default']}\"></i>";
		}
	}
	if(!function_exists('fx_get_public_path')){
		function fx_get_public_path($file_path, $with_trailing_slash = true){
			$file_path = trim($file_path,'/');
			$public_dir = fx_get_web_dir_name();
			$theme_dir = Config::getInstance()->view['site_theme'];
			$public_dir = $with_trailing_slash ? "/{$public_dir}" : $public_dir;
			return "{$public_dir}/view/{$theme_dir}/{$file_path}";
		}
	}
	if(!function_exists('fx_get_public_root_path')){
		function fx_get_public_root_path($file_path){
			return fx_path(fx_get_public_path($file_path, null));
		}
	}
	if(!function_exists('fx_get_upload_path')){
		function fx_get_upload_path($file_path, $with_trailing_slash = true){
			if(parse_url($file_path,PHP_URL_SCHEME)){
				return $file_path;
			}
			$file_path = trim($file_path,'/');
			$public_dir = fx_get_web_dir_name();
			$upload_dir = Config::getInstance()->view['uploads_dir'];
			$public_dir = $with_trailing_slash ? "/{$public_dir}" : $public_dir;
			return "{$public_dir}/{$upload_dir}/{$file_path}";
		}
	}
	if(!function_exists('fx_get_upload_root_path')){
		function fx_get_upload_root_path($file_path){
			if(parse_url($file_path,PHP_URL_SCHEME)){
				return $file_path;
			}
			return fx_path(fx_get_upload_path($file_path, null));
		}
	}
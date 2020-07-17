<?php

	function fx_prepare_memory($memory,$format=2){
		if($memory<1024){
			$memory = number_format($memory,$format);
			return "{$memory} b";
		}
		if($memory<1048576){
			$memory = number_format($memory/1024,$format);
			return "{$memory} kb";
		}
		if($memory<1073741824){
			$memory = number_format($memory/1048576,$format);
			return "{$memory} mb";
		}
		if($memory<1099511627776){
			$memory = number_format($memory/1073741824,$format);
			return "{$memory} gb";
		}
		if($memory<1125899906842624){
			$memory = number_format($memory/1099511627776,$format);
			return "{$memory} tb";
		}
		$memory = number_format($memory/1125899906842624,$format);
		return "{$memory} pb";
	}

	function fx_get_files_callback($dir,callable $callback){
		if(is_dir($dir) && is_readable($dir)){
			foreach(scandir($dir) as $file){
				if($file == '.' || $file == '..' || is_dir("{$dir}/{$file}")){ continue; }
				if(!fx_get_files_callback("{$dir}/{$file}",$callback)){
					call_user_func($callback,"{$dir}/{$file}");
				}
			}
		}
		return false;
	}

	function fx_load_array($helpers_dir){
		$dir_path = fx_path($helpers_dir);
		$final_result = array();
		foreach(scandir($dir_path) as $file){
			if($file == '.' || $file == '..' || is_dir("{$dir_path}/{$file}")){ continue; }
			$array_key = pathinfo($file,PATHINFO_FILENAME);
			$final_result[$array_key] = include_once "{$dir_path}/{$file}";
		}
		return $final_result;
	}

	function fx_save($file,$data){
		$file_path = fx_path($file);
		$directory = dirname($file);
		fx_make_dir($directory);
		return file_put_contents($file_path,$data);
	}

	function fx_make_dir($dir,$chmod=0775,$recursive=true){
		$mkdir = false;
		if(!is_dir($dir)){
			$mkdir = mkdir($dir,$chmod,$recursive);
		}
		return $mkdir;
	}

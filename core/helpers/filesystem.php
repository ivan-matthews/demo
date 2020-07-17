<?php

	function fx_prepare_memory($memory,$decimals=2,$dec_point=',',$thousands_sep=''){
		$memory = abs($memory);
		switch($memory){
			case ($memory<1024):
				$memory = number_format($memory/1,$decimals,$dec_point,$thousands_sep);
				return "{$memory} b";
			case ($memory<1048576):
				$memory = number_format($memory/1024,$decimals,$dec_point,$thousands_sep);
				return "{$memory} kb";
			case ($memory<1073741824):
				$memory = number_format($memory/1048576,$decimals,$dec_point,$thousands_sep);
				return "{$memory} mb";
			case ($memory<1099511627776):
				$memory = number_format($memory/1073741824,$decimals,$dec_point,$thousands_sep);
				return "{$memory} gb";
			case ($memory<1125899906842624):
				$memory = number_format($memory/1099511627776,$decimals,$dec_point,$thousands_sep);
				return "{$memory} tb";
			default:
				$memory = number_format($memory/1125899906842624,$decimals,$dec_point,$thousands_sep);
				return "{$memory} pb";
		}
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

	function fx_load_array($helpers_dir,$import_type=2){
		$final_result = array();
		foreach(scandir($helpers_dir) as $file){
			if($file == '.' || $file == '..' || is_dir("{$helpers_dir}/{$file}")){ continue; }
			$array_key = pathinfo($file,PATHINFO_FILENAME);
			$final_result[$array_key] = fx_import_file("{$helpers_dir}/{$file}",$import_type);
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

	function fx_scandir_callback($directory_path,callable $callback){
		if(is_dir($directory_path) && is_readable($directory_path)){
			foreach(scandir($directory_path) as $file_or_folder){
				if($file_or_folder == '.' || $file_or_folder == '..'){ continue; }
				if(!fx_scandir_callback("{$directory_path}/{$file_or_folder}",$callback)){
					call_user_func($callback,"{$directory_path}/{$file_or_folder}");
				}
			}
		}
		return false;
	}

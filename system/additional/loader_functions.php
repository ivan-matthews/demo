<?php

	function fx_classes_loader($class){
		$class_name = str_replace("\\",DIRECTORY_SEPARATOR,$class);
		$class_name_lower = mb_strtolower($class_name);
		$class_file = fx_php_path($class_name_lower);
		if(is_readable($class_file)){
			return include $class_file;
		}
		return false;
	}

	function fx_load_helpers($helpers_dir="core/helpers"){
		$dir_path = fx_path($helpers_dir);
		foreach(scandir($dir_path) as $file){
			if($file == '.' || $file == '..' || is_dir("{$dir_path}/{$file}")){ continue; }
			include_once "{$dir_path}/{$file}";
		}
		return true;
	}

	function fx_load_helper($helper_file){
		$file_path = fx_php_path($helper_file);
		if(is_readable($file_path)){
			return include_once $file_path;
		}
		return false;
	}

	function fx_path($file){
		$absolute_path = ROOT . "/{$file}";
		return $absolute_path;
	}

	function fx_php_path($file){
		$abs_path = fx_path($file);
		$abs_path = "{$abs_path}.php";
		return $abs_path;
	}

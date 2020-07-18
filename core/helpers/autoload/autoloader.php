<?php

	class autoLoader{

		/** @var array */
		private static $aliases_list;

		public static function getAliasesLis(){
			if(self::$aliases_list === null){
				self::$aliases_list = fx_load_helper('system/assets/classes_aliases');
			}
			return self::$aliases_list;
		}

		public static function autoload($class){
			if(!self::searchClassInAliasesList($class)){
				if(!self::parseClassName($class)){
					return true;
				}
			}
			return false;
		}

		private static function parseClassName($class){
			$class_name = str_replace("\\",DIRECTORY_SEPARATOR,$class);
			$class_name = strtolower($class_name);
			return fx_load_helper($class_name);
		}

		private static function searchClassInAliasesList($class){
			$aliases_lib = self::getAliasesLis();
			if(isset($aliases_lib[$class])){
				 return fx_load_helper($aliases_lib[$class]);
			}
			return null;
		}

	}

	function fx_load_helpers($helpers_dir="core/helpers", $import_type=3){
		$dir_path = fx_path($helpers_dir);
		foreach(scandir($dir_path) as $file){
			if($file == '.' || $file == '..' || is_dir("{$dir_path}/{$file}")){ continue; }
			fx_import_file("{$dir_path}/{$file}",$import_type);
		}
		return true;
	}

	function fx_load_helper($helper_file, $import_type=3){
		$file_path = fx_php_path($helper_file);
		if(is_readable($file_path)){
			return fx_import_file($file_path,$import_type);
		}
		return false;
	}

	function fx_import_file($file_path,$import_type=3){
		switch($import_type){
			case 0:
				return require $file_path;
				break;
			case 1:
				return require_once $file_path;
				break;
			case 2:
				return include $file_path;
				break;
			case 3:
				return include_once $file_path;
				break;
			default:
				return null;
		}
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

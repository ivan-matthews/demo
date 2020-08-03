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
		$file = fx_path($file);
		fx_make_dir(dirname($file),777);
		return file_put_contents($file,$data);
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

	/**
	 * Ресайз изображения до нужных пропорций
	 *
	 *
	 * @param $file_name
	 * @param $image_type
	 * @param int $input_width
	 * @param int $input_height
	 * @return bool
	 */
	function fx_resize_image($file_name, $image_type, $input_width = 240, $input_height = 0){

		$create_function = "imagecreatefrom{$image_type}";
		$exit_function = "image{$image_type}";
		if(!is_callable($create_function) || !is_callable($exit_function)){ return false; }

		list($orig_width, $orig_height) = getimagesize($file_name);

		$height = $input_height ? $input_height : $input_width / ($orig_width / $orig_height);
		$width = $input_width ? $input_width : $input_height / ($orig_height / $orig_width);

		$image_p = imagecreatetruecolor($width, $height);

		imagesavealpha($image_p , true);
		$background_color = imagecolorallocatealpha($image_p , 0, 0, 0, 127);
		imagefill($image_p , 0, 0, $background_color);

		$image = $create_function($file_name);

		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

		$result_image = $exit_function($image_p,$file_name);
		imagedestroy($image_p);
		return $result_image;
	}

	/**
	 * Первичная обрезка оригинального изображения
	 * для ресайза вызвать fx_resize_image()
	 * или
	 * для последующих операций с изображением
	 * вызвать fx_crop_and_resize_image()
	 * пример: Core\Controllers\Avatar\Controller -> saveAndPrepareImage()
	 *
	 * @param $file_name
	 * @param $image_type
	 * @param int $input_width
	 * @param int $input_height
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	function fx_crop_image($file_name, $image_type, $input_width = 240, $input_height = 0,$x=0,$y=0){

		$create_function = "imagecreatefrom{$image_type}";
		$exit_function = "image{$image_type}";
		if(!is_callable($create_function) || !is_callable($exit_function)){ return false; }

		list($orig_width, $orig_height) = getimagesize($file_name);

		if(is_null($x)){
			if($orig_width > $input_width){
				$x = ($orig_width - $input_width) / 2;
			}else{
				$x = 0;
				$input_width = $orig_width;
			}
		}
		if(is_null($y)){
			if($orig_height > $input_height){
				$y = ($orig_height - $input_height) / 2;
			}else{
				$y = 0;
				$input_height = $orig_height;
			}
		}

		$image = $create_function($file_name);

		$image_p = imagecrop($image, array(
			'x' => $x, 'y' => $y, 'width' => $input_width, 'height' => $input_height
		));

		imagesavealpha($image_p , true);
		$background_color = imagecolorallocatealpha($image_p , 0, 0, 0, 127);
		imagefill($image_p , 0, 0, $background_color);

		$result_image = $exit_function($image_p,$file_name);
		imagedestroy($image_p);
		return $result_image;
	}

	/**
	 * Обрезка и ресайз изображения
	 *
	 * @param $file_name
	 * @param $image_type
	 * @param int $resize_width
	 * @param int $resize_height
	 * @param int $crop_width
	 * @param int $crop_height
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	function fx_crop_and_resize_image($file_name, $image_type, $resize_width = 240, $resize_height = 0, $crop_width = 240, $crop_height = 0, $x=0, $y=0){

		$create_function = "imagecreatefrom{$image_type}";
		$exit_function = "image{$image_type}";
		if(!is_callable($create_function) || !is_callable($exit_function)){ return false; }

		list($orig_width, $orig_height) = getimagesize($file_name);

		$height = $resize_height ? $resize_height : $resize_width / ($orig_width / $orig_height);
		$width = $resize_width ? $resize_width : $resize_height / ($orig_height / $orig_width);

		$image_p = imagecreatetruecolor($width, $height);

		$image_p = imagecrop($image_p, array(
			'x' => $x, 'y' => $y, 'width' => $crop_width, 'height' => $crop_height
		));

		imagesavealpha($image_p , true);
		$background_color = imagecolorallocatealpha($image_p , 0, 0, 0, 127);
		imagefill($image_p , 0, 0, $background_color);

		$image = $create_function($file_name);

		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

		$result_image = $exit_function($image_p,$file_name);
		imagedestroy($image_p);
		return $result_image;
	}

















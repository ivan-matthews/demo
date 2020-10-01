<?php

	namespace Core\Controllers\Photos\Helpers;

	class Crop{

		private static $instance;

		private $crop=array();

		public $image_quality = 50;
		public $image_file;
		public $output_file;
		public $image_resource;

		public $image_info = array(
			'name'		=> null,
			'type'		=> null,
			'size'		=> null,
			'tmp_name'	=> null,
			'error'		=> null,
		);
		public $image_options = array();
		public $image_extension;

		public $name;
		public $type;
		public $size;
		public $tmp_name;
		public $error;

		public $image_function;
		public $exit_function;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->crop[$key])){
				return $this->crop[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->crop[$name] = $value;
			return $this->crop[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}

		public function setQuality($image_quality){
			$this->image_quality = $image_quality;
			return $this;
		}

		public function setImageInfo(array $image_info){
			$this->image_info = $image_info;
			return $this->setPropsFromImageParams();
		}

		public function setImageOptions(array $image_options){
			$this->image_options = $image_options;
			return $this;
		}

		protected function setPropsFromImageParams(){
			$this->name = isset($this->image_info['name']) ? $this->image_info['name'] : null;
			$this->type = isset($this->image_info['type']) ? $this->image_info['type'] : null;
			$this->size = isset($this->image_info['size']) ? $this->image_info['size'] : null;
			$this->tmp_name = isset($this->image_info['tmp_name']) ? $this->image_info['tmp_name'] : null;
			$this->error = isset($this->image_info['error']) ? $this->image_info['error'] : null;
			return $this;
		}

		public function setImageFile($image_file){
			$this->image_file = $image_file;
			return $this->setOutputFile($image_file);
		}

		public function setOutputFile($image_file){
			$this->output_file = $image_file;
			return $this;
		}

		public function setImageResource($image_resource){
			$this->image_resource = $image_resource;
			return $this;
		}

		public function setImageExtension($extension){
			$this->image_extension = $extension;
			return $this->setImageFunction();
		}

		public function setImageFunction(){
			$this->image_function = "imagecreatefrom{$this->image_extension}";
			$this->exit_function = "image{$this->image_extension}";
			return $this;
		}

		public function resize(){
			if(fx_equal($this->image_options['width'],$this->image_options['height'])){
				return $this->resizeAsQuad();
			}
			return $this->resizeAsPortrait();
		}

		public function resizeAsQuad(){
			$image_src = call_user_func($this->image_function,$this->image_file);
			$width_image_src = imagesx($image_src);
			$height_image_src = imagesy($image_src);

			$image_resource = imagecreatetruecolor($this->image_options['width'],$this->image_options['height']);

			if($width_image_src > $height_image_src){
				imagecopyresized($image_resource, $image_src, 0, 0,
					round((max($width_image_src,$height_image_src)-min($width_image_src,$height_image_src))/2),
					0, $this->image_options['width'], $this->image_options['width'], min($width_image_src,$height_image_src), min($width_image_src,$height_image_src));
			}

			if($width_image_src < $height_image_src){
				imagecopyresized($image_resource, $image_src, 0, 0, 0, 0, $this->image_options['width'], $this->image_options['width'],
					min($width_image_src,$height_image_src), min($width_image_src,$height_image_src));
			}

			if(fx_equal($width_image_src,$height_image_src)){
				imagecopyresized($image_resource, $image_src, 0, 0, 0, 0, $this->image_options['width'], $this->image_options['width'], $width_image_src, $width_image_src);
			}

			call_user_func($this->exit_function,$image_resource,$this->output_file,$this->image_quality);
			imagedestroy($image_resource);
			imagedestroy($image_src);
			return $this;
		}

		public function resizeAsPortrait(){
			$image_src = call_user_func($this->image_function,$this->image_file);
			$width_image_src = imagesx($image_src);
			$height_image_src = imagesy($image_src);

			$ratio = $width_image_src/$this->image_options['width'];
			$image_resource_width = round($width_image_src/$ratio);
			$image_resource_height = round($height_image_src/$ratio);

			if($image_resource_height < $this->image_options['height']){
				$difference = $this->image_options['height'] - $image_resource_height;
				$coordinate_x = round($width_image_src/$height_image_src)*100;

				$image_resource = imagecreatetruecolor($image_resource_width,$image_resource_height+$difference);
				imagecopyresampled($image_resource, $image_src, 0, 0, $coordinate_x, 0,
					$image_resource_width+$difference, $image_resource_height+$difference, $width_image_src-$difference, $height_image_src);
			}else{
				$image_resource = imagecreatetruecolor($image_resource_width,$image_resource_height);
				imagecopyresampled($image_resource, $image_src, 0, 0, 0, 0,
					$image_resource_width, $image_resource_height, $width_image_src, $height_image_src);
			}
			call_user_func($this->exit_function,$image_resource,$this->output_file,$this->image_quality);
			imagedestroy($image_resource);
			imagedestroy($image_src);
			return $this;
		}

		public function resizeAsPortraitOriginalHeight(){
			$image_src = call_user_func($this->image_function,$this->image_file);
			$width_image_src = imagesx($image_src);
			$height_image_src = imagesy($image_src);

			$ratio = $width_image_src/$this->image_options['width'];
			$image_resource_width = round($width_image_src/$ratio);
			$image_resource_height = round($height_image_src/$ratio);

			if($image_resource_height < $this->image_options['height']){
				$image_resource = imagecreatetruecolor($image_resource_width,$image_resource_height);
				imagecopyresampled($image_resource, $image_src, 0, 0,0, 0,
					$image_resource_width, $image_resource_height, $width_image_src, $height_image_src);
			}else{
				$image_resource = imagecreatetruecolor($image_resource_width,$image_resource_height);
				imagecopyresampled($image_resource, $image_src, 0, 0, 0, 0,
					$image_resource_width, $image_resource_height, $width_image_src, $height_image_src);
			}

			call_user_func($this->exit_function,$image_resource,$this->output_file,$this->image_quality);
			imagedestroy($image_resource);
			imagedestroy($image_src);
			return $this;
		}

		public function crop(){}
		public function cropAsQuad(){}
		public function cropAsPortrait(){}

		public function cropWithCoordinate($coordinate_x=0,$coordinate_y=0){
			list($orig_width, $orig_height) = getimagesize($this->image_file);

			if(is_null($coordinate_x)){
				if($orig_width > $this->image_options['width']){
					$coordinate_x = ($orig_width - $this->image_options['width']) / 2;
				}else{
					$coordinate_x = 0;
					$this->image_options['width'] = $orig_width;
				}
			}
			if(is_null($coordinate_y)){
				if($orig_height > $this->image_options['height']){
					$coordinate_y = ($orig_height - $this->image_options['height']) / 2;
				}else{
					$coordinate_y = 0;
					$this->image_options['height'] = $orig_height;
				}
			}

			$image = call_user_func($this->image_function,$this->image_file);

			$image_resource = imagecrop($image, array(
				'x' => $coordinate_x, 'y' => $coordinate_y, 'width' => $this->image_options['width'], 'height' => $this->image_options['height']
			));

			$result_image = call_user_func($this->exit_function,$image_resource,$this->output_file,$this->image_quality);
			imagedestroy($image_resource);
			return $result_image;
		}

















	}















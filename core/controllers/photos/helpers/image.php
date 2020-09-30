<?php

	namespace Core\Controllers\Photos\Helpers;

	use Core\Classes\Kernel;

	class Image{

		protected static $instance;

		protected $image=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->image[$key])){
				return $this->image[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->image[$name] = $value;
			return $this->image[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}

		public $user_id;
		public $image_info = array(
			'name'	=> null,
			'type'	=> null,
			'size'	=> null,
			'tmp_name'	=> null,
			'error'	=> null,
		);
		public $image_options = array();
		public $folder = 'photos';
		public $sub_folder;
		public $tmp_file;
		public $images_path;
		public $image_hash;
		public $image_extension;
		public $insert_data = array();

		public $name;
		public $type;
		public $size;
		public $tmp_name;
		public $error;

		public $images_root_path;

		public function setUserId($user_id){
			$this->user_id = $user_id;
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

		public function ready(){
			$this->getImageHash();
			$this->getImagesSubFolder();
			$this->getImagesPath();
			$this->getImageExtension();

			$this->makeUploadsDirectory();
			$this->copyOriginalToTmp();
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

		protected function getImageHash(){
			$this->image_hash = md5_file($this->tmp_name);
			return $this;
		}

		protected function getImagesSubFolder(){
			$image_directory_suffix = mb_substr($this->image_hash,0,4);
			$first_folder = mb_substr($image_directory_suffix,0,2);
			$second_folder = mb_substr($image_directory_suffix,2,4);
			$this->sub_folder = "{$first_folder}/{$second_folder}";
			return $this;
		}

		protected function getImagesPath(){
			$this->images_path = "users/{$this->user_id}/{$this->folder}/{$this->sub_folder}";
			return $this;
		}

		protected function getImageExtension(){
			$mime_type_array = explode('/',$this->type);
			$this->image_extension = $mime_type_array[1];
			return $this;
		}

		public function getInsertData(){
			$this->insert_data['p_user_id']		= $this->user_id;
			$this->insert_data['p_name']		= $this->name;
			$this->insert_data['p_size']		= $this->size;
			$this->insert_data['p_hash']		= "{$this->user_id}-{$this->image_hash}";
			$this->insert_data['p_mime']		= $this->type;
			$this->insert_data['p_status']		= Kernel::STATUS_ACTIVE;
			$this->insert_data['p_date_created']= time();

			$this->unlinkCurrentImage();
			return $this->insert_data;
		}

		public function setOriginalImage(){
			$this->insert_data["p_original"] = "{$this->images_path}/original-{$this->image_hash}.{$this->image_extension}";
			return $this;
		}

		protected function copyOriginalToTmp(){
			copy($this->tmp_name, "{$this->images_root_path}/original-{$this->image_hash}.{$this->image_extension}");
			$this->tmp_file = "{$this->images_root_path}/{$this->name}-tmp";
			copy($this->tmp_name, $this->tmp_file);
			return $this;
		}

		public function cropOriginalImage($coordinate_x=null, $coordinate_y=null, callable $callback_function = null){
			$crop = new Crop();
			$crop->setImageInfo($this->image_info);
			$crop->setImageOptions($this->image_options['normal']);
			$crop->setImageFile($this->tmp_file);
			$crop->setImageExtension($this->image_extension);

			if(is_callable($callback_function)){
				call_user_func($callback_function,$crop);
			}else{
				$crop->cropWithCoordinate($coordinate_x,$coordinate_y);
			}
			return $this;
		}

		public function cropAnotherImages(callable $callback_function = null){
			foreach($this->image_options as $key => $option){
				$path_to_save = "{$this->images_root_path}/{$key}-{$this->image_hash}.{$this->image_extension}";

				$crop = new Crop();
				$crop->setImageInfo($this->image_info);
				$crop->setImageOptions($this->image_options[$key]);
				$crop->setImageFile($this->tmp_file);
				$crop->setOutputFile($path_to_save);
				$crop->setImageExtension($this->image_extension);

				if(is_callable($callback_function)){
					call_user_func($callback_function,$crop);
				}else{
					$crop->resize();
				}
				$this->insert_data["p_{$key}"] = "{$this->images_path}/{$key}-{$this->image_hash}.{$this->image_extension}";
			}
			return $this;
		}

		protected function makeUploadsDirectory(){
			$this->images_root_path = fx_get_upload_root_path($this->images_path);
			fx_make_dir($this->images_root_path);
			return $this;
		}

		protected function unlinkCurrentImage(){
			unlink($this->tmp_file);
			return $this;
		}














	}















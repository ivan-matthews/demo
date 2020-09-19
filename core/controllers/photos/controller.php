<?php

	namespace Core\Controllers\Photos;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;

	class Controller extends ParentController{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var \Core\Classes\Model|Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var array */
		private $photos;

		private $options;

		private $image_params;			// params array
		private $image_extension;		// explode image extension
		private $image_folder;			// image folder path without public/[template_name]
		private $image_directory;		// root path to image folder
		private $image_hash;			// unique md5 image file hash
		private $image_original_name;	// name file for original image
		private $image_sub_folder;		// image sub folder (date(Y), example)
		private $image_x_coordinate;	// crop X coordinate
		private $image_y_coordinate;	// crop Y coordinate
		private $image_insert_data;		// insert to DB data array
		private $image_user_id;			// current user ID
		private $image_file_name;		// dynamic file name created from params array in foreach
		private $image_path_to_save;	// dynamic save path created from params array in foreach
		private $image_temporary_file;	// copied temporary file

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->photos[$key])){
				return $this->photos[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->photos[$name] = $value;
			return $this->photos[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Photos\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Photos\Model as Model;
		}

		public function __destruct(){

		}

		public function cropAndResizeImage($attributes,$user_id,$images_dir_path='photos',$coordinate_x=null,$coordinate_y=null,$crop_tmp_image = true, $custom_directory = null){
			$this->image_params = $attributes;
			$this->image_sub_folder = $images_dir_path;
			$this->image_x_coordinate = $coordinate_x;
			$this->image_y_coordinate = $coordinate_y;
			$this->image_user_id = $user_id;

			$this->getImageHash();

			$this->getExtension();
			$this->setImageFolder($custom_directory);
			$this->setImageDirectory();
			$this->setOriginalImageName();
			$this->copyOriginalImage();
			$this->setImageInsertDataArray();

			if($crop_tmp_image){
				$this->cropOriginalImage();
			}

			$this->setAnotherImages();
			$this->unlinkCurrentImage();

			return $this->image_insert_data;
		}

		public function getImageHash(){
//			хеш картинки

			$md5_file_hash = md5_file($this->image_params['tmp_name']);
			$image_directory_suffix = mb_substr($md5_file_hash,0,4);
			$first_folder = mb_substr($image_directory_suffix,0,2);
			$second_folder = mb_substr($image_directory_suffix,2,4);

			$this->image_sub_folder = "{$this->image_sub_folder}/{$first_folder}/{$second_folder}";

			$this->image_hash = $this->image_user_id . '-' . $md5_file_hash;
			return $this;
		}
		public function setOptions(array $options){
			$this->options = $options;
			return $this;
		}

		public function getExtension(){
//			получить расширение файла
//			$this->image_extension = pathinfo($this->image_params['name'],PATHINFO_EXTENSION);
			$this->image_extension = explode('/',$this->image_params['type'])[1];
			return $this;
		}
		public function setImageFolder($custom_directory){
//			установить путь для сохранения картинки
			if(!$custom_directory){
				$this->image_folder = "users/{$this->image_user_id}/{$this->image_sub_folder}";
			}else{
				$this->image_folder = $custom_directory;
			}
			return $this;
		}
		public function setImageDirectory(){
//			установить путь для сохранения картинки относительно корня ФС
			$this->image_directory = fx_get_upload_root_path($this->image_folder);
			return $this;
		}
		public function setOriginalImageName(){
//			оригинал не редактируем!
			$this->image_original_name = "original-{$this->image_hash}.{$this->image_extension}";
			return $this;
		}
		public function copyOriginalImage(){
//			создать папку, если не существует
			fx_make_dir($this->image_directory);
//			создать временный файл ->
			$this->image_temporary_file = "{$this->image_directory}/{$this->image_original_name}-tmp";
//			-> сохранить временный файл и вдальнейшем работать с ним
			copy($this->image_params['tmp_name'], $this->image_temporary_file);
//			скопировать оригинал в папку, где будут расположены другие картинки
			copy($this->image_params['tmp_name'], "{$this->image_directory}/{$this->image_original_name}");
			return $this;
		}
		public function setImageInsertDataArray(){
//			массив для инзерта в БД
			$this->image_insert_data = array(
				'p_user_id'			=> $this->image_user_id,
				'p_name'			=> $this->image_params['name'],
				'p_size'			=> $this->image_params['size'],
				'p_hash'			=> $this->image_hash,
				'p_mime'			=> $this->image_params['type'],
				'p_status'			=> Kernel::STATUS_ACTIVE,
				'p_date_created'	=> time(),
				'p_original'		=> "{$this->image_folder}/{$this->image_original_name}",
			);
			return $this;
		}

		public function cropOriginalImage(){
//			обрезать картинку по параметрам ключа `NORMAL` как дефолтного значения
			fx_crop_image($this->image_temporary_file,
				$this->image_extension, $this->options['normal']['width'],
				$this->options['normal']['height'],$this->image_x_coordinate,$this->image_y_coordinate);

			return $this;
		}
		public function setAnotherImages(){
//			перебрать остальные ключи для обрезки картинки по установленным параметрам
			foreach($this->options as $key=>$value){
//				имя файла
				$this->image_file_name = "{$key}-{$this->image_hash}.{$this->image_extension}";
//				путь для сохранения
				$this->image_path_to_save = "{$this->image_directory}/{$this->image_file_name}";
//				скопировать картинку в папку с картинками
				copy($this->image_temporary_file,$this->image_path_to_save);
//				заполнить поле ключа картинки для БД
				$this->image_insert_data["p_{$key}"] = "{$this->image_folder}/{$this->image_file_name}";
//				параметр `resize_height` установлен в "0", чтоб не плющило изображения по высоте
				fx_crop_and_resize_image(
					$this->image_path_to_save, $this->image_extension, $value['width'],
					0, $value['width'], $value['height']
				);
			}
			return $this;
		}
		public function unlinkCurrentImage(){
			unlink($this->image_temporary_file);
			return $this;
		}

		public function setResponse(){
			$this->response->title('photos.photos_index_title');
			$this->response->breadcrumb('index')
				->setIcon(null)
				->setLink('photos','index')
				->setValue('photos.photos_index_title');

			return $this;
		}

















	}















<?php

	namespace Core\Controllers\Avatar;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Classes\Kernel;
	use Core\Classes\View;
	use Core\Classes\Session;

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
		private $avatar;

		/** @var View */
		public $view;

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

		public function __construct(){
			parent::__construct();

			$this->view = View::getInstance();
			$this->params = Config::getInstance();	// use Core\Controllers\Avatar\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Avatar\Model as Model;
		}

		public function __destruct(){

		}

		public function cropAndResizeImage($attributes,$user_id,$images_dir_path='photos',$coordinate_x=null,$coordinate_y=null){
			$this->image_params = $attributes;
			$this->image_sub_folder = $images_dir_path;
			$this->image_x_coordinate = $coordinate_x;
			$this->image_y_coordinate = $coordinate_y;
			$this->image_user_id = $user_id;

			$this->getExtension();
			$this->setImageFolder();
			$this->setImageDirectory();
			$this->getImageHash();
			$this->setOriginalImageName();
			$this->copyOriginalImage();
			$this->setImageInsertDataArray();
			$this->cropOriginalImage();
			$this->setAnotherImages();
			$this->unlinkCurrentImage();

			return $this->image_insert_data;
		}

		public function getExtension(){
//			получить расширение файла
			$this->image_extension = explode('/',$this->image_params['type'])[1];
			return $this;
		}
		public function setImageFolder(){
//			установить путь для сохранения картинки
			$this->image_folder = "users/{$this->image_user_id}/{$this->image_sub_folder}";
			return $this;
		}
		public function setImageDirectory(){
//			установить путь для сохранения картинки относительно корня ФС
			$this->image_directory = $this->view->getUploadDir($this->image_folder);
//			создать папку, если не существует
			fx_make_dir($this->image_directory);
			return $this;
		}
		public function getImageHash(){
//			хеш картинки
			$this->image_hash = $this->image_user_id . '-' . md5_file($this->image_params['tmp_name']);
			return $this;
		}
		public function setOriginalImageName(){
//			оригинал не редактируем!
			$this->image_original_name = "original-{$this->image_hash}.{$this->image_extension}";
			return $this;
		}
		public function copyOriginalImage(){
			$this->image_temporary_file = "{$this->image_directory}/{$this->image_original_name}-tmp";
//			скопировать оригинал в папку, где будут расположены другие картинки
			copy($this->image_params['tmp_name'], "{$this->image_directory}/{$this->image_original_name}");
			copy($this->image_params['tmp_name'], $this->image_temporary_file);
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
				$this->image_extension, $this->params->image_params['normal']['width'],
				$this->params->image_params['normal']['height'],$this->image_x_coordinate,$this->image_y_coordinate);

			return $this;
		}
		public function setAnotherImages(){
//			перебрать остальные ключи для обрезки картинки по установленным параметрам
			foreach($this->params->image_params as $key=>$value){
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


		public function sessionUpdate(){
			$this->insert_data['p_date_updated'] = time();
			foreach($this->insert_data as $key=>$value){
				$this->session->set($key,$value,Session::PREFIX_AUTH);
			}
			return $this;
		}
















	}















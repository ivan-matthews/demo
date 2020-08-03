<?php

	namespace Core\Controllers\Avatar;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Classes\Kernel;
	use Core\Classes\View;

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

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->avatar[$key])){
				return $this->avatar[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->avatar[$name] = $value;
			return $this->avatar[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->view = View::getInstance();
			$this->params = Config::getInstance();	// use Core\Controllers\Avatar\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Avatar\Model as Model;
		}

		public function __destruct(){

		}

		public function saveAndPrepareImage($attributes,$user_id){
//			получить расширение файла
			$extension = explode('/',$attributes['type'])[1];
//			установить путь для сохранения картинки
			$user_files_path = "users/{$user_id}/avatars";

//			получить пареметры обрезки изображения
			$image_params = $this->request->getAll();
			$x = isset($image_params['x'][0]) ? $image_params['x'][0] : 0;
			$y = isset($image_params['y'][0]) ? $image_params['y'][0] : 0;

//			установить путь для сохранения картинки относительно корня ФС
			$path_to_save = $this->view->getUploadDir($user_files_path);

//			создать папку, если не существует
			fx_make_dir($path_to_save);

//			хеш картинки
			$image_hash = $user_id . '-' . md5_file($attributes['tmp_name']);

//			оригинал не редактируем!
			$original_file_name = "original-{$image_hash}.{$extension}";
//			скопировать оригинал в папку, где будут расположены другие картинки
			copy($attributes['tmp_name'], "{$path_to_save}/{$original_file_name}");

//			массив для инзерта в БД
			$insert_data = array(
				'p_user_id'			=> $user_id,
				'p_name'			=> $attributes['name'],
				'p_size'			=> $attributes['size'],
				'p_hash'			=> $image_hash,
				'p_mime'			=> $attributes['type'],
				'p_status'			=> Kernel::STATUS_ACTIVE,
				'p_date_created'	=> time(),
				'p_original'		=> "{$user_files_path}/{$original_file_name}",
			);

//			обрезать картинку по параметрам ключа `NORMAL` как дефолтного значения
			fx_crop_image($attributes['tmp_name'],
				$extension, $this->params->image_params['normal']['width'],
				$this->params->image_params['normal']['height'],$x,$y);

//			перебрать остальные ключи для обрезки картинки по установленным параметрам
			foreach($this->params->image_params as $key=>$value){
//				имя файла
				$image_file_name = "{$key}-{$image_hash}.{$extension}";
//				путь для сохранения
				$image_path_to_save = "{$path_to_save}/{$image_file_name}";
//				скопировать картинку в папку с картинками
				copy($attributes['tmp_name'],$image_path_to_save);

//				заполнить поле размера картинки для БД
				$insert_data["p_{$key}"] = "{$user_files_path}/{$image_file_name}";

//				`resize_height` установлен в "0", чтоб не плющило изображения по высоте
				fx_crop_and_resize_image($image_path_to_save, $extension, $value['width'], 0, $value['width'], $value['height']);
			}

			unlink($attributes['tmp_name']);

			return $insert_data;
		}
















	}















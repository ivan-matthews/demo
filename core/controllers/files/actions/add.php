<?php

	namespace Core\Controllers\Files\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Files\Config;
	use Core\Controllers\Files\Controller;
	use Core\Controllers\Files\Forms\Add_Files;
	use Core\Controllers\Files\Model;

	class Add extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var Model */
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

		/** @var Session */
		public $session;

		/** @var array */
		public $add;

		public $user_id;

		/** @var Add_Files */
		public $add_form;

		public $files_list = array();

		public $insert_data = array();

		public $file_id;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->backLink();
			$this->user_id = $this->session->get('u_id',Session::PREFIX_AUTH);
			$this->add_form = Add_Files::getInstance();
		}

		public function methodGet(){
			$this->setResponse()->addResponse();

			$this->add_form->generateFieldsList();

			$this->response->controller('files','add')
				->setArray(array(
					'form'	=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));
			return $this;
		}

		public function methodPost(){
			$this->add_form->checkForm($this->request->getAll());

			$this->setResponse()->addResponse();

			if($this->add_form->can()){
				$this->files_list = $this->add_form->getAttribute('files','files');

				foreach($this->files_list as $file_params){
					$this->setFile($this->user_id,$file_params);
				}

				$this->file_id = $this->model->addFiles($this->insert_data);

				if($this->file_id){
					return $this->redirect(fx_get_url('users','files',$this->user_id));
				}
			}

			$this->response->controller('files','add')
				->setArray(array(
					'form'	=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));
			return $this;
		}

		public function setFile($user_id,$file_params,$folder='files'){
			$current_time = time();

			$extension 	= $this->getExt($file_params['name']);
			$hash 		= $this->getHash($file_params['tmp_name']);
			$file_name	= "{$hash}.{$extension}";
			$folder 	= "{$user_id}/{$folder}";
			$directory 	= $this->setPath($folder);	// /var/www/m.c/public/uploads/users/1/path/to/file
			$dnl_link	= $this->setDownloadPath("{$folder}/{$file_name}");	// users/1/path/to/file

			fx_make_dir($directory);
			move_uploaded_file($file_params['tmp_name'],"{$directory}/{$file_name}");

			$this->insert_data[] = array(
				'f_user_id'			=> $this->user_id,
				'f_name'			=> $file_params['name'],
				'f_size'			=> $file_params['size'],
				'f_path'			=> $dnl_link,
				'f_hash'			=> "{$user_id}-{$hash}",
				'f_mime'			=> $file_params['type'],
				'f_date_created'	=> $current_time,
			);

			return $this;
		}

		public function getExt($file){
			return pathinfo($file,PATHINFO_EXTENSION);
		}

		public function setDownloadPath($folder){
			return "users/{$folder}";
		}

		public function setPath($folder){
			return fx_get_upload_root_path($this->setDownloadPath($folder));
		}

		public function getHash($file_path){
			return md5_file($file_path);
		}

		public function addResponse(){
			$this->response->title('files.add_files');
			$this->response->breadcrumb('add')
				->setValue('files.add_files')
				->setLink('files','add')
				->setIcon(null);
			return $this;
		}
















	}















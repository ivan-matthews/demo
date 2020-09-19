<?php

	namespace Core\Controllers\Audios\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Audios\Config;
	use Core\Controllers\Audios\Controller;
	use Core\Controllers\Audios\Forms\Add_Audios;
	use Core\Controllers\Audios\Model;

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

		/** @var Add_Audios */
		public $add_form;

		public $audios_list = array();

		public $insert_data = array();

		public $audio_id;

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
			$this->add_form = Add_Audios::getInstance();
		}

		public function methodGet(){
			$this->setResponse()->addResponse();

			$this->add_form->generateFieldsList();

			$this->response->controller('audios','add')
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
				$this->audios_list = $this->add_form->getAttribute('audios','files');

				foreach($this->audios_list as $audio_params){
					$this->setAudio($this->user_id,$audio_params);
				}

				$this->audio_id = $this->model->addAudios($this->insert_data);

				if($this->audio_id){
					return $this->redirect(fx_get_url('users','audios',$this->user_id));
				}
			}

			$this->response->controller('audios','add')
				->setArray(array(
					'form'	=> $this->add_form->getFormAttributes(),
					'fields'	=> $this->add_form->getFieldsList(),
					'errors'	=> $this->add_form->getErrors()
				));
			return $this;
		}

		public function setAudio($user_id,$audio_params,$folder='audios'){
			$current_time = time();

			$extension 	= $this->getExt($audio_params['name']);
			$hash 		= $this->getHash($audio_params['tmp_name']);
			$audio_name	= "{$hash}.{$extension}";

			$image_directory_suffix = mb_substr($hash,0,4);
			$first_folder = mb_substr($image_directory_suffix,0,2);
			$second_folder = mb_substr($image_directory_suffix,2,4);

			$folder 	= "{$user_id}/{$folder}/{$first_folder}/{$second_folder}";

			$directory 	= $this->setPath($folder);	// /var/www/m.c/public/uploads/users/1/path/to/audio
			$dnl_link	= $this->setDownloadPath("{$folder}/{$audio_name}");	// users/1/path/to/audio

			fx_make_dir($directory);
			move_uploaded_file($audio_params['tmp_name'],"{$directory}/{$audio_name}");

			$this->insert_data[] = array(
				'au_user_id'			=> $this->user_id,
				'au_name'			=> $audio_params['name'],
				'au_size'			=> $audio_params['size'],
				'au_path'			=> $dnl_link,
				'au_hash'			=> "{$user_id}-{$hash}",
				'au_mime'			=> $audio_params['type'],
				'au_date_created'	=> $current_time,
			);

			return $this;
		}

		public function getExt($audio){
			return pathinfo($audio,PATHINFO_EXTENSION);
		}

		public function setDownloadPath($folder){
			return "users/{$folder}";
		}

		public function setPath($folder){
			return fx_get_upload_root_path($this->setDownloadPath($folder));
		}

		public function getHash($audio_path){
			return md5_file($audio_path);
		}

		public function addResponse(){
			$this->response->title('audios.add_audios');
			$this->response->breadcrumb('add')
				->setValue('audios.add_audios')
				->setLink('audios','add')
				->setIcon(null);
			return $this;
		}



















	}















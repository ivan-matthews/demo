<?php

	namespace Core\Controllers\Users\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Users\Config;
	use Core\Controllers\Users\Controller;
	use Core\Controllers\Users\Model;
	use Core\Controllers\Users\Forms\Item as UserForm;

	use Core\Controllers\Photos\Model as PhotosModel;
	use Core\Controllers\Videos\Model as VideosModel;
	use Core\Controllers\Audios\Model as AudiosModel;
	use Core\Controllers\Files\Model as FilesModel;

	class Item extends Controller{

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
		public $user_data;
		public $user_groups;
		public $user_id;

		public $users_item_form;
		public $fields;
		public $fields_list;
		public $user_menu = array();

		public $photos_model;
		public $photos_query;
		public $total_photos;
		public $photos;

		public $videos_model;
		public $videos_query;
		public $total_videos;
		public $videos;

		public $audios_model;
		public $audios_query;
		public $total_audios;
		public $audios;

		public $files_model;
		public $files_query;
		public $total_files;
		public $files;

		public $prepared_data;

		private $breadcrumbs;

		public $response_data = array();

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->breadcrumbs = $this->response->breadcrumb('users_item')
				->setIcon(null);
			$this->users_item_form = UserForm::getInstance();
		}

		public function methodGet($user_id){
			$this->user_id = $user_id;

			$this->user_data = $this->model->getUserByID($user_id);
			if($this->user_data){

				$this->response->title($this->user_data['u_full_name']);
				$this->breadcrumbs->setLink('users','item',$this->user_data['u_id'])
					->setValue($this->user_data['u_full_name']);

				$this->fields = $this->params->loadParamsFromControllerFile('fields');

				$this->fields_list = $this->users_item_form->getFields($this->fields);

				$user_groups = fx_arr($this->user_data['a_groups']);
				$this->user_groups = $this->model->getUserGroupsByGroupsArray($user_groups);

				$this->prepared_data['%user_id%'] = $this->user_id;

				$this->response_data = array(
					'user'	=> $this->user_data,
					'groups'=> $this->user_groups,
					'menu'	=> $this->user_menu,
					'fields'=> $this->fields_list,
				);

				$this->getUserPhotos();
				$this->getUserAudios();
				$this->getUserVideos();
				$this->getUserFiles();

				$this->response->controller('users','item')
					->setArray($this->response_data);

				return $this;
			}
			return false;
		}

//-------------------------------------------------------------//
//-----------------------ХУКИ-(в-будущем)----------------------//
//-------------------------------------------------------------//

		public function getUserPhotos(){
			$this->photos_model = PhotosModel::getInstance();

			$this->photos_query .= "p_status = " . Kernel::STATUS_ACTIVE;
			$this->photos_query .= " AND p_user_id = %user_id%";
			$this->total_photos = $this->photos_model->countPhotos($this->photos_query,$this->prepared_data);
			$this->photos = $this->photos_model->getPhotos(
				5,0,$this->photos_query,
				'p_date_updated DESC, p_date_created DESC',null,
				$this->prepared_data
			);

			$this->response_data['photos'] 			= $this->photos;
			$this->response_data['total_photos']	= $this->total_photos;
			return $this;
		}

		public function getUserAudios(){
			$this->audios_model = AudiosModel::getInstance();

			$this->audios_query .= "au_status = " . Kernel::STATUS_ACTIVE;
			$this->audios_query .= " AND au_user_id = %user_id%";
			$this->total_audios = $this->audios_model->countAudios($this->audios_query,$this->prepared_data);
			$this->audios = $this->audios_model->getAudios(
				3,0,$this->audios_query,
				'au_date_updated DESC, au_date_created DESC',null,
				$this->prepared_data
			);

			$this->response_data['audios'] =		$this->audios;
			$this->response_data['total_audios'] =	$this->total_audios;
			return $this;
		}

		public function getUserVideos(){
			$this->videos_model = VideosModel::getInstance();

			$this->videos_query .= "v_status = " . Kernel::STATUS_ACTIVE;
			$this->videos_query .= " AND v_user_id = %user_id%";
			$this->total_videos = $this->videos_model->countVideos($this->videos_query,$this->prepared_data);
			$this->videos = $this->videos_model->getVideos(
				2,0,$this->videos_query,
				'v_date_updated DESC, v_date_created DESC',null,
				$this->prepared_data
			);

			$this->response_data['videos'] =		$this->videos;
			$this->response_data['total_videos'] =	$this->total_videos;
			return $this;
		}

		public function getUserFiles(){
			$this->files_model = FilesModel::getInstance();

			$this->files_query .= "f_status = " . Kernel::STATUS_ACTIVE;
			$this->files_query .= " AND f_user_id = %user_id%";
			$this->total_files = $this->files_model->countFiles($this->files_query,$this->prepared_data);
			$this->files = $this->files_model->getFiles(
				3,0,$this->files_query,
				'f_date_updated DESC, f_date_created DESC',null,
				$this->prepared_data
			);

			$this->response_data['files'] =			$this->files;
			$this->response_data['total_files'] =	$this->total_files;
			return $this;
		}
















	}















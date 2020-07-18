<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;

	class Item extends Controller{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $config;

		/** @var Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $site_config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var array */
		public $bookmark;

		public $user_data;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->response->title('auth.title_auth_bookmark');
			$this->dontSetBackLink();
		}

		public function methodGet($bookmark){
			$this->bookmark = $bookmark;
			$this->response->breadcrumb('bookmark')
				->setValue('auth.title_auth_bookmark')
				->setLink('auth','item',$this->bookmark)
				->setIcon(null);
			$this->user_data = $this->model->getUserByBookmark($bookmark);
			if($this->user_data){
				$this->user_data['groups'] = fx_arr($this->user_data['groups']);
				$this->user->escape();
				$this->user->auth($this->user_data,true);

				// run Users::Item($this->user_data['id']) controller

				return $this->redirect();
			}
			return false;
		}



















	}















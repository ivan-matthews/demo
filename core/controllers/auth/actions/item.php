<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Kernel;
	use Core\Classes\Mail\Session_Message;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;
	use Core\Controllers\Users\Actions\Item as UserPage;

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

		/** @var array */
		public $bookmark;

		public $user_data;

		private $breadcrumb;

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
			$this->breadcrumb = $this->response->breadcrumb('bookmark')
				->setValue('auth.title_auth_bookmark')
				->setIcon(null);
		}

		public function methodGet($bookmark){

			$this->bookmark = $bookmark;

			$this->breadcrumb->setLink('auth','item',$this->bookmark);

			$this->user_data = $this->model->getUserByBookmark($bookmark);

			if($this->user_data){

				if(fx_equal((int)$this->user_data['a_status'],Kernel::STATUS_BLOCKED)){

					Session_Message::set('bookmark')
						->head(fx_lang('auth.account_locked_title'))
						->value(fx_lang('auth.account_locked_value'))
						->icon_class('far fa-dizzy')
						->enabled_pages('auth','item')
						->send();

					return false;
				}

				$this->user_data['a_groups'] = fx_arr($this->user_data['a_groups']);
				$this->user->escape();
				$this->user->auth($this->user_data,true);

				Session_Message::set('bookmark')
					->head(fx_lang('auth.add_this_page_to_bookmarks_title'))
					->value(fx_lang('auth.add_this_page_to_bookmarks_value'))
					->enabled_pages('auth','item')
					->send();

				$user_page = new UserPage();
				return $user_page->methodGet($this->user_data['u_id']);
			}
			return false;
		}



















	}















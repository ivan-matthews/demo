<?php

	namespace Core\Controllers\Redirect\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Redirect\Config;
	use Core\Controllers\Redirect\Controller;
	use Core\Controllers\Redirect\Model;

	class Index extends Controller{

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
		public $index;

		public $link_to_redirect;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->link_to_redirect = $this->request->get('url');
		}

		public function methodGet(){
			$this->response->controller('redirect','index')
				->setArray(array(
					'link'	=> urlencode($this->link_to_redirect)
				));

			return $this;
		}





















	}















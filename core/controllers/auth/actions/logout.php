<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Form\Validator;
	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;

	class Logout extends Controller{

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
		private $logout;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->logout[$key])){
				return $this->logout[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->logout[$name] = $value;
			return $this->logout[$name];
		}

		public function __construct(){
			parent::__construct();
			$this->dontSetBackLink();
		}

		public function __destruct(){

		}

		public function methodGet(){
			if(fx_equal(fx_csrf_equal($this->site_config->session['csrf_key_name']),Validator::CSRF_TOKEN_EQUAL)){
				$this->user->escape();
				$this->redirect();
				return true;
			}
			return false;
		}

		public function methodPost(){
			return false;
		}

		public function methodPut(){
			return false;
		}

		public function methodHead(){
			return false;
		}

		public function methodTrace(){
			return false;
		}

		public function methodPatch(){
			return false;
		}

		public function methodOptions(){
			return false;
		}

		public function methodConnect(){
			return false;
		}

		public function methodDelete(){
			return false;
		}




















	}















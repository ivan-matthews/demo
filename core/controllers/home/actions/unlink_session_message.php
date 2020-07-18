<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Home\Config;
	use Core\Controllers\Home\Controller;
	use Core\Controllers\Home\Model;
	use Core\Classes\Form\Validator;
	use Core\Classes\Session;

	class Unlink_Session_Message extends Controller{

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
		public $unlink_session_message;

		/** @var Session */
		public $session;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
			$this->doNotSetBackLink();
		}

		public function methodGet($session_messages_key){
			if(fx_equal(fx_csrf_equal($this->config->session['csrf_key_name']),Validator::CSRF_TOKEN_EQUAL)){
				$this->session->unsetSessionMessages($session_messages_key);
				$this->redirect();
				return true;
			}
			return false;
		}




















	}















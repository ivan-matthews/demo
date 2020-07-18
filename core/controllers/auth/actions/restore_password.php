<?php

	namespace Core\Controllers\Auth\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;
	use Core\Controllers\Auth\Config;
	use Core\Controllers\Auth\Controller;
	use Core\Controllers\Auth\Model;

	class Restore_Password extends Controller{

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

		public $restore_password;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
		}

		public function methodGet(){
			return false;
		}

		public function methodPost(){
			return false;
		}



















	}















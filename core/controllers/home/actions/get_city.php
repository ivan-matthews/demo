<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Hooks;
	use Core\Classes\Request;
	use Core\Classes\Session;
	use Core\Classes\Response\Response;
	use Core\Controllers\Home\Config;
	use Core\Controllers\Home\Controller;
	use Core\Controllers\Home\Model;

	class Get_City extends Controller{

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
		public $get_city;

		public $limit;
		public $offset;
		public $total;
		public $order;
		public $sort;

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

			$value = $this->request->get('value');
			$country_id = $this->request->get('country_id');
			$region_id = $this->request->get('region_id');

			return $this->response->controller('home','geo')
				->setArray($this->model->getCityByName($value,$region_id,$country_id));
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















<?php

	namespace Core\Controllers\Home\Actions;

	use Core\Classes\Response;
	use Core\Classes\Router;
	use Core\Classes\Request;

	use Core\Controllers\Home\Controller;

	class Index extends Controller{

		private static $instance;

		protected $index;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->index[$key])){
				return $this->index[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->index[$name] = $value;
			return $this->index[$name];
		}

		public function __construct(){
			parent::__construct();

			$response = Response::getInstance();
			$router = Router::getInstance();
			$request = Request::getInstance();

			fx_pre(array(
				'code'=>$response->getResponseCode(),
				'stat'=>$response->getResponseStatus(),
			));


			fx_pre(array(
				'cnt'=>$router->getController(),
				'act'=>$router->getAction(),
				'prm'=>$router->getParams(),
				'sts'=>$router->getRouterStatus(),
				'all'=>$request->getAll(),
//		'arr'=>fx_load_array('system/assets',Kernel::IMPORT_INCLUDE_ONCE),
//		'cnf'=>$config->getAll()
			));

			function a($iterations){
				$result = array();
				for($i=0;$i<$iterations;$i++){ $result[$i] = 'string_random'; }
				return $result;
			}

			$this->model->indexModel(a(1));
			$this->model->indexModel(a(2));
			$this->model->indexModel(a(2));
			$this->model->indexModel(a(4));


			fx_pre(array(
				'files'=>get_included_files(),
				'memor'=>fx_prepare_memory(memory_get_usage(),4,',',' '),
				'times'=>number_format(microtime(true)-TIME,10),
				'debug'=>$response->getDebug()
			));
		}

		public function __destruct(){

		}

		public function methodGet(){
			fx_pre(__METHOD__);
			return true;
		}

		public function methodPost(){
			fx_pre(__METHOD__);
			return true;
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















<?php

	namespace Core\Classes;

	use Core\Classes\Response\Response;

	class Controller{

		private static $instance;

		/** @var Config  */
		public $config;

		public $language;
		public $language_key;

		/** @var Response  */
		public $response;

		/** @var Session  */
		public $session;

		/** @var Interfaces\Request */
		public $request;

		/** @var User  */
		public $user;

		/** @var Interfaces\Hooks  */
		public $hook;

		/** @var array */
		private $controller;

		public $query = '';

		public $limit = 20;
		public $offset = 0;
		public $order;
		public $sort = 'DESC';

		public $sorting_types = array(
			'up'	=> 'DESC',
			'dn'	=> 'ASC'
		);

		public $sorting_action;
		public $sorting_type = 'up';

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->controller[$key])){
				return $this->controller[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->controller[$name] = $value;
			return $this->controller[$name];
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->response = Response::getInstance();
			$this->session = Session::getInstance();
			$this->request = Request::getInstance();
			$this->user = User::getInstance();
			$this->language = Language::getInstance();
			$this->hook = Hooks::getInstance();

			$this->offset = $this->request->get('offset') ?? 0;
			$this->offset = abs((int)$this->offset);
		}

		public function __destruct(){

		}


		/**
		 * установить ссылку для редиректа;
		 * если ссылки не будет - берем из сессии историю посещений
		 *
		 * @param null $link_to_redirect
		 * @param int $status_code
		 * @return $this
		 */
		private function redirectInternal($link_to_redirect=null,$status_code=302){
			if(!$link_to_redirect){
				$link_to_redirect = $this->user->getBackUrl();
			}
			$link_to_redirect = trim($link_to_redirect,' /');
			$this->response->setResponseCode($status_code)
				->setHeader('Location',"/{$link_to_redirect}");
			return $this;
		}

		public function redirect($link_to_redirect=null,$status_code=302){
			if($link_to_redirect){
				$link_info = parse_url($link_to_redirect);
				if(isset($link_info['scheme'])){
					$this->response->setResponseCode($status_code)
						->setHeader('Location',$link_to_redirect);
					return $this;
				}
			}
			return $this->redirectInternal($link_to_redirect,$status_code);
		}

		/**
		 * Устанавливать [false|null] или не устанавливать [true]
		 * ссылку для возврата в историю сессии
		 *
		 * @param bool $back_link_not_set
		 * @return bool
		 */
		protected function backLink($back_link_not_set=true){
			$this->user->no_set_back_url = $back_link_not_set;
			return false;
		}

		/**
		 * Рендерить пустую страницу, если данных нету?
		 *
		 * @return $this
		 */
		protected function renderEmptyPage(){
			$this->response->controller('../assets','../empty_page');
			return $this;
		}









	}















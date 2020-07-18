<?php

	namespace Core\Classes;

	use Core\Classes\Response\Response;
	use Core\Widgets\Paginate;
	use Core\Widgets\Sorting_Panel;

	class Controller{

		private static $instance;

		public $config;
		public $response;
		public $session;
		public $request;
		public $user;
		public $hook;

		public $limit	= 15;
		public $offset	= 0;
		public $total	= 0;
		public $order	= 'id';

		public $sort	= 'ASC';
		public $sort_key='dn';
		public $sorting = array(
			'up'	=> 'DESC',
			'dn'	=> 'ASC',
		);

		private $controller;

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
			$this->hook = Hooks::getInstance();

			$this->response->title($this->config->core['site_name']);
			$this->response->breadcrumb('main_breadcrumb')
				->setValue($this->config->core['site_name'])
				->setLink()
				->setIcon('fa fa-home');
			$this->response->favicon($this->config->view['default_favicon']);
			$this->setMeta();

			$this->limit	= $this->request->get('limit')?:15;
			$this->offset	= $this->request->get('offset')?:0;
			$this->sort		= $this->request->get('sort');

			$this->sort_key = $this->sort ?: $this->sort_key;
			$this->sort = isset($this->sorting[$this->sort]) ? $this->sorting[$this->sort] : 'ASC';
		}

		public function __destruct(){

		}

		public function redirect($link_to_redirect=null,$status_code=302){
			if(!$link_to_redirect){
				$link_to_redirect = $this->user->getBackUrl();
			}
			$link_to_redirect = trim($link_to_redirect,' /');
			$this->response->setResponseCode($status_code)
				->setHeader('Location',"/{$link_to_redirect}");
			return $this;
		}

		private function setMeta(){
			$this->response->meta('csrf')
				->set('name','csrf')
				->set('content',fx_csrf());
			$this->response->meta('charset')
				->set('charset','utf-8');
			$this->response->meta('description')
				->set('name','description')
				->set('content',$this->config->core['site_name']);
			$this->response->meta('generator')
				->set('name','generator')
				->set('content','simple generated values');
			$this->response->meta('viewport')
				->set('name','viewport')
				->set('content','width=device-width');

			$this->response->meta('http_equiv')
				->set('http-equiv','Content-Type')
				->set('content','text/html; charset=UTF-8');
			return $this;
		}

		public function doNotSetBackLink(){
			$this->user->no_set_back_url = true;
			return false;
		}

		public function renderEmptyPage(){
			$this->response->controller('../assets','../empty_page');
			return $this;
		}

		public function paginate($link){
			Paginate::add()
				->total($this->total)
				->limit($this->limit)
				->offset($this->offset)
				->link($link)
				->set();
			return $this;
		}

		public function sorting(array $actions,$current){
			$current_data['action'] = $current;
			$current_data['sort'] = $this->sort_key;

			Sorting_Panel::add()
				->actions($actions)->current($current_data)->set();
			return $this;
		}
















	}















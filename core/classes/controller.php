<?php

	namespace Core\Classes;

	use Core\Classes\Response\Response;
	use Core\Widgets\Paginate;
	use Core\Widgets\Sorting_Panel;
	use Core\Widgets\Header_Bar;

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
		public function redirect($link_to_redirect=null,$status_code=302){
			if(!$link_to_redirect){
				$link_to_redirect = $this->user->getBackUrl();
			}
			$link_to_redirect = trim($link_to_redirect,' /');
			$this->response->setResponseCode($status_code)
				->setHeader('Location',"/{$link_to_redirect}");
			return $this;
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

		protected function paginate($total_items,$link){
			Paginate::add()
				->total($total_items)
				->limit($this->limit)
				->offset($this->offset)
				->link($link)
				->set();
			return $this;
		}

		protected function setResponseBySortingPanel(array $response_values){
			$this->response->title($response_values['title']);
			$this->response->breadcrumb('filter')
				->setIcon($response_values['icon'])
				->setLink(...$response_values['link'])
				->setValue($response_values['title']);
			return $this;
		}

		protected function sorting(array $actions,...$push_links_params){
			$callable_action = "setSortingPanel{$this->sorting_action}";
			if(isset($actions[$this->sorting_action]) && fx_equal($actions[$this->sorting_action]['status'],Kernel::STATUS_ACTIVE) &&
				method_exists($this,$callable_action)){
				$this->query .= call_user_func(array($this,$callable_action));
				$this->setResponseBySortingPanel($actions[$this->sorting_action]);
			}

			Sorting_Panel::add()
				->actions($actions)
				->current(array(
					'action'	=> $this->sorting_action,
					'sort'		=> $this->sorting_type,
					'push'		=> $push_links_params,
				))->set();

			return $this;
		}

		protected function header_bar(array $header_bar_data_from_params_array,array $tabs_link,$current_tab){
			foreach($header_bar_data_from_params_array as $key=>$value){
				$new_tabs_link = $tabs_link;
				$new_tabs_link[] = $key;
				$header_bar_data_from_params_array[$key]['link'] = $new_tabs_link;
			}

			Header_Bar::add()
				->data($header_bar_data_from_params_array)
				->current($current_tab)
				->set();
			return $this;
		}










	}















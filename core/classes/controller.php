<?php

	namespace Core\Classes;

	use Core\Classes\Form\Form;
	use Core\Classes\Response\Response;
	use Core\Widgets\Filter;
	use Core\Widgets\Paginate;
	use Core\Widgets\Sorting_Panel;
	use Core\Classes\Form\Interfaces\Form as FormInterface;

	class Controller{

		private static $instance;

		public $config;
		public $response;
		public $session;
		public $request;
		public $user;
		public $hook;

		public $query;
		public $replaced_data = array();
		public $limit	= 15;
		public $offset	= 0;
		public $total	= 0;
		public $order	= 'id';

		public $sort	= 'ASC';
		public $sort_key='dn';
		protected $sorting_action='all';
		public $sorting = array(
			'up'	=> 'DESC',
			'dn'	=> 'ASC',
		);

		public $fields_list;
		public $form;

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
		}

		public function __destruct(){

		}

		protected function setDefaultData(){
			$this->response->title($this->config->core['site_name']);
			$this->response->breadcrumb('main_breadcrumb')
				->setValue($this->config->core['site_name'])
				->setLink()
				->setIcon('fa fa-home');
			$this->response->favicon($this->config->view['default_favicon']);
			$this->setMeta();

			$this->limit	= $this->request->get('limit')?:15;
			$this->offset	= $this->request->get('offset')?:0;

			return $this;
		}

		protected function getSort($sorting_action,$sort){
			$this->sorting_action = $sorting_action;
			$this->sort_key = $sort ?: $this->sort_key;
			$this->sort = isset($this->sorting[$sort]) ? $this->sorting[$sort] : 'ASC';
			return $this;
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

		protected function setMeta(){
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

		protected function doNotSetBackLink(){
			$this->user->no_set_back_url = true;
			return false;
		}

		protected function renderEmptyPage(){
			$this->response->controller('../assets','../empty_page');
			return $this;
		}

		protected function paginate($link){
			Paginate::add()
				->total($this->total)
				->limit($this->limit)
				->offset($this->offset)
				->link($link)
				->set();
			return $this;
		}

		protected function sorting(array $actions,$current){
			$current_data['action'] = $current;
			$current_data['sort'] = $this->sort_key;

			Sorting_Panel::add()
				->actions($actions)->current($current_data)->set();
			return $this;
		}

		protected function getQueryFromSortingPanelArray(array $sorting_panel,$sorting_action){
			if(isset($sorting_panel[$sorting_action]) &&
				fx_equal($sorting_panel[$sorting_action]['status'],Kernel::STATUS_ACTIVE) &&
				method_exists($this,$sorting_action)){
				$this->query .= call_user_func(array($this,$sorting_action));
			}
			return $this;
		}

		protected function getFilterFromArrayFields($form_key,$fields){
			$data = $this->request->getArray($form_key);
			$this->form = new Form();
			$this->form->setData($data);
			$this->form->validate(1);
			$this->form->form(function(FormInterface $form)use($form_key){
				$form->setFormAction(fx_get_url('users','index',$this->sorting_action,$this->sort_key));
				$form->setFormMethod('GET');
				$form->setFormAutoComplete('off');
				$form->setFormName($form_key);
			});
			$this->fields_list = $this->form->setArrayFields($fields)
				->checkArrayFields()
				->getFieldsList();

			foreach($data as $key=>$value){
				if(isset($this->fields_list[$key]) && $value){
					$this->query .= " AND `{$key}` {$this->fields_list[$key]['attributes']['params']['filter_validation']} %{$key}%";
					$this->replaced_data["%{$key}%"] = $this->makeFilter($this->fields_list[$key]['attributes']['params']['filter_validation'],$value);
				}
			}

			Filter::add()
				->form($this->form->getFormAttributes())
				->fields($this->form->getFieldsList())
				->errors($this->form->getErrors())
				->data($data)
				->set();

			return $this;
		}

		private function makeFilter($operator,$value){
			switch($operator){
				case(fx_equal($operator,'LIKE')):
					return "%{$value}%";
					break;
				case(fx_equal($operator,'=')):
					return $value;
					break;
				case(fx_equal($operator,'!=')):
					return $value;
					break;
				default:
					return $value;
					break;
			}
		}














	}















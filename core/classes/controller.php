<?php

	namespace Core\Classes;

	use Core\Classes\Form\Form;
	use Core\Classes\Response\Response;
	use Core\Classes\Form\Interfaces\Form as FormInterface;
	use Core\Widgets\Filter;
	use Core\Widgets\Paginate;
	use Core\Widgets\Sorting_Panel;
	use Core\Controllers\Home\Model;

	class Controller{

		private static $instance;

		/** @var Config  */
		public $config;

		public $language;

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

		/** @var string */
		public $query;

		/** @var array */
		public $replaced_data = array();

		/** @var int */
		public $limit	= 15;

		/** @var int */
		public $offset	= 0;

		/** @var int */
		public $total	= 0;

		/** @var string */
		public $order	= 'id';

		/** @var string  */
		public $sort	= 'ASC';

		/** @var string */
		public $sort_key='dn';

		/** @var string */
		protected $sorting_action='all';

		/** @var array */
		public $sorting = array(
			'up'	=> 'DESC',
			'dn'	=> 'ASC',
		);

		/** @var array */
		public $fields_list;
		public $filter_fields;
		public $filter_data;
		public $filter_name;

		/** @var Form */
		public $form;

		/** @var Form */
		public $filter;

		/** @var array */
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
			$this->language = Language::getInstance();
			$this->hook = Hooks::getInstance();
		}

		public function __destruct(){

		}

		/**
		 * Установка дефолтных параметров для HTML-шаблона
		 *
		 * @return $this
		 */
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

		/**
		 * Установка свойств для сортировки
		 * $sorting_action - подставляется из файла параметров контроллера;
		 * $sort [dn,up] - dn - DESC; up - ASC;
		 *
		 * @param $sorting_action
		 * @param $sort
		 * @return $this
		 */
		protected function setSortingProps($sorting_action,$sort){
			$this->sorting_action = $sorting_action;
			$this->sort_key = $sort ?: $this->sort_key;
			$this->sort = isset($this->sorting[$sort]) ? $this->sorting[$sort] : 'ASC';
			return $this;
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
		 * Установить параметры тега <meta> для HTML-шаблона
		 *
		 * @return $this
		 */
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

		/**
		 * Установить пагинацию?
		 * должны быть предустановлены свойста $this->total, $this->limit, $this->offset
		 *
		 * @param $link
		 * @return $this
		 */
		protected function paginate($link){
			Paginate::add()
				->total($this->total)
				->limit($this->limit)
				->offset($this->offset)
				->link($link)
				->set();
			return $this;
		}

		/**
		 * Установить панель сортировки?
		 * $actions - массив, берется из параметров контроллера
		 * $current - текущая сортировка (можно установить с помощью метода Controller::setSortingProps(all,up))
		 *
		 * @param array $actions
		 * @param $current
		 * @return $this
		 */
		protected function sorting(array $actions,$current){
			$current_data['action'] = $current;
			$current_data['sort'] = $this->sort_key;

			Sorting_Panel::add()
				->actions($actions)->current($current_data)->set();
			return $this;
		}

		/**
		 * Получить запрос для фильтраии из панели сортировки;
		 * дополняет свойсто $this->query
		 *
		 * @param array $sorting_panel
		 * @param $sorting_action
		 * @return $this
		 */
		protected function getQueryFromSortingPanelArray(array $sorting_panel,$sorting_action){
			if(isset($sorting_panel[$sorting_action]) &&
				fx_equal($sorting_panel[$sorting_action]['status'],Kernel::STATUS_ACTIVE) &&
				method_exists($this,$sorting_action)){
				$this->query .= call_user_func(array($this,$sorting_action));
			}
			return $this;
		}

		/**
		 * установить панель фильтра
		 * $form_key - имя формы, по нему берутся данные из реквеста
		 * $fields - массив полей (пример: core/controllers/users/config/fields.php)
		 *
		 * заполняет свойства $this->query, array $this->replaced_data, которые отправляем в модель контроллера
		 * для фильтрации запроса
		 *
		 * @param $form_key
		 * @param $fields
		 * @return $this
		 */
		protected function setFilterFromArrayFields($form_key,$fields){
			$this->filter_name = $form_key;
			$this->filter_fields = $fields;
			$this->filter_data = $this->request->getArray($form_key);
			$this->filter = new Form();
			$this->filter->setData($this->filter_data);
			$this->filter->validate(1);
			$this->filter->form(function(FormInterface $form)use($form_key){
				$form->setFormAction(fx_get_url('users','index',$this->sorting_action,$this->sort_key));
				$form->setFormMethod('GET');
				$form->setFormAutoComplete('off');
				$form->setFormName($form_key);
			});

			return $this;
		}

		protected function geo($country_field_name,$region_field_name,$city_field_name){
			if(!$this->filter){ return $this; }
			$lang_key = $this->language->getLanguageKey();

			$this->filter->field('geo')
				->field_type('geo');

			if(($country_value = $this->filter->getValue($country_field_name))){
				$this->query .= " AND {$country_field_name}=%country%";
				$this->replaced_data["%country%"] = $country_value;
			}
			if(($region_value = $this->filter->getValue($region_field_name))){
				$this->query .= " AND {$region_field_name}=%region%";
				$this->replaced_data["%region%"] = $region_value;
			}
			if(($city_value = $this->filter->getValue($city_field_name))){
				$this->query .= " AND {$city_field_name}=%city%";
				$this->replaced_data["%city%"] = $city_value;
			}

			$geo_info = Model::getInstance()
				->getGeoByIds($country_value,$region_value,$city_value);

			$this->filter->setParams('country',array(
				'id'	=> $country_value,
				'name'	=> $this->filter_name ? "{$this->filter_name}[{$country_field_name}]" : $country_field_name,
				'value'	=> $geo_info["g_title_{$lang_key}"],
			));
			$this->filter->setParams('region',array(
				'id'	=> $region_value,
				'name'	=> $this->filter_name ? "{$this->filter_name}[{$region_field_name}]" : $region_field_name,
				'value'	=> $geo_info["gr_title_{$lang_key}"],
			));
			$this->filter->setParams('city',array(
				'id'	=> $city_value,
				'name'	=> $this->filter_name ? "{$this->filter_name}[{$city_field_name}]" : $city_field_name,
				'value'	=> (!$geo_info['gc_area']?'':"{$geo_info['gc_area']}, ") . $geo_info["gc_title_{$lang_key}"],
			));
			return $this;
		}

		protected function checkFilter(){
			$this->fields_list = $this->filter->setArrayFields($this->filter_fields)
				->checkArrayFields()
				->getFieldsList();
			foreach($this->filter_data as $key=>$value){
				if(isset($this->fields_list[$key]) && $value){
					$this->query .= " AND `{$key}` {$this->fields_list[$key]['attributes']['params']['filter_validation']} %{$key}%";
					$this->replaced_data["%{$key}%"] = $this->makeFilter($this->fields_list[$key]['attributes']['params']['filter_validation'],$value);
				}
			}

			Filter::add()
				->form($this->filter->getFormAttributes())
				->fields($this->filter->getFieldsList())
				->errors($this->filter->getErrors())
				->data($this->filter_data)
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















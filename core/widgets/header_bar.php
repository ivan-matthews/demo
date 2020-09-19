<?php
	
	namespace Core\Widgets;

	use Core\Classes\Response\Response;

	class Header_Bar{

		protected $params;
		protected $data = array();
		protected $current;

		protected $default_props = array(
			'w_id'				=> 1,
            'w_class'			=> self::class,
            'w_method'			=> 'set',
            'w_status'			=> 1,
            'w_template'		=> 'widgets/header_bar',
            'w_date_created' 	=> null,
            'w_date_updated' 	=> null,
            'w_date_deleted' 	=> null,
            'wa_id'				=> 3,
            'wa_widget_id'		=> 1,
			'wa_name'			=> 'header_bar',
			'wa_title'			=> 'home.header_bar_widget_title',
            'wa_css_class'		=> 0,
            'wa_css_class_title'=> 0,
            'wa_css_class_body'	=> 0,
            'wa_show_title'		=> 1,
            'wa_unite_prev'		=> 0,
            'wa_status'			=> 1,
            'wa_position'		=> 'body_header',
            'wa_ordering'		=> 998,
            'wa_template'		=> 'widgets/header_bar',
            'wa_groups_enabled' => null,
            'wa_groups_disabled'=> null,
            'wa_pages_enabled' 	=> null,
            'wa_pages_disabled' => null,
            'wa_date_created' 	=> null,
            'wa_date_updated' 	=> null,
            'wa_date_deleted' 	=> null,
		);

		private $response;

		public static function add(){
			return new self();
		}

		public function __construct(){
			$this->params = $this->default_props;
			$this->response = Response::getInstance();
		}

		public function data(array $value){
			$this->data = $value;
			return $this;
		}

		public function current($value){
			$this->current = $value;
			return $this;
		}

		public function template($template_file){
			$this->default_props['wa_template'] = $this->params['wa_template'] = $template_file;
			return $this;
		}

		public function setValue($key,$value){
			$this->default_props[$key] = $this->params[$key] = $value;
			return $this;
		}

		public function set(){
			$this->response->widget($this->default_props)
				->set('data',array(
					'header'	=> $this->data,
					'current'	=> $this->current
				))
				->set('params',$this->default_props)
				->add();
			return true;
		}


















	}
<?php
	
	namespace Core\Widgets;

	use Core\Classes\Response\Response;

	class Filter{

		protected $form;
		protected $fields;
		protected $errors;
		protected $data;

		protected $default_props = array(
			'w_id'				=> 1,
            'w_class'			=> self::class,
            'w_method'			=> 'set',
            'w_status'			=> 1,
            'w_template'		=> 'widgets/filter',
            'w_date_created' 	=> null,
            'w_date_updated' 	=> null,
            'w_date_deleted' 	=> null,
            'wa_id'				=> 3,
            'wa_widget_id'		=> 1,
			'wa_name'			=> 'filter',
			'wa_title'			=> 'home.filter_widget_title',
            'wa_css_class'		=> 0,
            'wa_css_class_title'=> 0,
            'wa_css_class_body'	=> 0,
            'wa_show_title'		=> 1,
            'wa_unite_prev'		=> 0,
            'wa_status'			=> 1,
            'wa_position'		=> 'body_header',
            'wa_ordering'		=> 1000,
            'wa_template'		=> 'widgets/filter',
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
			$this->response = Response::getInstance();
		}

		public function form(array $form_data){
			$this->form = $form_data;
			return $this;
		}
		public function fields(array $fields_data){
			$this->fields = $fields_data;
			return $this;
		}
		public function errors(array $errors_data){
			$this->errors = $errors_data;
			return $this;
		}
		public function data(array $data){
			$this->data = $data;
			return $this;
		}

		public function set(){
			$this->response->widget($this->default_props)
				->set('data',array(
					'form'		=> $this->form,
					'fields'	=> $this->fields,
					'errors'	=> $this->errors,
					'data'		=> $this->data,
				))
				->set('params',$this->default_props)
				->add();
			return true;
		}


















	}
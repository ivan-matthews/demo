<?php
	
	namespace Core\Widgets;

	use Core\Classes\Response\Response;

	class Sorting_Panel{

		protected $actions = array();
		protected $current = array();

		protected $default_props = array(
			'class'				=> '',
			'method'			=> 'run',
			'status'			=> 1,
			'template'			=> 'widgets/sorting_panel',
			'widget_id'			=> 0,
			'name'				=> 'sorting_panel',
			'title'				=> 'home.sorting_panel_widget_title',
			'css_class'			=> '',
			'css_class_title'	=> '',
			'css_class_body'	=> '',
			'show_title'		=> 1,
			'unite_prev'		=> 0,
			'position'			=> 'body_header',
			'ordering'			=> 0,
		);

		private $response;

		public static function add(){
			return new self();
		}

		public function __construct(){
			$this->response = Response::getInstance();
		}

		public function actions(array $value){
			$this->actions = $value;
			return $this;
		}
		public function current(array $value){
			$this->current = $value;
			return $this;
		}

		public function set(){
			$this->response->widget($this->default_props['position'])
				->setIndex(-1)
				->set('data',array(
					'actions'	=> $this->actions,
					'current'	=> $this->current
				))
				->set('params',$this->default_props);
			return true;
		}


















	}
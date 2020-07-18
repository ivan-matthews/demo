<?php
	
	namespace Core\Widgets;

	use Core\Classes\Response\Response;

	class Paginate{

		protected $total;
		protected $limit;
		protected $offset;
		protected $link_array;

		protected $default_props = array(
			'class'				=> '',
			'method'			=> 'run',
			'status'			=> 1,
			'template'			=> 'widgets/paginate',
			'widget_id'			=> 0,
			'name'				=> 'paginate',
			'title'				=> 'home.paginate_widget_title',
			'css_class'			=> '',
			'css_class_title'	=> '',
			'css_class_body'	=> '',
			'show_title'		=> 1,
			'unite_prev'		=> 0,
			'position'			=> 'body_footer',
			'ordering'			=> 0,
		);

		private $response;

		public static function add(){
			return new self();
		}

		public function __construct(){
			$this->response = Response::getInstance();
		}

		public function total($value){
			$this->total = $value;
			return $this;
		}
		public function limit($value){
			$this->limit = $value;
			return $this;
		}
		public function offset($value){
			$this->offset = $value;
			return $this;
		}
		public function link(array $value){
			$this->link_array = $value;
			return $this;
		}

		public function set(){
			if($this->total < $this->limit){ return false; }

			$this->response->widget($this->default_props)
				->set('data',array(
					'total'		=> $this->total,
					'limit'		=> $this->limit,
					'offset'	=> $this->offset,
					'link'		=> $this->link_array,
				))
				->set('params',$this->default_props)
				->add();
			return true;
		}


















	}
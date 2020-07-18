<?php
	
	namespace Core\Widgets;

	use Core\Classes\Response\Response;

	class Paginate{

		protected $params;
		protected $total;
		protected $limit;
		protected $offset;
		protected $link_array;

		protected $default_props = array(
			'w_id'				=> 1,
			'w_class'			=> self::class,
			'w_method'			=> 'set',
			'w_status'			=> 1,
			'w_template'		=> 'widgets/paginate',
			'w_date_created' 	=> null,
			'w_date_updated' 	=> null,
			'w_date_deleted' 	=> null,
			'wa_id'				=> 3,
			'wa_widget_id'		=> 1,
			'wa_name'			=> 'paginate',
			'wa_title'			=> 'home.paginate_widget_title',
			'wa_css_class'		=> 0,
			'wa_css_class_title'=> 0,
			'wa_css_class_body'	=> 0,
			'wa_show_title'		=> 1,
			'wa_unite_prev'		=> 0,
			'wa_status'			=> 1,
			'wa_position'		=> 'body_footer',
			'wa_ordering'		=> -999,
			'wa_template'		=> 'widgets/paginate',
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
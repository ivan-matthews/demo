<?php

	namespace Core\Controllers\Sitemap;

	use Core\Classes\Hooks;
	use Core\Classes\Controller as ParentController;
	use Core\Classes\Request;
	use Core\Classes\Response\Response;

	class Controller extends ParentController{

		/** @var $this */
		private static $instance;

		/** @var Config */
		public $params;

		/** @var \Core\Classes\Model|Model */
		public $model;

		/** @var \Core\Classes\Config */
		public $config;

		/** @var Response */
		public $response;

		/** @var Request */
		public $request;

		/** @var \Core\Classes\User */
		public $user;

		/** @var Hooks */
		public $hook;

		/** @var array */
		private $sitemap;

		public $site_link;

		public $file_suffix = '';
		public $iterations;
		public $total_items;
		public $items;

		public $controller_name;
		public $limit = 50000;
		public $offset = 0;
		public $table;
		public $selectable_fields;
		public $order_field = null;
		public $where_query = '';

		public $frequency='daily';
		public $priority=0.8;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->sitemap[$key])){
				return $this->sitemap[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->sitemap[$name] = $value;
			return $this->sitemap[$name];
		}

		public function __construct(){
			parent::__construct();

			$this->params = Config::getInstance();	// use Core\Controllers\Sitemap\Config as Config;
			$this->model = Model::getInstance();	// use Core\Controllers\Sitemap\Model as Model;

			$this->site_link = $this->config->core['site_scheme'];
			$this->site_link .= "://";
			$this->site_link .= $this->config->core['site_host'];
		}

		public function __destruct(){

		}

		public function setController($new_controller_name){
			$this->controller_name = $new_controller_name;
			return $this;
		}
		public function setTable($new_value){
			$this->table = $new_value;
			return $this;
		}
		public function setSelectableFields($id_field,$date_created_field,$date_updated_field){
			$this->selectable_fields['id'] = $id_field;
			$this->selectable_fields['created'] = $date_created_field;
			$this->selectable_fields['updated'] = $date_updated_field;
			return $this;
		}
		public function setOrderField($new_value){
			$this->order_field = $new_value;
			return $this;
		}
		public function setQuery($new_value){
			$this->where_query = $new_value;
			return $this;
		}

		public function create(){
			$this->clearControllerDirectory();
			$this->setIterator();
			for($i=0;$i<$this->iterations;$i++){
				$this->offset = $i * $this->limit;
				$this->setFileSuffix()->makeXMLFile();
			}
			return $this;
		}



		public function setOffset($new_value){
			$this->offset = $new_value;
			return $this;
		}
		public function setLimit($new_value){
			$this->limit = $new_value;
			return $this;
		}
		public function setFreq($new_value){
			$this->frequency = $new_value;
			return $this;
		}
		public function setPriority($new_value){
			$this->priority = $new_value;
			return $this;
		}


		private function clearControllerDirectory(){
			$path = fx_path("{$this->params->site_map_root_path}/{$this->controller_name}");
			if(is_dir($path)){
				foreach(scandir($path) as $file){
					if($file == '.' || $file == '..'){ continue; }
					unlink("{$path}/{$file}");
				}
			}
			return $this;
		}

		private function setIterator(){
			$this->total_items = $this->model->countData($this->table,$this->order_field,$this->where_query);
			$this->iterations = ceil($this->total_items/$this->limit);
			return $this;
		}

		private function setFileSuffix(){
			if($this->iterations > 1){
				$this->file_suffix = "_" . $this->offset;
			}
			return $this;
		}

		private function makeXMLFile(){
			$items = $this->model->getData(
				$this->table,$this->selectable_fields,$this->where_query,$this->limit,$this->offset,$this->order_field
			);
			if($items){
				foreach($items as $key=>$item){
					$items[$key] = array(
						'loc'			=> $this->site_link . fx_get_url($this->controller_name,'item',$item[$this->selectable_fields['id']]),
						'lastmod'		=> date('c',
							(
								$item[$this->selectable_fields['updated']] ?
								$item[$this->selectable_fields['updated']] :
								$item[$this->selectable_fields['created']]
							)
						),
						'changefreq'	=> $this->frequency,
						'priority'		=> $this->priority,
					);
				}
				$this->makeFile($items);
			}
			return $this;
		}

		private function makeFile(array $file_data){
			$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . PHP_EOL;
			$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">" . PHP_EOL;
			$xml .= fx_xml_encode($file_data,'   ','','url');
			$xml .= "</urlset>";
			return $this->saveFile($xml);
		}

		private function saveFile($xml_data){
			$xml_file = "{$this->params->site_map_root_path}/{$this->controller_name}/sitemap{$this->file_suffix}.xml";
			$xml_path = fx_path($xml_file);
			fx_make_dir(dirname($xml_path));
			file_put_contents($xml_path,$xml_data);
			return $this;
		}







	}















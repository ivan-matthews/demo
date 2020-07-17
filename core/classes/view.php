<?php

	namespace Core\Classes;

	class View{

		private static $instance;

		private static $js_files=array();
		private static $css_files=array();

		private $site_host_is;
		private $error_status = false;

		private $render_type = 'renderHtmlData';
		private $desired_types = array();
		private $web_dir;
		private $site_theme;
		private $site_dir;
		private $data;
		private $errors;
		private $debug;
		private $content;

		public $site_root;
		public $theme_path;

		private $response;
		private $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$web_dir = fx_get_web_dir_name();
			$this->config = Config::getInstance();
			$this->response = Response::getInstance();
			$this->web_dir = fx_path($web_dir);
			$this->site_theme = $this->config->view['site_theme'];
			$this->theme_path = "/view/{$this->site_theme}";
			$this->site_dir = "{$this->web_dir}/view/{$this->site_theme}";
			$this->site_root = $web_dir;
			$this->setSiteHost($this->config->view['tpl_files_host']);
		}

		public function setRenderType($render_header){
			if(!is_string($render_header)){ $render_header = ''; }
			preg_match_all("#([a-z]+)\/([a-z]+)#",$render_header,$this->desired_types);
			if(isset($this->desired_types[2][0])){
				$render_method_type = "render{$this->desired_types[2][0]}Data";
				if(method_exists($this,$render_method_type)){
					$this->render_type = $render_method_type;
				}
			}
			return $this;
		}

		public function ready(){
			$this->setData()
				->setErrors()
				->setDebug();
			return $this;
		}

		private function setData(){
			$this->data = $this->response->getData();
			return $this;
		}
		private function setErrors(){
			$this->errors = $this->response->getErrors();
			return $this;
		}
		private function setDebug(){
			$this->debug = $this->response->getDebug();
			return $this;
		}

		public function renderErrorPages(){
			$response_code = $this->response->getResponseCode();
			if(file_exists("{$this->site_dir}/assets/errors/{$response_code}.html.php")){
				print $this->render("{$this->site_dir}/assets/errors/{$response_code}.html.php",array());
				$this->error_status = true;
			}
			return $this;
		}

		public function renderController(){
			if($this->error_status){ return $this; }
			foreach($this->data['controller'] as $controller_name=>$controller_value){
				foreach($controller_value as $action_name=>$action_value){
					$tmp_file_path = "{$this->site_dir}/controllers/{$controller_name}/actions/{$action_name}.html.php";
					if(file_exists($tmp_file_path)){
						$this->content .= $this->render($tmp_file_path,$action_value);
					}
				}
			}
			return $this;
		}

		public function render($file_path,array $data){
			ob_start();
			extract($data);
			include $file_path;
			return ob_get_clean();
		}

		public function includeHomePage(){
			$home_page = "{$this->site_dir}/main.html.php";
			return include $home_page;
		}

		public function getSiteDir(){
			return $this->site_dir;
		}

		public function start(){
			return call_user_func(array($this,$this->render_type));
		}

		private function renderPlainData(){
			$this->response->setHeader('Content-Type','text/plain');
			$this->response->sendHeaders();
			$this->renderErrorPages();
			$this->renderController();
			$this->includeHomePage();
			return $this;
		}

		private function renderHtmlData(){
			$this->response->setHeader('Content-Type','text/html');
			$this->response->sendHeaders();
			$this->renderErrorPages();
			$this->renderController();
			$this->includeHomePage();
			return $this;
		}

		private function renderJsonData(){
			$this->response->setHeader('Content-Type','application/json');
			$this->response->sendHeaders();
			print json_encode($this->data);
			return die();
		}

		private function renderXmlData(){
			$this->response->setHeader('Content-Type','application/xml');
			$this->response->sendHeaders();
/*			$result = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
			$result .= '<root>' . PHP_EOL;
			$result .= fx_xml_encode($this->data);
			$result .= '</root>';*/
			print fx_array2xml($this->data);
			return die();
		}

		private function renderPhpData(){
			$this->response->setHeader('Content-Type','text/plain');
			$this->response->sendHeaders();
			$result = fx_php_encode($this->data);
			print_r($result);
			print '?>';
			return die();
		}

		public static function addJS($js_file_path,$version=null){
			$extension = $version ? "js?v={$version}" : "js";
			$js_file_path = trim($js_file_path,'/');
			$js_file_path = "{$js_file_path}.{$extension}";
			self::$js_files[] = $js_file_path;
			return true;
		}

		public static function appendJS($js_file_path,$version=null){
			$extension = $version ? "js?v={$version}" : "js";
			$js_file_path = trim($js_file_path,'/');
			$js_file_path = "{$js_file_path}.{$extension}";
			array_unshift(self::$js_files,$js_file_path);
			return true;
		}

		public static function prependJS($js_file_path,$version=null){
			$extension = $version ? "js?v={$version}" : "js";
			$js_file_path = trim($js_file_path,'/');
			$js_file_path = "{$js_file_path}.{$extension}";
			array_push(self::$js_files,$js_file_path);
			return true;
		}

		public static function addCSS($css_file_path,$version=null){
			$extension = $version ? "css?v={$version}" : "css";
			$css_file_path = trim($css_file_path,'/');
			$css_file_path = "{$css_file_path}.{$extension}";
			self::$css_files[] = $css_file_path;
			return true;
		}

		public static function appendCSS($css_file_path,$version=null){
			$extension = $version ? "css?v={$version}" : "css";
			$css_file_path = trim($css_file_path,'/');
			$css_file_path = "{$css_file_path}.{$extension}";
			array_unshift(self::$css_files,$css_file_path);
			return true;
		}

		public static function prependCSS($css_file_path,$version=null){
			$extension = $version ? "css?v={$version}" : "css";
			$css_file_path = trim($css_file_path,'/');
			$css_file_path = "{$css_file_path}.{$extension}";
			array_push(self::$css_files,$css_file_path);
			return true;
		}

		public function renderJsFiles(){
			foreach(self::$js_files as $file){
				$file_path = $this->site_host_is ? "{$this->site_root}/{$file}" : "/{$this->site_root}/{$file}";
				print "\t\t<script src=\"{$file_path}\"></script>" . PHP_EOL;
			}
			return $this;
		}

		public function renderCssFiles(){
			foreach(self::$css_files as $file){
				$file_path = $this->site_host_is ? "{$this->site_root}/{$file}" : "/{$this->site_root}/{$file}";
				print "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"{$file_path}\">" . PHP_EOL;
			}
			return $this;
		}

		public function setSiteHost($site_host = null){
			if($site_host){
				$this->site_host_is = true;
				$this->site_root = "{$site_host}/{$this->site_root}";
			}
			return $this;
		}

		public function isContent(){
			if(!empty($this->content)){
				return true;
			}
			return false;
		}

		public function printContent(){
			return print $this->content;
		}

		public function printTitle(){
			$titles = $this->data['title'];
			$titles = array_reverse($titles);
			print "<title>";
			print implode($this->config->view['title_delimiter'],$titles);
			print "</title>";
			return $this;
		}















	}














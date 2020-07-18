<?php

	namespace Core\Classes;

	use Core\Classes\Interfaces\View as ViewInterface;
	use Core\Classes\Response\Response;

	/**
	 * Class View
	 * @package Core\Classes
	 * @method static View _addJS($js_file_path,$version=null)
	 * @method static View _appendJS($js_file_path,$version=null)
	 * @method static View _prependJS($js_file_path,$version=null)
	 * @method static View _addCSS($css_file_path,$version=null)
	 * @method static View _appendCSS($css_file_path,$version=null)
	 * @method static View _prependCSS($css_file_path,$version=null)
	 */
	class View implements ViewInterface{

		private static $instance;

		private static $js_files=array();
		private static $css_files=array();

		public $site_host_is;
		public $error_status = false;

		public $render_type = 'renderHtmlData';
		public $desired_types = array();
		public $web_dir;
		public $site_theme;
		public $site_dir;
		public $data;
		public $errors;
		public $debug;
		public $content;

		public $site_root;
		public $theme_path;

		public $response;
		public $config;
		public $request;

		public $submit_button;

		/**
		 * @return ViewInterface
		 */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public static function __callStatic($function_name, $arguments){
			$function_name = trim($function_name,'_');
			$self_object = self::getInstance();
			if(method_exists($self_object,$function_name)){
				call_user_func(array($self_object,$function_name),...$arguments);
			}
			return $self_object;
		}

		public function __construct(){
			$web_dir = fx_get_web_dir_name();
			$this->config = Config::getInstance();
			$this->response = Response::getInstance();
			$this->request =  Request::getInstance();

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
				$this->content = $this->render("{$this->site_dir}/assets/errors/{$response_code}.html.php",array());
				$this->error_status = $response_code;
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

		public function path($path){
			return "{$this->site_dir}/{$path}";
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
			print json_encode($this->data,JSON_PRETTY_PRINT);
			return true;
		}

		private function renderXmlData(){
			$this->response->setHeader('Content-Type','application/xml');
			$this->response->sendHeaders();
/*			$result = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
			$result .= '<root>' . PHP_EOL;
			$result .= fx_xml_encode($this->data);
			$result .= '</root>';*/
			print fx_array2xml($this->data);
			return true;
		}

		private function renderPhpData(){
			$this->response->setHeader('Content-Type','text/plain');
			$this->response->sendHeaders();
			$result = fx_php_encode($this->data);
			print_r($result);
			print '?>';
			return true;
		}

		public function addJS($js_file_path,$version=null){
			$key = $js_file_path;
			$extension = $version ? "js?v={$version}" : "js";
			$js_file_path = trim($js_file_path,'/');
			$js_file_path = "{$js_file_path}.{$extension}";
			self::$js_files[$key] = $js_file_path;
			return true;
		}

		public function appendJS($js_file_path,$version=null){
			$extension = $version ? "js?v={$version}" : "js";
			$js_file_path = trim($js_file_path,'/');
			$js_file_path = "{$js_file_path}.{$extension}";
			array_unshift(self::$js_files,$js_file_path);
			return true;
		}

		public function prependJS($js_file_path,$version=null){
			$extension = $version ? "js?v={$version}" : "js";
			$js_file_path = trim($js_file_path,'/');
			$js_file_path = "{$js_file_path}.{$extension}";
			array_push(self::$js_files,$js_file_path);
			return true;
		}

		public function addCSS($css_file_path,$version=null){
			$key = $css_file_path;
			$extension = $version ? "css?v={$version}" : "css";
			$css_file_path = trim($css_file_path,'/');
			$css_file_path = "{$css_file_path}.{$extension}";
			self::$css_files[$key] = $css_file_path;
			return true;
		}

		public function appendCSS($css_file_path,$version=null){
			$extension = $version ? "css?v={$version}" : "css";
			$css_file_path = trim($css_file_path,'/');
			$css_file_path = "{$css_file_path}.{$extension}";
			array_unshift(self::$css_files,$css_file_path);
			return true;
		}

		public function prependCSS($css_file_path,$version=null){
			$extension = $version ? "css?v={$version}" : "css";
			$css_file_path = trim($css_file_path,'/');
			$css_file_path = "{$css_file_path}.{$extension}";
			array_push(self::$css_files,$css_file_path);
			return true;
		}

		public function renderJsFiles(){
			$js_files = '';
			foreach(self::$js_files as $key=>$file){
				$file_path = $this->site_host_is ? "{$this->site_root}/{$file}" : "/{$this->site_root}/{$file}";
				$js_files .= "\t\t<script src=\"{$file_path}\"></script>" . PHP_EOL;
				unset(self::$js_files[$key]);
			}
			print $js_files;
			return $this;
		}

		public function renderCssFiles(){
			$css_files = '';
			foreach(self::$css_files as $key=>$file){
				$file_path = $this->site_host_is ? "{$this->site_root}/{$file}" : "/{$this->site_root}/{$file}";
				$css_files .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"{$file_path}\">" . PHP_EOL;
				unset(self::$css_files[$key]);
			}
			print $css_files;
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

		public function renderEmptyPage(){
			print $this->render($this->path('assets/empty_page.html.php'),array());
		}

		public function printTitle(){
			if($this->error_status){
				$this->data['title'] = array(fx_lang('home.error_head') . ' ' . $this->error_status);
			}
			$titles = $this->data['title'];
			$titles = array_diff(array_reverse($titles),array(''));
			print "<title>";
			print implode($this->config->view['title_delimiter'],$titles);
			print "</title>" . PHP_EOL;
			return $this;
		}

		public function widget($widget_position){
			if(isset($this->data['widgets'][$widget_position])){
				foreach($this->data['widgets'][$widget_position] as $widget){
					$widget_tmp_file = "{$this->site_dir}/{$widget['params']['template']}_{$widget['params']['position']}.html.php";
					if(file_exists($widget_tmp_file)){
						print $this->render($widget_tmp_file,array(
							'content'	=> $widget['data'],
							'options'	=> $widget['params']
						));
					}
				}
			}
			return $this;
		}

		public function printMeta(){
			$meta_tags = '';
			foreach($this->data['meta'] as $meta_key=>$meta_tag){
				$meta_tags .= "\t\t<meta";
				foreach($meta_tag as $key=>$tag){
					$meta_tags .= " {$key}=\"{$tag}\"";
				}
				$meta_tags .= ">" . PHP_EOL;
			}
			print $meta_tags;
			return $this;
		}

		public function printFavicon(){
			$this->data['favicon'] = $this->getUploadSiteRoot($this->data['favicon']);
			print "<link rel=\"icon\" href=\"{$this->data['favicon']}\" type=\"image/x-icon\" />" . PHP_EOL;
			print "<link rel=\"shortcut icon\" href=\"{$this->data['favicon']}\" type=\"image/x-icon\" />" . PHP_EOL;
			return $this;
		}

		public function getUploadSiteRoot($upload_pth_to_file){
			$upload_pth_to_file = trim($upload_pth_to_file,'/');
			$upload_pth_to_file = "{$this->config->view['uploads_dir']}/{$upload_pth_to_file}";
			return "/{$this->site_root}/{$upload_pth_to_file}";
		}

		public function getUploadDir($upload_pth_to_file){
			$upload_pth_to_file = trim($upload_pth_to_file,'/');
			$upload_pth_to_file = "{$this->config->view['uploads_dir']}/{$upload_pth_to_file}";
			return "{$this->site_dir}/{$upload_pth_to_file}";
		}

		public function printUploadSiteRoot($upload_pth_to_file){
			return print $this->getUploadSiteRoot($upload_pth_to_file);
		}

		public function renderForm($form_data,$form_file='assets/form'){
			$form_path = $this->path("{$form_file}.html.php");
			return $this->render($form_path,$form_data);
		}

		public function renderField($fields_data,$field_file='assets/fields/form/simple'){
			$field_path = $this->path("{$field_file}.html.php");
			return $this->render($field_path,$fields_data);
		}

		public function getAttributesStringFromArray(array $attributes_array){
			$attributes_string = '';
			foreach($attributes_array as $attribute_key=>$attribute_value){
				if(!$attribute_value || is_array($attribute_value)){ continue; }
				$attributes_string .= "{$attribute_key}=\"{$attribute_value}\" ";
			}
			return trim($attributes_string);
		}

		public function prepareFormFieldsToFieldSets(array $fields_array){
			$new_fields_array = array();
			foreach($fields_array as $key=>$value){
				$new_fields_array[$value['attributes']['params']['field_sets']][$key] = $value;
			}
			return $new_fields_array;
		}








	}















<?php

	namespace Core\Classes;

	class Language{

		private static $instance;

		private $language_folder = 'system/language';

		private $lang_key;
		private $language_keys = array();
		private $server_language_header;

		private $language=array();

		private $session;
		private $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->language[$key])){
				return $this->language[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->language[$name] = $value;
			return $this->language[$name];
		}

		public function __construct(){
			$this->session = Session::getInstance();
			$this->config = Config::getInstance();
			$this->language_folder = fx_path($this->language_folder);
		}

		public function __destruct(){

		}

		public function getLanguage(){
			return $this->language;
		}

		public function setLanguage(){
			if(!isset($this->language_keys[$this->lang_key])){
				$this->setLanguageArray();
			}
			return $this->language;
		}

		private function setLanguageArray(){
			$this->language_keys[$this->lang_key] = true;
			$language_folder_path = "{$this->language_folder}/{$this->lang_key}";
			$this->language = fx_load_array($language_folder_path);
			return $this->setCustomLangFiles();
		}

		private function setCustomLangFiles(){
			$controller_folder = fx_path('core/controllers');
			foreach(scandir($controller_folder) as $file){
				if($file == '.' || $file == '..'){ continue; }
				$lang_file = "{$controller_folder}/{$file}/config/lang.php";
				if(is_readable($lang_file)){
					$this->language[$file] = fx_import_file($lang_file,Kernel::IMPORT_INCLUDE_ONCE);
				}
			}
			return $this;
		}

		public function setServerLanguageHeader($language_header){
			if(!is_string($language_header)){ $language_header = ''; }
			$this->server_language_header = $language_header;
			return $this;
		}

		public function setVerifiedLangKey($language_key){
			$this->lang_key = $language_key;
			return $this;
		}

		public function setDefaultLanguageKey(){
			$this->setVerifiedLangKey($this->config->core['site_language']);
			return $this;
		}

		public function setLanguageKey(){
			if(($language_key = $this->session->get('a_lang',Session::PREFIX_AUTH))){
				return $this->setVerifiedLangKey($language_key);
			}
			return $this->parseServerLanguageHeader();
		}

		private function checkDesiredLanguage(){
			$language_folder_path = "{$this->language_folder}/{$this->lang_key}";
			if(!is_readable($language_folder_path)){
				$this->setDefaultLanguageKey();
			}
			return $this->lang_key;
		}

		private function parseServerLanguageHeader(){
			$this->lang_key = strtolower(substr($this->server_language_header,0,2));
			return $this->checkDesiredLanguage();
		}

		public function getLanguageKey(){
			return $this->lang_key;
		}

		public function prepareLanguageData($language_value,array $data_to_replace){
			if($data_to_replace){
				$data_keys = array_keys($data_to_replace);
				$data_values = array_values($data_to_replace);
				return str_replace($data_keys,$data_values,$language_value);
			}
			return $language_value;
		}

















	}















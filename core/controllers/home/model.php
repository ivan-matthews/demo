<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Model as ParentModel;
	use Core\Classes\Cache\Interfaces\Cache;

	class Model extends ParentModel{

		/** @var $this */
		private static $instance;

		/** @var Cache */
		protected $cache;

		/** @return $this */
		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			parent::__construct();
		}

		public function getActiveWidgetsList(){
			$widgets_list = array();
			$controller_folder = fx_path('core/controllers');
			foreach(scandir($controller_folder) as $controller){
				if($controller == '.' || $controller == '..'){ continue; }
				$widgets_file = "{$controller_folder}/{$controller}/config/widgets.php";
				if(is_readable($widgets_file)){
					$widgets_list[] = fx_import_file($widgets_file);
				}
			}
			return $widgets_list;
		}







	}















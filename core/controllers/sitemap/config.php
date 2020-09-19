<?php

	namespace Core\Controllers\Sitemap;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Sitemap
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property string $site_map_root_path
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'sitemap';

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



















	}















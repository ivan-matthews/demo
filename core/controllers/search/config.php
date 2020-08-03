<?php

	namespace Core\Controllers\Search;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Search
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property array $header_bar
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'search';

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















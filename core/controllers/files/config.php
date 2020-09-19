<?php

	namespace Core\Controllers\Files;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Files
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'files';

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















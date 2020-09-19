<?php

	namespace Core\Controllers\Home;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Home
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property boolean $just_widgets
	 * @property array $another_controller
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'home';

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















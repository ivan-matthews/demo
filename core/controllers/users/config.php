<?php

	namespace Core\Controllers\Users;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Users
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property array $sorting_panel
	 * @property array $ordering
	 * @property array $header_bar_user_edit
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'users';

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















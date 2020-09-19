<?php

	namespace Core\Controllers\Auth;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Auth
	 * @property boolean $status
	 * @property string $controller_name
	 * @property string $groups_after_registration
	 * @property string $groups_after_verification
	 * @property array $controller
	 * @property array $actions
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'auth';

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















<?php

	namespace Core\Controllers\Comments;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Comments
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property array $allowed_controllers
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'comments';

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















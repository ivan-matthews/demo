<?php

	namespace Core\Controllers\Audios;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Audios
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property array $sorting_panel
	 * @property boolean $enable_comments
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'audios';

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















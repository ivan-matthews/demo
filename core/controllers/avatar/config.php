<?php

	namespace Core\Controllers\Avatar;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Avatar
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property array $image_params
	 * @property array $file_types
	 * @property integer $file_size
	 * @property array $sorting_panel
	 * @property integer $image_quality
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'avatar';

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















<?php

	namespace Core\Controllers\Feedback;

	use Core\Classes\Params;

	/**
	 * Class Config
	 * @package Core\Controllers\Feedback
	 * @property boolean $status
	 * @property string $controller_name
	 * @property array $controller
	 * @property array $actions
	 * @property string|null $resend_email
	 * @property array $contact_info
	 * @property string|null $contacts_title
	 * @property string|null $contacts_footer
	 * @property array $sorting_panel
	 */
	class Config extends Params{

		/** @var $this */
		private static $instance;

		protected $current_controller = 'feedback';

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















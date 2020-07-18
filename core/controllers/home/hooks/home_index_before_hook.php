<?php

	namespace Core\Controllers\Home\Hooks;

	use Core\Classes\Kernel;
	use Core\Classes\Request;
	use Core\Controllers\Home\Actions\Index;

	class Home_Index_Before_Hook{

		private $request;
		private $action_object;

		public function __construct(){
			$this->request = Request::getInstance();
			$this->action_object = Index::getInstance();
		}

		public function run(){
			$this->action_object->config->status = Kernel::STATUS_INACTIVE;	// это не работает, юзаем хук controller_run_before_hook
			return false;
		}

	}















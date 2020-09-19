<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Action{

		/**
		 * @param $controller
		 * @param $action
		 * @param array ...$params
		 * @return Content
		 */
		public function action($controller=null,$action=null,...$params);
	}
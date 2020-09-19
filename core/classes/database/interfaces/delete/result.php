<?php

	namespace Core\Classes\Database\Interfaces\Delete;

	interface Result{
//		/**
//		 * @return resource
//		 */
//		public function exec();

		/**
		 * @return boolean
		 */
		public function rows();
	}
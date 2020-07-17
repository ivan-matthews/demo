<?php

	namespace Core\Database\Interfaces\Delete;

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
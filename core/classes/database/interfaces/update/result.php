<?php

	namespace Core\Classes\Database\Interfaces\Update;

	interface Result{
//		public function exec();
		/**
		 * @return integer
		 */
		public function rows();
	}
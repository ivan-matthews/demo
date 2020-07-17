<?php

	namespace Core\Database\Interfaces\Update;

	interface Result{
//		public function exec();
		/**
		 * @return integer
		 */
		public function rows();
	}
<?php

	namespace Core\Database\Interfaces\Insert;

	interface Insert{
		/**
		 * @param $field
		 * @param $value
		 * @return Actions | Update
		 */
		public function value($field,$value);
	}
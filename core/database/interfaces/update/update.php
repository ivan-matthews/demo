<?php

	namespace Core\Database\Interfaces\Update;

	interface Update{
		/**
		 * @param $field
		 * @param $value
		 * @return Actions
		 */
		public function field($field,$value);
	}
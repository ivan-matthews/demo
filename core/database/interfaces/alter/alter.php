<?php

	namespace Core\Database\Interfaces\Alter;

	interface Alter{
		/**
		 * @param $field
		 * @return Actions
		 */
		public function field($field);

		/**
		 * @return resource
		 */
		public function exec();
	}
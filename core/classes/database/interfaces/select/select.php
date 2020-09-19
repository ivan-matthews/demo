<?php

	namespace Core\Classes\Database\Interfaces\Select;

	interface Select{
		/**
		 * @param array ...$table
		 * @return Actions
		 */
		public function from(...$table);
	}
<?php

	namespace Core\Database\Interfaces\Select;

	interface Select{
		/**
		 * @param array ...$table
		 * @return Actions
		 */
		public function from(...$table);
	}
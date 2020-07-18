<?php

	namespace Core\Classes\Database\Interfaces\Select;

	interface Sorting{

		/**
		 * @param string $sorting
		 * @return Actions
		 */
		public function sort($sorting='ASC');
	}
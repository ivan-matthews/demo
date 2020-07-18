<?php

	namespace Core\Classes\Database\Interfaces\Update;

	interface Sorting{

		/**
		 * @param string $sorting
		 * @return Actions
		 */
		public function sort($sorting='ASC');
	}
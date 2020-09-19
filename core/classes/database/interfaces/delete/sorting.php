<?php

	namespace Core\Classes\Database\Interfaces\Delete;

	interface Sorting{

		/**
		 * @param string $sorting
		 * @return Delete
		 */
		public function sort($sorting='ASC');
	}
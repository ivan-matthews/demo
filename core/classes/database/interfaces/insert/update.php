<?php

	namespace Core\Classes\Database\Interfaces\Insert;

	interface Update{
		/**
		 * @param $field
		 * @param $query
		 * @return Update
		 */
		public function updateQuery($field,$query);

		/**
		 * @param $key
		 * @param $value
		 * @return Update
		 */
		public function data($key,$value);

		/**
		 * @param $field
		 * @param $value
		 * @return Update
		 */
		public function update($field,$value);

		/**
		 * @return Result
		 */
		public function get();
	}
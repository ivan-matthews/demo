<?php

	namespace Core\Classes\Database\Interfaces\Insert;

	interface Actions{
		/**
		 * @param $field
		 * @param $value
		 * @return Actions | Update
		 */
		public function value($field,$value);

		/**
		 * @param $field
		 * @param $query
		 * @return Actions | Update
		 */
		public function query($field,$query);

		/**
		 * @param $key
		 * @param $value
		 * @return Actions | Update
		 */
		public function data($key,$value);

		/**
		 * @param array $preparing_data
		 * @return Actions | Update
		 */
		public function prepare(array $preparing_data);
		/**
		 * @return Result
		 */
		public function get();
	}
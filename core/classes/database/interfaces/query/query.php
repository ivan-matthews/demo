<?php

	namespace Core\Classes\Database\Interfaces\Query;

	interface Query{
		/**
		 * @param $key
		 * @param $value
		 * @return Query
		 */
		public function data($key,$value);

		/**
		 * @param array $preparing_data
		 * @return Query
		 */
		public function prepare(array $preparing_data);
		/**
		 * @return Result
		 */
		public function get();
	}
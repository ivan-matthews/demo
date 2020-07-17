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
		 * @return Result
		 */
		public function get();
	}
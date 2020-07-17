<?php

	namespace Core\Classes\Database\Interfaces\Update;

	interface Actions{

		/**
		 * @param $query
		 * @return Update | Actions
		 */
		public function where($query);

		/**
		 * @param $field
		 * @param $nested_query
		 * @return Update | Actions
		 */
		public function query($field,$nested_query);

		/**
		 * @param int $limit
		 * @return Update | Actions
		 */
		public function limit($limit=1);

		/**
		 * @param $table
		 * @param $query
		 * @param string $type
		 * @return Update | Actions
		 */
		public function join($table,$query,$type='LEFT');

		/**
		 * @param int $offset
		 * @return Update | Actions
		 */
		public function offset($offset=0);

		/**
		 * @param $key
		 * @param $value
		 * @return Update | Actions
		 */
		public function data($key,$value);

		/**
		 * @return Result
		 */
		public function get();

	}
<?php

	namespace Core\Classes\Database\Interfaces\Select;

	interface Actions{

		/**
		 * @param $query
		 * @return Actions
		 */
		public function where($query);

		/**
		 * @param $table
		 * @param $query
		 * @param string $type
		 * @return Actions
		 */
		public function join($table,$query,$type='LEFT');

		/**
		 * @param $nested_query
		 * @return Actions
		 */
		public function query($nested_query);

		/**
		 * @param $key
		 * @param $value
		 * @return Actions
		 */
		public function data($key,$value);

		/**
		 * @param array $preparing_data
		 * @return Actions
		 */
		public function prepare(array $preparing_data);
		/**
		 * @param int $offset
		 * @return Actions
		 */
		public function limit($offset=1);

		/**
		 * @param int $limit
		 * @return Actions
		 */
		public function offset($limit=0);

		/**
		 * @param array ...$order
		 * @return Sorting
		 */
		public function order(...$order);

		/**
		 * @param array ...$group
		 * @return Actions
		 */
		public function group(...$group);

		/**
		 * @return Result
		 */
		public function get();

//		/**
//		 * @return string
//		 */
//		public function sql();
	}
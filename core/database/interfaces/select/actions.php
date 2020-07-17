<?php

	namespace Core\Database\Interfaces\Select;

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
		 * @param int $limit
		 * @return Offset
		 */
		public function limit($limit=1);

		/**
		 * @param array ...$order
		 * @return Actions
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
	}
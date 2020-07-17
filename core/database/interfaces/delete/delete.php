<?php

	namespace Core\Database\Interfaces\Delete;

	interface Delete{
		/**
		 * @param $query
		 * @return Delete
		 */
		public function where($query);

		/**
		 * @param array ...$tables
		 * @return Delete
		 */
		public function using(...$tables);

		/**
		 * @param $nested_query
		 * @return Delete
		 */
		public function query($nested_query);

		/**
		 * @param $key
		 * @param $value
		 * @return Delete
		 */
		public function data($key,$value);

		/**
		 * @param int $limit
		 * @return Delete
		 */
		public function limit($limit=1);

		/**
		 * @param array ...$order
		 * @return Delete
		 */
		public function order(...$order);

		/**
		 * @param array ...$group
		 * @return Delete
		 */
		public function group(...$group);

		/**
		 * @return Result
		 */
		public function get();
	}
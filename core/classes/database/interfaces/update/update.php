<?php

	namespace Core\Classes\Database\Interfaces\Update;

	interface Update{
		/**
		 * @param $field
		 * @param $value
		 * @return Actions | Update
		 */
		public function field($field,$value);
		
		/**
		 * @param $field
		 * @param $nested_query
		 * @return Update | Actions
		 */
		public function query($field,$nested_query);
	}
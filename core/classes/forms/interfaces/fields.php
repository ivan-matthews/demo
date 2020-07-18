<?php

	namespace Core\Classes\Forms\Interfaces;

	interface Fields{
		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function text($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function switch($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function checkbox($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function hidden($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function radio($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function select($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function submit($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function email($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function password($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function file($field_name,$callback);

		/**
		 * @param $field_name
		 * @param $callback
		 * @return Param
		 */
		public function photo($field_name,$callback);
	}















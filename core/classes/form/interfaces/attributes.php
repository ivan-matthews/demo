<?php

	namespace Core\Classes\Form\Interfaces;

	interface Attributes{
		/**
		 * @param $default
		 * @return Attributes
		 */
		public function autocomplete($default);
		/**
		 * @param $default
		 * @return Attributes
		 */
		public function class($default);

		/**
		 * @param $default
		 * @return Attributes
		 */
		public function description($default);

		/**
		 * @param $default
		 * @return Attributes
		 */
		public function placeholder($default);

		/**
		 * @param $default
		 * @return Attributes
		 */
		public function label($default);

		/**
		 * @param $default
		 * @return Attributes
		 */
		public function title($default);

		/**
		 * @param $default
		 * @return Attributes
		 */
		public function id($default);

		/**
		 * @param $default
		 * @return Attributes
		 */
		public function type($default);

		/**
		 * @param string|array $data
		 * @param null $value
		 * @return Attributes
		 */
		public function data($data,$value=null);

		/**
		 * @param null $callback_function
		 * @return Checkers
		 */
		public function check($callback_function=null);

		/**
		 * @param $attribute_key
		 * @param $attribute_value
		 * @return Attributes
		 */
		public function setAttribute($attribute_key,$attribute_value);

		/**
		 * @param callable $callable_or_array
		 * @param array $extensions
		 * @return Attributes
		 */
		public function files($callable_or_array,$extensions = array());

		/**
		 * @param $callback_or_array
		 * @return Attributes
		 */
		public function params($callback_or_array);
	}
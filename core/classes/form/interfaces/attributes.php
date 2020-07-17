<?php

	namespace Core\Classes\Form\Interfaces;

	interface Attributes{
		/**
		 * @param $default
		 * @return Attributes
		 */
		public function class($default);

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
		 * @param $default
		 * @return Attributes
		 */
		public function field_type($default);

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
		 * @param $value
		 * @return Attributes
		 */
		public function value($value);

		/**
		 * @param callable $callable_callback_function
		 * @return Attributes
		 */
		public function file(callable $callable_callback_function);
	}
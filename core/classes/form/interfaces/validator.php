<?php

	namespace Core\Classes\Form\Interfaces;

	interface Validator{

		/**
		 * @return array
		 */
		public function getFormAttributes();
		/**
		 * @param array $attributes
		 * @return Validator
		 */
		public function setDefaultFieldsAttributes(array $attributes);
		/**
		 * @param bool $status
		 * @return Validator
		 */
		public function validate($status=true);
		/**
		 * @param $error_data_value
		 * @param $key
		 * @return Validator
		 */
		public function setError($error_data_value,$key=null);

		/**
		 * @return Validator
		 */
		public function getErrors();

		/**
		 * @return Validator
		 */
		public function getFieldsList();

		/**
		 * @return Validator
		 */
		public function can();

		/**
		 * @param $data_array
		 * @return Validator
		 */
		public function setData($data_array);

		/**
		 * @param bool $check_status
		 * @return Validator
		 */
		public function csrf($check_status = true);

		/**
		 * @param $value
		 * @return Validator
		 */
		public function getValue($value);

		/**
		 * @param $field
		 * @return Preparing | Value
		 */
		public function field($field);

		/**
		 * @param $callback
		 * @return Validator
		 */
		public function form($callback);

		/**
		 * @param $field_name
		 * @param string $attribute_key
		 * @return Validator
		 */
		public function getAttribute($field_name,$attribute_key='value');

		/**
		 * @param $attribute_key
		 * @param $attribute_value
		 * @return Validator
		 */
		public function setParams($attribute_key,$attribute_value);
	}

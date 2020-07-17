<?php

	namespace Core\Classes\Form\Interfaces;

	interface Validator{
		/**
		 * @param array $attributes
		 * @return Validator
		 */
		public function setDefaultFieldsAttributes(array $attributes);
		/**
		 * @param $form_name
		 * @return Validator
		 */
		public function setFormName($form_name);
		/**
		 * @param bool $status
		 * @return Validator
		 */
		public function validate($status=true);
		/**
		 * @param $error_data_value
		 * @return Validator
		 */
		public function setError($error_data_value);

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
		 * @return Attributes
		 */
		public function name($field);

		/**
		 * @param $field_name
		 * @param string $attribute_key
		 * @return Validator
		 */
		public function getAttribute($field_name,$attribute_key='value');
	}
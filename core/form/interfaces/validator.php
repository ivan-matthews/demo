<?php

	namespace Core\Form\Interfaces;

	interface Validator{
		/**
		 * @param $form_name
		 * @return Validator
		 */
		public function setFormName($form_name);
		/**
		 * @param bool $status
		 * @return Validator
		 */
		public function runFieldsValidation($status=true);
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
		 * @return Validator
		 */
		public function checkCSRF();

		/**
		 * @return Validator
		 */
		public function nonCheckCSRF();

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
	}
<?php

	namespace Core\Classes\Forms\Interfaces;

	interface Field{

		/**
		 * @param $callback
		 * @return Field
		 */
		public function form($callback);

		/**
		 * @param $array_fields
		 * @return Field
		 */
		public function setFormFieldsFromFiedsArray($array_fields);

		/**
		 * @param $data_array
		 * @return Field
		 */
		public function setData($data_array);

		/**
		 * @param $name
		 * @return Field
		 */
		public function setField($name);

		/**
		 * @param $error
		 * @return Field
		 */
		public function setError($error);

		/**
		 * @param $status
		 * @return Field
		 */
		public function validation($status);

		/**
		 * @return Field
		 */
		public function csrf();

		/**
		 * @return Field
		 */
		public function getForm();

		/**
		 * @return Field
		 */
		public function getFields();

		/**
		 * @return Field
		 */
		public function granted();

		/**
		 * @return Field
		 */
		public function denied();

		/**
		 * @return Field
		 */
		public function captcha();
	}

	interface Param{
		/**
		 * @param $callback
		 * @return Check
		 */
		public function params($callback);
	}

	interface Check{
		/**
		 * @param $callback
		 * @return mixed
		 */
		public function check($callback);
	}















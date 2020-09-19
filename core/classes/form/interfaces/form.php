<?php

	namespace Core\Classes\Form\Interfaces;

	interface Form{
		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormCharset($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormAction($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormAutoComplete($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormEnctype($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormMethod($value);

		/**
		 * @param $form_name
		 * @return Form
		 */
		public function setFormName($form_name);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormValidation($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormRel($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormTarget($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormClass($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormId($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function setFormTitle($value);

		/**
		 * @param $key
		 * @param $value
		 * @return Form
		 */
		public function setForm($key,$value);
	}
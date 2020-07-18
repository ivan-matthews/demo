<?php

	namespace Core\Classes\Forms\Interfaces;

	interface Form{
		/**
		 * @param $value
		 * @return Form
		 */
		public function form_charset($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_action($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_autocomplete($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_enctype($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_method($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_name($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_novalidate($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_rel($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_target($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_class($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_id($value);

		/**
		 * @param $value
		 * @return Form
		 */
		public function form_title($value);
	}















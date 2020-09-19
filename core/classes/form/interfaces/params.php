<?php

	namespace Core\Classes\Form\Interfaces;

	interface Params{
		/**
		 * @param $value
		 * @return Params
		 */
		public function show_in_form($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function show_in_item($value);

		/**
		 * @param array $value
		 * @return Params
		 */
		public function variants(array $value);

		/**
		 * @param $default
		 * @return Params
		 */
		public function default_value($default);
		/**
		 * @param $value
		 * @return Params
		 */
		public function show_in_filter($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function field_sets($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function form_position($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function item_position($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function filter_validation($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function filter_position($value);

		/**
		 * @param string $value
		 * @return Params
		 */
		public function field_sets_field_class($value);

//		/**
//		 * @param $value
//		 * @return Params
//		 */
//		public function filter_query($value);
		/**
		 * @param $value
		 * @return Params
		 */
		public function render_type($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function show_label_in_form($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function show_title_in_form($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function show_validation($value);

		/**
		 * @param $default
		 * @return Params
		 */
		public function field_type($default);

		/**
		 * @param string $default
		 * @return Params
		 */
		public function wysiwyg($default='tinymce');
	}
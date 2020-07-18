<?php

	namespace Core\Classes\Forms\Interfaces;

	interface Params{
		/**
		 * @param $value
		 * @return Params
		 */
		public function param_show_in_form($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_show_in_item($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_show_in_filter($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_show_label_in_form($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_show_title_in_form($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_show_validation($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_field_sets($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_field_sets_field_class($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_form_position($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_filter_position($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_item_position($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_render_type($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_field_type($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_label($value);

		/**
		 * @param $value
		 * @return Params
		 */
		public function param_description($value);
	}















<?php

	namespace Core\Classes\Forms\Interfaces;

	interface Attributes{
		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_autocomplete($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_placeholder($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_required($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_readonly($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_title($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_class($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_name($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_type($value);

		/**
		 * @param string $value
		 * @return Attributes
		 */
		public function field_value($value='');

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_min($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_max($value);

		/**
		 * @param $value
		 * @return Attributes
		 */
		public function field_id($value);
	}















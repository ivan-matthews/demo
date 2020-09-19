<?php

	namespace Core\Classes\Form\Interfaces;

	interface Files{
		/**
		 * @param int $default
		 * @return Files
		 */
		public function max_size($default);

		/**
		 * @param $default
		 * @return Files
		 */
		public function min_size($default);

		/**
		 * @param $file_type
		 * @param array $subtypes
		 * @return Files
		 */
		public function accept($file_type,$subtypes=array());
	}
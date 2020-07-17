<?php

	namespace Core\Console\Interfaces;

	interface Types{
		/**
		 * @param array $array
		 * @param string $glue
		 * @return Paint|Printer
		 */
		public function arr(array $array,$glue='');

		/**
		 * @param $string
		 * @return Paint|Printer
		 */
		public function string($string);

		/**
		 * @param int $repeating
		 * @return Types
		 */
		public function eol($repeating=1);

		/**
		 * @param int $repeating
		 * @return Types
		 */
		public function tab($repeating=1);
	}
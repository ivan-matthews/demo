<?php

	namespace Core\Classes\Console\Interfaces;

	interface Close{

		/**
		 * @param int $repeating
		 * @return Close
		 */
		public function eol($repeating=1);

		/**
		 * @param int $repeating
		 * @return Close
		 */
		public function space($repeating=1);

		/**
		 * @param int $repeating
		 * @return Close
		 */
		public function tab($repeating=1);
	}
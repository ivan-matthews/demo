<?php

	namespace Core\Classes\Console\Interfaces;

	interface Printer{
		/**
		 * @return Close
		 */
		public function get();

		/**
		 * @return Close
		 */
		public function print();
	}
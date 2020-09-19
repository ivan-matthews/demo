<?php

	namespace Core\Classes\Database\Interfaces\Create;

	interface Indexes{
		/**
		 * @param bool $key
		 * @return bool
		 */
		public function primary($key=false);

		/**
		 * @param bool $key
		 * @return bool
		 */
		public function unique($key=false);

		/**
		 * @param bool $key
		 * @return bool
		 */
		public function index($key=false);

		/**
		 * @param bool $key
		 * @return bool
		 */
		public function fullText($key=false);
	}
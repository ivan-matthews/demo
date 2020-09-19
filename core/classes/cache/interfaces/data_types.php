<?php

	namespace Core\Classes\Cache\Interfaces;

	interface Data_Types{
		/**
		 * @return object
		 */
		public function object();

		/**
		 * @return array
		 */
		public function array();
	}
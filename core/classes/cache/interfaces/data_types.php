<?php

	namespace Core\Classes\Cache\Interfaces;

	interface Data_Types{
		/**
		 * @return Cache
		 */
		public function object();

		/**
		 * @return Cache
		 */
		public function array();
	}
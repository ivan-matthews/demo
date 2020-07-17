<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Notice{
		/**
		 * @param $lang_key
		 * @return Receiver
		 */
		public function theme($lang_key);
	}
<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Notice{
		/**
		 * @param $lang_key
		 * @param array $replace_data
		 * @return Receiver
		 */
		public function theme($lang_key,$replace_data=array());
	}
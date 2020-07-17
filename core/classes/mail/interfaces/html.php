<?php

	namespace Core\Classes\Mail\Interfaces;

	interface HTML{
		/**
		 * @param $data_key
		 * @param $data_value
		 * @return Send
		 */
		public function data($data_key,$data_value);
	}
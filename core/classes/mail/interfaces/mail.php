<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Mail{
		/**
		 * @param $message_theme
		 * @return Address
		 */
		public function subject($message_theme);
	}
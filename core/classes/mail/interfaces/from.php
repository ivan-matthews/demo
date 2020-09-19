<?php

	namespace Core\Classes\Mail\Interfaces;

	interface From{
		/**
		 * @param $email_address
		 * @param $email_user_name
		 * @return Subject
		 */
		public function from($email_address,$email_user_name);
	}
<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Address{
		/**
		 * @param $email
		 * @param bool $name
		 * @return Subject | From
		 */
		public function to($email,$name=false);
	}
<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Address{
		/**
		 * @param $email
		 * @param bool $name
		 * @return Subject | From
		 */
		public function address($email,$name=false);
	}
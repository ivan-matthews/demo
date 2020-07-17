<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Send_Notice{
		/**
		 * @return boolean
		 */
		public function send();
	}
<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Receiver{

		/**
		 * @param $receiver_id
		 * @return Content
		 */
		public function receiver($receiver_id);

		/**
		 * @param null $sender_id
		 * @return Receiver
		 */
		public function sender($sender_id=null);
	}
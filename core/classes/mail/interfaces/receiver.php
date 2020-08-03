<?php

	namespace Core\Classes\Mail\Interfaces;

	use Core\Classes\Mail\Notice;

	interface Receiver{

		/**
		 * @param $receiver_id
		 * @return Action | Receiver
		 */
		public function receiver($receiver_id);

		/**
		 * @param null $sender_id
		 * @return Action | Receiver
		 */
		public function sender($sender_id=null);

		/**
		 * @param int $manager_id
		 * @return Action | Receiver
		 */
		public function manager($manager_id=Notice::MANAGER_SYSTEM);
	}
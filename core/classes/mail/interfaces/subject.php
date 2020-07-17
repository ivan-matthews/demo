<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Subject{
		/**
		 * @param $email_reply_to
		 * @param $name_reply_to
		 * @return Subject
		 */
		public function reply($email_reply_to,$name_reply_to);

		/**
		 * @param array $custom_headers
		 * @return Subject
		 */
		public function headers($custom_headers=array());

		/**
		 * @param array $attachments_headers
		 * @return Subject
		 */
		public function attachments($attachments_headers=array());

		/**
		 * @param $message
		 * @return Send
		 */
		public function text($message);

		/**
		 * @param $file
		 * @param $data array
		 * @return Send
		 */
		public function html($file,array $data);
	}
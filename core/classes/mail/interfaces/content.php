<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Content{

		/**
		 * @param $lang_key
		 * @return Send_Notice
		 */
		public function content($lang_key);

		/**
		 * @param array $attachments
		 * @return Content
		 */
		public function attachments(array $attachments);

		/**
		 * @param $options
		 * @return Content
		 */
		public function options($options);

		/**
		 * @param int $status
		 * @return Content
		 */
		public function status($status);
	}
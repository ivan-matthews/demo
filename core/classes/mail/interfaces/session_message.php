<?php

	namespace Core\Classes\Mail\Interfaces;

	interface Session_Message{
		/**
		 * @param $value
		 * @return Value
		 */
		public function head($value);
	}

	interface Value{
		/**
		 * @param $value
		 * @return Other
		 */
		public function value($value);

		/**
		 * @param array $array_data
		 * @return Other | Value
		 */
		public function setArray(array $array_data);
	}

	interface Other{
		/**
		 * @param $value
		 * @return Other
		 */
		public function unlink_link($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function original_key($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function preview_image($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function removable($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function icon_class($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function icon_block_class($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function message_class($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function header_class($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function value_class($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function date_created($value);

		/**
		 * @param $value
		 * @return Other
		 */
		public function expired_time($value);

		/**
		 * @param $controller
		 * @param $actions
		 * @return Other
		 */
		public function disabled_pages($controller,...$actions);

		/**
		 * @param $controller
		 * @param $actions
		 * @return Other
		 */
		public function enabled_pages($controller,...$actions);

		/**
		 * @param $groups_list
		 * @return Other
		 */
		public function disabled_groups(...$groups_list);

		/**
		 * @param $groups_list
		 * @return Other
		 */
		public function enabled_groups(...$groups_list);

		/**
		 * @return boolean
		 */
		public function send();
	}
<?php

	namespace Core\Classes\Database\Interfaces\Create;

	interface Defaults{
		/**
		 * @return Defaults|Indexes
		 */
		public function notNull();

		/**
		 * @return Defaults|Indexes
		 */
		public function currentTimestamp();

		/**
		 * @return Defaults|Indexes
		 */
		public function nullable();

		/**
		 * @return Defaults|Indexes
		 */
		public function autoIncrement();

		/**
		 * @param $comment
		 * @return Defaults|Indexes
		 */
		public function comment($comment);

		/**
		 * @param $defaults
		 * @return Defaults|Indexes
		 */
		public function defaults($defaults);

		/**
		 * @return Defaults|Indexes
		 */
		public function unsigned();

		/**
		 * @return Defaults|Indexes
		 */
		public function bin();

		/**
		 * @return Defaults|Indexes
		 */
		public function zerofill();

		/**
		 * @param string $character
		 * @param string $collate
		 * @return Defaults|Indexes
		 */
		public function character($character="utf8mb4",$collate="utf8mb4_unicode_ci");
	}
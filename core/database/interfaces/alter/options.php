<?php

	namespace Core\Database\Interfaces\Alter;

	interface Options{
		/** @return Options|Indexes */
		public function notNull();
		/** @return Options|Indexes */
		public function currentTimestamp();
		/** @return Options|Indexes */
		public function nullable();
		/** @return Options|Indexes */
		public function autoIncrement();

		/**
		 * @param $comment
		 * @return Options|Indexes
		 */
		public function comment($comment);

		/**
		 * @param $defaults
		 * @return Options|Indexes
		 */
		public function defaults($defaults);
		/** @return Options|Indexes */
		public function unsigned();
		/** @return Options|Indexes */
		public function bin();
		/** @return Options|Indexes */
		public function zerofill();
	}
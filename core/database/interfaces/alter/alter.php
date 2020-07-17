<?php

	namespace Core\Database\Interfaces\Alter;

	interface Alter{
		/** @return Actions */
		public function field($field);
		/** @return bool */
		public function exec();
	}
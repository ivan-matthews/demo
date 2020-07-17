<?php

	namespace Core\Database\Interfaces\Alter;

	interface Actions{
		/** @return Types */
		public function addColumn();
		public function dropColumn();

		/**
		 * @param $new_name
		 * @return Types
		 */
		public function changeColumn($new_name);
		/** @return Types */
		public function modifyColumn();
		/** @return Types */
		public function dropAutoIncrement();
		/** @return Types */
		public function addAutoIncrement();

	}
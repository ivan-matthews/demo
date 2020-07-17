<?php

	namespace Core\Database\Interfaces\Delete;

	interface Offset{
		/**
		 * @param int $offset
		 * @return Delete | Result
		 */
		public function offset($offset=0);
	}
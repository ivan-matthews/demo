<?php

	namespace Core\Database\Interfaces\Select;

	interface Offset{
		/**
		 * @param int $offset
		 * @return Actions | Result
		 */
		public function offset($offset=0);
	}
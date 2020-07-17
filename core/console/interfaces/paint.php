<?php

	namespace Core\Console\Interfaces;

	interface Paint{
		/**
		 * @return Printer|Paint
		 * @param $color
		 */
		public function color($color);
		/** @return Printer|Paint*/
		public function fon($fon);
	}
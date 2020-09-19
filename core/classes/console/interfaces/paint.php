<?php

	namespace Core\Classes\Console\Interfaces;

	interface Paint{
		/**
		 * @return Printer|Paint
		 * @param $color
		 */
		public function color($color);

		/**
		 * @param $fon
		 * @return Printer|Paint
		 */
		public function fon($fon);
	}
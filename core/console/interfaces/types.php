<?php

	namespace Core\Console\Interfaces;

	interface Types{
		/** @return Paint|Printer*/
		public function arr(array $array);
		/** @return Paint|Printer*/
		public function string($string);
		/** @return Types*/
		public function eol($repeating=1);
		/** @return Types*/
		public function tab($repeating=1);
	}
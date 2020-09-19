<?php

	namespace Core\Classes\Form\Interfaces;

	interface Checkers{
		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function required($default=true);
		
		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function readonly($default=true);

		/**
		 * @param int $default
		 * @return Checkers
		 */
		public function min($default=6);

		/**
		 * @param int $default
		 * @return Checkers
		 */
		public function max($default=16);

		/**
		 * @param int $default
		 * @return Checkers
		 */
		public function html_min($default=6);

		/**
		 * @param int $default
		 * @return Checkers
		 */
		public function html_max($default=16);

		/**
		 * @param string $default
		 * @return Checkers
		 */
		public function mask($default="a-zA-Z0-9");

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function email($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function phone($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function boolean($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function domain($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function float($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function int($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function ip($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function mac($default=true);

		/**
		 * @param $default
		 * @return Checkers
		 */
		public function regexp($default);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function url($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function lower_letters($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function upper_letters($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function numeric($default=true);

		/**
		 * @param string $default
		 * @return Checkers
		 */
		public function symbols($default="!\@\#$\%\^\&\*\(\)\_\+\=\-\\]\[\~\`\|\}\{\'\:\"\;\?\/\.\,\<\>");

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function lower_cyrillic($default=true);

		/**
		 * @param bool $default
		 * @return Checkers
		 */
		public function upper_cyrillic($default=true);
	}
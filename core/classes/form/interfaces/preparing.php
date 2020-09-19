<?php

	namespace Core\Classes\Form\Interfaces;

	interface Preparing{
		/**
		 * @return Attributes
		 */
		public function dont_prepare();

		/**
		 * @param callable $callback_function
		 * @return Attributes
		 */
		public function prepare(callable $callback_function=null);

		/**
		 * @param bool $prepare
		 * @return Attributes
		 */
		public function jevix($prepare = true);

		/**
		 * @param null $quote_style
		 * @param null $charset
		 * @param bool $double_encode
		 * @return Attributes
		 */
		public function htmlentities($quote_style=null,$charset=null,$double_encode=true);

		/**
		 * @param int $flags
		 * @param string $encoding
		 * @param bool $double_encode
		 * @return Attributes
		 */
		public function htmlspecialchars($flags=ENT_COMPAT,$encoding="UTF-8",$double_encode=true);
	}
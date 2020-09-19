<?php

	namespace Core\Classes\Form\Interfaces;

	interface Multiple{

		/**
		 * @return Files
		 */
		public function multiple();

		/**
		 * @return Files
		 */
		public function single();
	}
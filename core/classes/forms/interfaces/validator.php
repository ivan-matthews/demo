<?php

	namespace Core\Classes\Forms\Interfaces;

	interface Validator{
		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_required($default);

		/**
		 * @param int $default
		 * @return Validator
		 */
		public function validator_min($default=6);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_max($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_email($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_password($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_numeric($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_int($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_ip($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_mac($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_boolean($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_domain($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_float($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_regexp($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_url($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_lower($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_upper($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_symbols($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_lower_cyr($default);

		/**
		 * @param $default
		 * @return Validator
		 */
		public function validator_upper_cyr($default);
	}















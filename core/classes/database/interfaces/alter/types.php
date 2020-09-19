<?php

	namespace Core\Classes\Database\Interfaces\Alter;

	interface Types{
		/**
		 * @param int $long
		 * @return Options
		 */
		public function char($long=4);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function varchar($long=191);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function tinytext($long=null);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function text($long=255);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function mediumtext($long=null);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function largetext($long=255);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function longtext($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function boolean($long=null);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function tinyint($long=11);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function smallint($long=11);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function mediumint($long=11);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function int($long=11);

		/**
		 * @param int $long
		 * @return Options
		 */
		public function bigint($long=11);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function decimal($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function float($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function double($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function date($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function time($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function datetime($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function timestamp($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function year($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function enum($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function set($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function tinyblob($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function blob($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function mediumblob($long=null);

		/**
		 * @param null $long
		 * @return Options
		 */
		public function longblob($long=null);
	}
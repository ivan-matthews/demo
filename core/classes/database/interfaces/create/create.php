<?php

	namespace Core\Classes\Database\Interfaces\Create;

	interface Create{
		/** @return bool */
		public function exec();

		/**
		 * @param $engine
		 * @return Engine
		 */
		public function engine($engine);

		/**
		 * @return bool
		 * @param string $fields_prefix
		 */
		public function add_timestamps($fields_prefix);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function char($field,$long=4);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function varchar($field,$long=191);

		/**
		 * @param $field
		 * @param null $long
		 * @return Defaults
		 */
		public function tinytext($field,$long=null);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function text($field,$long=255);

		/**
		 * @param $field
		 * @param null $long
		 * @return Defaults
		 */
		public function mediumtext($field,$long=null);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function largetext($field,$long=255);

		/**
		 * @param $field
		 * @param null $long
		 * @return Defaults
		 */
		public function longtext($field,$long=null);

		/**
		 * @param $field
		 * @param null $long
		 * @return Defaults
		 */
		public function boolean($field,$long=null);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function tinyint($field,$long=11);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function smallint($field,$long=11);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function mediumint($field,$long=11);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function int($field,$long=11);

		/**
		 * @param $field
		 * @param int $long
		 * @return Defaults
		 */
		public function bigint($field,$long=255);

		/**
		 * @param $field
		 * @param int $start
		 * @param int $end
		 * @return Defaults
		 */
		public function decimal($field,$start=5,$end=2);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function float($field);

		/**
		 * @param $field
		 * @param int $start
		 * @param int $end
		 * @return Defaults
		 */
		public function double($field,$start=15,$end=8);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function date($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function time($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function datetime($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function timestamp($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function year($field);

		/**
		 * @param $field
		 * @param array $array
		 * @return Defaults
		 */
		public function enum($field,$array=array());

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function set($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function tinyblob($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function blob($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function mediumblob($field);

		/**
		 * @param $field
		 * @return Defaults
		 */
		public function longblob($field);
	}
<?php

	namespace Core\Database\Interfaces\Alter;

	interface Types{
		/** @return Options */
		public function char($long=4);
		/** @return Options */
		public function varchar($long=191);
		/** @return Options */
		public function tinytext($long=null);
		/** @return Options */
		public function text($long=255);
		/** @return Options */
		public function mediumtext($long=null);
		/** @return Options */
		public function largetext($long=255);
		/** @return Options */
		public function longtext($long=null);
		/** @return Options */
		public function boolean($long=null);
		/** @return Options */
		public function tinyint($long=11);
		/** @return Options */
		public function smallint($long=11);
		/** @return Options */
		public function mediumint($long=11);
		/** @return Options */
		public function int($long=11);
		/** @return Options */
		public function bigint($long=11);
		/** @return Options */
		public function decimal($long=null);
		/** @return Options */
		public function float($long=null);
		/** @return Options */
		public function double($long=null);
		/** @return Options */
		public function date($long=null);
		/** @return Options */
		public function time($long=null);
		/** @return Options */
		public function datetime($long=null);
		/** @return Options */
		public function timestamp($long=null);
		/** @return Options */
		public function year($long=null);
		/** @return Options */
		public function enum($long=null);
		/** @return Options */
		public function set($long=null);
		/** @return Options */
		public function tinyblob($long=null);
		/** @return Options */
		public function blob($long=null);
		/** @return Options */
		public function mediumblob($long=null);
		/** @return Options */
		public function longblob($long=null);
	}
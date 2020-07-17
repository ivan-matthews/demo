<?php

	namespace Core\Database\Interfaces\Query;

	interface Result{
//		public function exec();
		/**
		 * @param int $resulttype
		 * @return array
		 */
		public function all($resulttype=MYSQLI_ASSOC);

		/**
		 * @return array
		 */
		public function allAsArray();

		/**
		 * @return array
		 */
		public function allAsObject();

		/**
		 * @return array
		 */
		public function itemAsArray();

		/**
		 * @return object
		 */
		public function itemAsObject();

		/**
		 * @return integer
		 */
		public function rows();

		/**
		 * @return integer
		 */
		public function id();
	}
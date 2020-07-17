<?php

	namespace Core\Database\Interfaces\Select;

	interface Result{
//		/**
//		 * @return resource
//		 */
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
		 * @return object
		 */
		public function allAsObject();

		/**
		 * @return array
		 */
		public function itemAsArray();

		/**
		 * @return array
		 */
		public function itemAsObject();

	}
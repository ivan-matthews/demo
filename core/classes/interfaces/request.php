<?php

	namespace Core\Classes\Interfaces;

	interface Request{
		/**
		 * @param $method
		 * @return Request
		 */
		public function setRequestMethod($method);

		/**
		 * @return Request
		 */
		public function getRequestMethod();

		/**
		 * @param $data
		 * @return Request
		 */
		public function setRequestedData($data);

		/**
		 * @param $key
		 * @return string
		 */
		public function get($key);

		/**
		 * @param $key
		 * @return array
		 */
		public function getArray($key);

		/**
		 * @return array
		 */
		public function getAll();

		/**
		 * @param $key
		 * @return Request
		 */
		public function unset($key);

		/**
		 * @param $key
		 * @param $value
		 * @return Request
		 */
		public function set($key,$value);
	}
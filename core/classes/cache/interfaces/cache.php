<?php

	namespace Core\Classes\Cache\Interfaces;

	interface Cache{
		/**
		 * @param $data
		 * @return Cache
		 */
		public function set($data);

		/**
		 * @return Cache
		 */
		public function clear();

		/**
		 * @param null $key
		 * @return Cache
		 */
		public function key($key=null);

		/**
		 * @param $index
		 * @return Cache
		 */
		public function index($index);

		/**
		 * @param $ttl
		 * @return Cache
		 */
		public function ttl($ttl);

		/**
		 * @return Cache
		 */
		public function drop();

		/**
		 * @param $mark
		 * @return Cache
		 */
		public function mark($mark);

		/**
		 * @return Data_Types
		 */
		public function get();
	}
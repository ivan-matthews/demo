<?php

	namespace Core\Classes\Interfaces;

	interface Hooks{
		/**
		 * @param $hook_name
		 * @param array ...$arguments_list
		 * @return mixed
		 */
		public function run($hook_name,...$arguments_list);

		/**
		 * @param $hook_name
		 * @param array ...$arguments_list
		 * @return mixed
		 */
		public function before($hook_name,...$arguments_list);

		/**
		 * @param $hook_name
		 * @param array ...$arguments_list
		 * @return mixed
		 */
		public function instead($hook_name,...$arguments_list);

		/**
		 * @param $hook_name
		 * @param array ...$arguments_list
		 * @return mixed
		 */
		public function after($hook_name,...$arguments_list);

		/**
		 * @return array
		 */
		public function getHooksArray();

		/**
		 * @return array
		 */
		public function getHooks();
	}
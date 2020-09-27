<?php

	namespace Core\Hooks;

	/**
	 * Выполняется, когда на сайт пришел пользователь без сессионной Куки
	 *
	 * Class New_User_Hook
	 * @package Core\Hooks
	 */
	class New_User_Hook{

		public function __construct(){

		}

		public function run(){
			return false;
		}

	}















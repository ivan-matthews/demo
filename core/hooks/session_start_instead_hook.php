<?php

	namespace Core\Hooks;

	class Session_Start_Instead_Hook{

		public function __construct(){

		}

		public function run(){
			return true;
		}

	}
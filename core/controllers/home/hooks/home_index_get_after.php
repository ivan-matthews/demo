<?php

	namespace Core\Controllers\Home\Hooks;

	class Home_Index_Get_After{

		public function run($test_value=null){
			return "hook \"" . __METHOD__ . "\" say: {$test_value} change... chunge...";
		}

	}
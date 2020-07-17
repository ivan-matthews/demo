<?php

	namespace System\Cron_Tasks\Home;

	class Test{

		/**
		 * @param $params 'cron_task' item array from DB
		 * @return string | boolean
		 */
		public function execute($params){
//			fx_pre($params);
			sleep(2);

			$response = array(
				__METHOD__,		// successful with message '__METHOD__'
				true,			// successful
				false,			// successful with empty response
				null,			// successful with empty response
			);

			return $response[rand(0,3)];
		}

















	}















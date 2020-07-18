<?php

	namespace System\Cron_Tasks\Users;

	use Core\Classes\Database\Database;
	use Core\Classes\Config;

	class Update_Bot{

		protected $config;
		protected $params;

		public function __construct(){
			$this->config = Config::getInstance();
		}

		/**
		 * @param $params 'cron_task' item array from DB
		 * @return string | boolean
		 */
		public function execute($params){
			$this->params = $params;
			$time = $this->config->session['online_time'];

			$updated_rows = Database::update('users')
				->query('u_date_log',"floor(unix_timestamp()-rand()*30+{$time})")
				->where("`u_user_type`='2'")
				->order("rand()")
				->sort('ASC')
				->limit(rand(10,30))
				->get()
				->rows();

			return $updated_rows;
		}

















	}















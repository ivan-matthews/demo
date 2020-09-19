<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;
	use Core\Classes\Kernel;

	class InsertUserGroups202005240845261590349526{

		private $user_groups = array(
			'guest','user','editor','moder','admin'
		);

		public function firstStep(){
			$time = time();
			$database = Database::insert('user_groups');
			foreach($this->user_groups as $key=>$group){
				$database = $database->value('ug_name',$group);
				$database->value('ug_status',1);
				$database->value('ug_date_created',$time);
				$database->value('ug_default',(fx_equal($key,0) ? Kernel::STATUS_ACTIVE : Kernel::STATUS_INACTIVE));
			}
			$database->get();
			return $this;
		}











	}
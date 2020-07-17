<?php

	namespace System\Inserts;

	use Core\Classes\Database;
	use Core\Classes\Kernel;

	class InsertUserGroups202005240845261590349526{

		private $user_groups = array(
			'guest','user','editor','moder','admin'
		);

		public function firstStep(){
			$database = Database::insert('user_groups');
			foreach($this->user_groups as $key=>$group){
				$database->value('name',$group);
				$database->value('status',1);
				$database->value('default',(fx_equal($key,0) ? Kernel::STATUS_ACTIVE : Kernel::STATUS_INACTIVE));
			}
			$database->exec();
			return $this;
		}











	}
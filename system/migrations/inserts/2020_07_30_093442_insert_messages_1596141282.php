<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;

	class InsertMessages202007300934421596141282{

		public $demo_data_string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		public $demo_data_array = array();

		public function firstStep(){
			$this->getDemoDataArray();

			for($i=0;$i<250;$i++){
				$sender		= rand(1,5);
				$receiver	= rand(1,5);

				if(!Database::select()
					->from('messages_contacts')
					->where("mc_sender_id={$sender} and mc_user_id={$receiver}")
					->get()
					->itemAsArray()){
					Database::insert('messages_contacts')
						->value('mc_sender_id',$sender)
						->value('mc_user_id',$receiver)
						->value('mc_date_created',time())
						->update('mc_date_created',time())
						->get()
						->id();
				}

				$message_id = Database::insert('messages')
					->value('m_content',$this->demo_data_array[rand(0,7)])
					->query('m_contact_id',"(select mc_id from messages_contacts where mc_sender_id={$sender} and mc_user_id={$receiver})")
					->value('m_date_created',time()+$i*100)
					->get()
					->id();
				Database::update('messages_contacts')
					->field('mc_last_message_id',$message_id)
					->where("(mc_sender_id={$sender} and mc_user_id={$receiver}) or (mc_user_id={$sender} and mc_sender_id={$receiver})")
					->get()
					->rows();
			}
			return $this;
		}

		private function getDemoDataArray(){
			$this->demo_data_array = preg_split("#[^a-z +]{1,3}#si",$this->demo_data_string);
			return $this;
		}










	}
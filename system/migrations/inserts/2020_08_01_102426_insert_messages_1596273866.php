<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Config;
	use Core\Classes\Database\Database;

	class InsertMessages202008011024261596273866{

		public $demo_data_string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		public $demo_data_array = array();

		public function firstStep(){
			$this->getDemoDataArray();

			$config = Config::getInstance();
			$config->set(false,'core','debug_enabled');

			for($i=0;$i<100;$i++){
				$sender_id = rand(1,5);
				$receiver_id = rand(1,5);

				$contact_id = $this->getContactId($sender_id,$receiver_id);

				$message_id = Database::insert('messages')
					->value('m_contact_id',$contact_id)
					->value('m_sender_id',$sender_id)
					->value('m_receiver_id',$receiver_id)
					->value('m_content',$this->demo_data_array[rand(0,7)])
					->value('m_date_created',time()+$i*10)
					->get()
					->id();

				$this->updateLastMessageId($contact_id,$sender_id,$message_id);

				unset($sender_id,$receiver_id,$contact_id,$message_id);
			}
		}

		private function getDemoDataArray(){
			$this->demo_data_array = preg_split("#[^a-z +]{1,3}#si",$this->demo_data_string);
			return $this;
		}

		private function updateLastMessageId($contact_id,$sender_id,$message_id){
			return Database::update('messages_contacts')
				->field('mc_last_message_id',$message_id)
				->query('mc_sender_total',"if(mc_sender_id=$sender_id,mc_sender_total,mc_sender_total+1)")
				->query('mc_receiver_total',"if(mc_receiver_id=$sender_id,mc_receiver_total,mc_receiver_total+1)")
				->where("mc_id={$contact_id}")
				->get()
				->rows();
		}

		private function getContactId($sender_id,$receiver_id){
			$contact = Database::select('mc_id')
				->from('messages_contacts')
				->where("(mc_sender_id={$sender_id} and mc_receiver_id={$receiver_id}) or (mc_sender_id={$receiver_id} and mc_receiver_id={$sender_id})")
				->get()
				->itemAsArray();
			if($contact){
				return $contact['mc_id'];
			}
			return Database::insert('messages_contacts')
				->value('mc_sender_id',$sender_id)
				->value('mc_receiver_id',$receiver_id)
				->value('mc_date_created',time())
				->get()
				->id();
		}









	}
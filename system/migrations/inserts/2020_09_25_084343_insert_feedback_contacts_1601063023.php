<?php

	namespace System\Migrations\Inserts;

	use Core\Classes\Database\Database;	

	class InsertFeedbackContacts202009250843431601063023{

		private $data = array(
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),

			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
			array(
				'street'	=> 'Soborny st',
				'house'		=> 21,
				'apartment'	=> 120,
			),
		);

		public function firstStep(){
			$database = Database::insert('feedback_contacts');
			foreach($this->data as $index=>$value){
				$database = $database->value('fc_operator_id',$index+1);
				$database = $database->value('fc_street',$value['street']);
				$database = $database->value('fc_house',$value['house']);
				$database = $database->value('fc_apartments',$value['apartment']);
			}
			$database->get()->id();
			return $this;
		}











	}
<?php

	namespace Core\Controllers\Users\Widgets;

	use Core\Classes\Kernel;
	use Core\Controllers\Users\Model;

	class Online_Users{

		public $params;
		public $users_model;
		public $users_items;
		public $users_fields = array();

		public $query = '';
		public $limit = 18;
		public $offset = 0;
		public $order = 'u_date_log';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->users_model = Model::getInstance();
		}

		public function run(){
			$this->setUserFields();
			$this->getUsersItems();
			return $this->users_items;
		}

		public function getUsersItems(){
			$this->query .= "u_status = " . Kernel::STATUS_ACTIVE;
			$this->query .= " AND `u_date_log`>" . time();
			$this->users_items = $this->users_model->getAllUsers(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort,array()
			);
			return $this;
		}

		public function setUserFields(){
			$this->users_fields = $this->users_model->users_index_fields;
			$this->users_model->users_index_fields[] = 'p_medium';
			return $this;
		}










	}
<?php

	namespace Core\Controllers\Audios\Widgets;

	use Core\Classes\Kernel;
	use Core\Controllers\Audios\Model;

	class Audios{

		public $params;
		public $audios_model;
		public $audios_items;

		public $query = '';
		public $limit = 10;
		public $offset = 0;
		public $order = 'au_id';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->audios_model = Model::getInstance();
		}

		public function run(){
			$this->getAudiosItems();
			return $this->audios_items;
		}

		public function getAudiosItems(){
			$this->query .= "au_status = " . Kernel::STATUS_ACTIVE;
			$this->audios_items = $this->audios_model->getAudios(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort,array()
			);
			return $this;
		}










	}
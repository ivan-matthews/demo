<?php

	namespace Core\Controllers\Photos\Widgets;

	use Core\Classes\Kernel;
	use Core\Controllers\Photos\Model;

	class Photos{

		public $params;
		public $photos_model;
		public $photos_items;

		public $query = '';
		public $limit = 10;
		public $offset = 0;
		public $order = 'p_id';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->photos_model = Model::getInstance();
		}

		public function run(){
			$this->getPhotosItems();
			return $this->photos_items;
		}

		public function getPhotosItems(){
			$this->query .= "p_status = " . Kernel::STATUS_ACTIVE;
			$this->photos_items = $this->photos_model->getPhotos(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort,array()
			);
			return $this;
		}










	}
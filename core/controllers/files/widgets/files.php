<?php

	namespace Core\Controllers\Files\Widgets;

	use Core\Classes\Kernel;
	use Core\Controllers\Files\Model;

	class Files{

		public $params;
		public $files_model;
		public $files_items;

		public $query = '';
		public $limit = 10;
		public $offset = 0;
		public $order = 'f_id';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->files_model = Model::getInstance();
		}

		public function run(){
			$this->getFilesItems();
			return $this->files_items;
		}

		public function getFilesItems(){
			$this->query .= "f_status = " . Kernel::STATUS_ACTIVE;
			$this->files_items = $this->files_model->getFiles(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort,array()
			);
			return $this;
		}










	}
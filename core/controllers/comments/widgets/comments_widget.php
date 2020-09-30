<?php

	namespace Core\Controllers\Comments\Widgets;


	use Core\Classes\Kernel;
	use Core\Controllers\Comments\Model;

	class Comments_Widget{

		public $params;
		public $comment_model;
		public $comment_items;

		public $query = '';
		public $limit = 10;
		public $offset = 0;
		public $order = 'b_id';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->comment_model = Model::getInstance();
		}

		public function run(){
			$this->getBlogItems();
			return $this->comment_items;
		}

		public function getBlogItems(){
			$this->query .= "`b_status`=" . Kernel::STATUS_ACTIVE;
			$this->query .= " AND `b_public`=1";
			$this->comment_items = $this->comment_model->getLastComments($this->limit,$this->offset);
			return $this;
		}











	}
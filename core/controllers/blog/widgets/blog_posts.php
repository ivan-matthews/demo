<?php

	namespace Core\Controllers\Blog\Widgets;

	use Core\Classes\Kernel;
	use Core\Controllers\Blog\Model;

	class Blog_Posts{

		public $params;
		public $blog_model;
		public $blog_items;

		public $query = '';
		public $limit = 10;
		public $offset = 0;
		public $order = 'b_id';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->blog_model = Model::getInstance();
		}

		public function run(){
			$this->getBlogItems();
			return $this->blog_items;
		}

		public function getBlogItems(){
			$this->query .= "`b_status`=" . Kernel::STATUS_ACTIVE;
			$this->query .= " AND `b_public`=1";
			$this->blog_items = $this->blog_model->getAllPosts(
				$this->query,$this->limit,$this->offset,$this->order,$this->sort,array()
			);
			return $this;
		}










	}
<?php

	namespace Core\Controllers\News\Widgets;

	use Core\Classes\Kernel;
	use Core\Controllers\News\Model;

	class News_Slider{

		public $params;
		public $news_model;
		public $news_items;

		public $query = '';
		public $limit = 5;
		public $offset = 0;
		public $order = 'nw_id';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->news_model = Model::getInstance();
		}

		public function run(){
			$this->getNewsItems();
			return $this->news_items;
		}

		public function getNewsItems(){
			$this->query .= "`nw_status`=" . Kernel::STATUS_ACTIVE;
			$this->query .= " AND `nw_public`=1";
			$this->news_items = $this->news_model->getAllPosts(
				$this->query,$this->limit,$this->offset,$this->order,$this->sort,array()
			);
			return $this;
		}










	}
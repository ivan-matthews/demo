<?php

	namespace Core\Controllers\Videos\Widgets;

	use Core\Classes\Kernel;
	use Core\Controllers\Videos\Model;

	class Videos{

		public $params;
		public $videos_model;
		public $videos_items;

		public $query = '';
		public $limit = 10;
		public $offset = 0;
		public $order = 'v_id';
		public $sort = 'DESC';

		public function __construct($params_list){
			$this->params = $params_list;
			$this->videos_model = Model::getInstance();
		}

		public function run(){
			$this->getVideosItems();
			return $this->videos_items;
		}

		public function getVideosItems(){
			$this->query .= "v_status = " . Kernel::STATUS_ACTIVE;
			$this->videos_items = $this->videos_model->getVideos(
				$this->limit,$this->offset,$this->query,$this->order,$this->sort,array()
			);
			return $this;
		}










	}
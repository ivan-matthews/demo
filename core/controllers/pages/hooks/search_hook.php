<?php

	namespace Core\Controllers\Pages\Hooks;

	use Core\Controllers\Search\Actions\Index as SearchAction;
	use Core\Controllers\Pages\Model as Model;

	class Search_Hook{

		private $pages_model;
		private $search_action;
		private $current_controller;

		public function __construct(){
			$this->search_action = SearchAction::getInstance();
			$this->pages_model = Model::getInstance();
			$this->current_controller = $this->search_action->current_controller;
		}

		public function run(){
			$this->search_action->total = $this->pages_model->countFind($this->search_action->search_query);
			if(fx_equal($this->current_controller,'pages') && $this->search_action->total){
				$this->search_action->search_result = $this->pages_model->find(
					$this->search_action->search_query,
					$this->search_action->limit,
					$this->search_action->offset
				);
				$this->prepareResult();
			}
			$this->setHeaderBar();
			return $this->search_action->total_finds['pages'] = $this->search_action->total;
		}

		private function setHeaderBar(){
			$this->search_action->header_bar['pages'] = array(
				'title'	=> 'pages.find_by_pages_table_head',
				'link'	=> array(),
				'total'	=> $this->search_action->total,
			);
			return $this;
		}

		private function prepareResult(){
			foreach($this->search_action->search_result as $key=>$value){
				$this->search_action->search_result[$key]['date'] = fx_get_date($this->search_action->search_result[$key]['date']);
				$this->search_action->search_result[$key]['image'] = "<img src=\"" . fx_avatar(
					$this->search_action->search_result[$key]['image'],'small',
					$this->search_action->search_result[$key]['gender']
				). "\"/>";
				$this->search_action->search_result[$key]['link'] = fx_get_url(
					$this->search_action->current_controller,'item',
					$this->search_action->search_result[$key]['id']
				);
			}
			return $this;
		}

	}















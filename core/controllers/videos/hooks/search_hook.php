<?php

	namespace Core\Controllers\Videos\Hooks;

	use Core\Controllers\Search\Actions\Index as SearchAction;
	use Core\Controllers\Videos\Model;

	class Search_Hook{

		private $videos_model;
		private $search_action;
		private $current_controller;

		public function __construct(){
			$this->search_action = SearchAction::getInstance();
			$this->videos_model = Model::getInstance();
			$this->current_controller = $this->search_action->current_controller;
		}

		public function run(){
			$this->search_action->total = $this->videos_model->countFind($this->search_action->search_query);
			if(fx_equal($this->current_controller,'videos') && $this->search_action->total){
				$this->search_action->search_result = $this->videos_model->find(
					$this->search_action->search_query,
					$this->search_action->limit,
					$this->search_action->offset
				);
				$this->prepareResult();
			}
			$this->setHeaderBar();
			return $this->search_action->total_finds['videos'] = $this->search_action->total;
		}

		private function setHeaderBar(){
			$this->search_action->header_bar['videos'] = array(
				'title'	=> 'videos.find_by_videos_table_head',
				'link'	=> array(),
				'total'	=> $this->search_action->total,
			);
			return $this;
		}

		private function prepareResult(){
			foreach($this->search_action->search_result as $key=>$value){
				$this->search_action->search_result[$key]['date'] = fx_get_date($this->search_action->search_result[$key]['date']);
				$this->search_action->search_result[$key]['image'] = "<div class=\"search-icon\">" .
					fx_get_file_icon($this->search_action->search_result[$key]['title'])
					. "</div>";
				$this->search_action->search_result[$key]['link'] = fx_get_url(
					$this->search_action->current_controller,'item',
					$this->search_action->search_result[$key]['id']
				);
			}
			return $this;
		}

	}















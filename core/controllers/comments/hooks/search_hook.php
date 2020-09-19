<?php

	namespace Core\Controllers\Comments\Hooks;

	use Core\Controllers\Search\Actions\Index as SearchAction;
	use Core\Controllers\Comments\Model as Model;

	class Search_Hook{

		private $comments_model;
		private $search_action;
		private $current_controller;

		public function __construct(){
			$this->search_action = SearchAction::getInstance();
			$this->comments_model = Model::getInstance();
			$this->current_controller = $this->search_action->current_controller;
		}

		public function run(){
			$this->search_action->total = $this->comments_model->countFind($this->search_action->search_query);
			if(fx_equal($this->current_controller,'comments') && $this->search_action->total){
				$this->search_action->search_result = $this->comments_model->find(
					$this->search_action->search_query,
					$this->search_action->limit,
					$this->search_action->offset
				);
				$this->prepareResult();
			}
			$this->setHeaderBar();
			return $this->search_action->total_finds['comments'] = $this->search_action->total;
		}

		private function setHeaderBar(){
			$this->search_action->header_bar['comments'] = array(
				'title'	=> 'comments.find_by_comments_table_head',
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
					$this->search_action->search_result[$key]['controller'],
					$this->search_action->search_result[$key]['action'],
					$this->search_action->search_result[$key]['item']
				);
			}
			return $this;
		}

	}















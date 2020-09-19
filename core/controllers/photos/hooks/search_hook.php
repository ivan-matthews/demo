<?php

	namespace Core\Controllers\Photos\Hooks;

	use Core\Controllers\Search\Actions\Index as SearchAction;
	use Core\Controllers\Photos\Model;

	class Search_Hook{

		private $photos_model;
		private $search_action;
		private $current_controller;

		public function __construct(){
			$this->search_action = SearchAction::getInstance();
			$this->photos_model = Model::getInstance();
			$this->current_controller = $this->search_action->current_controller;
		}

		public function run(){
			$this->search_action->total = $this->photos_model->countFind($this->search_action->search_query);
			if(fx_equal($this->current_controller,'photos') && $this->search_action->total){
				$this->search_action->search_result = $this->photos_model->find(
					$this->search_action->search_query,
					$this->search_action->limit,
					$this->search_action->offset
				);
				$this->prepareResult();
			}
			$this->setHeaderBar();
			return $this->search_action->total_finds['photos'] = $this->search_action->total;
		}

		private function setHeaderBar(){
			$this->search_action->header_bar['photos'] = array(
				'title'	=> 'photos.find_by_photos_table_head',
				'link'	=> array(),
				'total'	=> $this->search_action->total,
			);
			return $this;
		}

		private function prepareResult(){
			foreach($this->search_action->search_result as $key=>$value){
				$this->search_action->search_result[$key]['image'] = "<img src=\"" .
					fx_get_image_src($this->search_action->search_result[$key]['image'],
						$this->search_action->search_result[$key]['date'],'small')
					. "\"/>";
				$this->search_action->search_result[$key]['date'] = fx_get_date($this->search_action->search_result[$key]['date']);
				$this->search_action->search_result[$key]['link'] = fx_get_url(
					$this->search_action->current_controller,'item',
					$this->search_action->search_result[$key]['id']
				);

			}
			return $this;
		}

	}















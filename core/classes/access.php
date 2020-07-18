<?php

	/*
														// по-умолчанию: доступ всегда везде открыт
		$access = new  \Core\Classes\Access();

		$user->setGroups(array(0,1));

		$enabled = array(0);
		$disabled = array(1);

		$access->enableGroups($enabled);				// пользователь имеет группу 0 - доступ открыт
		$access->disableGroups($disabled);				// и имеет группу 1 - доступ закрыт

		$enabled = array(
			'home'	=> array('index'),					// разрешить только на страницах контроллера home -> index
			'user'	=> array('item'),					// и user -> item
		);
		$disabled = array(
			'home'	=> array('index'),					// запретить только на страницах home -> index
			'user'	=> array('index'),					// и user -> index
		);
														// приоритет закрытого доступа выше открытого.
		$access->enablePages($enabled);
		$access->disablePages($disabled);

		fx_pre(array(
			'ag'	=> $access->granted(),
			'ad'	=> $access->denied()
		));

	*/

	namespace Core\Classes;

	class Access{

		private $enabled_groups;
		private $disabled_groups;

		private $enabled_pages;
		private $disabled_pages;

		private $access = true;

		private $controller;
		private $action;
		private $params;

		private $user_groups;

		private $user;
		private $kernel;

		public function __construct(){
			$this->user = User::getInstance();
			$this->kernel = Kernel::getInstance();

			$this->user_groups = $this->user->getGroups();
			$this->controller = $this->kernel->getCurrentController();
			$this->action = $this->kernel->getCurrentAction();
			$this->params = $this->kernel->getCurrentParams();
		}

		public function granted(){
			$this->check();
			return $this->access;
		}

		public function denied(){
			$this->check();
			return !$this->access;
		}

		public function enablePages(array $pages){
			$this->enabled_pages = $pages;
			return $this;
		}

		public function disablePages(array $pages){
			$this->disabled_pages = $pages;
			return $this;
		}

		public function enableGroups(array $groups){
			$this->enabled_groups = $groups;
			return $this;
		}

		public function disableGroups(array $groups){
			$this->disabled_groups = $groups;
			return $this;
		}

		public function check(){
			if($this->enabled_groups){
				$this->checkEnabledGroups();
			}
			if($this->enabled_pages){
				$this->checkEnabledPages();
			}
			if($this->disabled_groups){
				$this->checkDisabledGroups();
			}
			if($this->disabled_pages){
				$this->checkDisabledPages();
			}
			return $this;
		}

		public function findItemInList($item_id,array $haystack_array){
			$this->access = false;
			if(in_array($item_id,$haystack_array)){
				$this->access = true;
			}
			return $this;
		}

		public function findArrayInList(array $array_to_compare,array $haystack_array){
			foreach($array_to_compare as $key=>$value){
				$this->findItemInList($value,$haystack_array);
				if($this->access){
					break;
				}
			}
			return $this;
		}

		private function checkEnabledGroups(){
			$this->access = false;
			foreach($this->enabled_groups as $group){
				if(isset($this->user_groups[$group])){
					$this->access = true;
					break;
				}
			}
			return $this;
		}

		private function checkDisabledGroups(){
			foreach($this->disabled_groups as $group){
				if(isset($this->user_groups[$group])){
					$this->access = false;
					break;
				}
			}
			return $this;
		}

		private function checkEnabledPages(){
			foreach($this->enabled_pages as $controller=>$actions_array){
				if(!fx_equal($controller,$this->controller)){ continue; }
				$this->access = false;
				if(in_array($this->action,$actions_array)){
					$this->access = true;
					break;
				}
			}
			return $this;
		}

		private function checkDisabledPages(){
			foreach($this->disabled_pages as $controller=>$actions_array){
				if(!fx_equal($controller,$this->controller)){ continue; }
				if(in_array($this->action,$actions_array)){
					$this->access = false;
					break;
				}
			}
			return $this;
		}










	}















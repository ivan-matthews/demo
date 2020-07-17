<?php

	/*
		use Core\Classes\Access;

		$access		= new Access();
		$access->setEnabledGroups(array(44));			// пользователь имеет группу 44 - доступ открыт
		$access->setDisabledGroups(array(1,2,3,55,0));	// и имеет группу 55 - доступ закрыт
														// приоритет закрытого доступа выше открытого.
		fx_pre(array(
			'groups'	=> $user->getGroups(),
			'granted'	=> $access->granted(),			// false
			'denied'	=> $access->denied()			// true
		));
	*/

	namespace Core\Classes;

	class Access{

		private $enabled_groups;
		private $disabled_groups;

		private $enabled_pages;
		private $disabled_pages;

		private $access_granted = true;
		private $access_denied = false;

		private $user;
		private $kernel;

		public function __construct(){
			$this->user = User::getInstance();
			$this->kernel = Kernel::getInstance();
		}

		public function granted(){
			return $this->check()->access_granted;
		}

		public function denied(){
			return $this->check()->access_denied;
		}

		public function setEnabledPages(array $pages){
			$this->enabled_pages = $pages;
			return $this;
		}

		public function setDisabledPages(array $pages){
			$this->disabled_pages = $pages;
			return $this;
		}

		public function setEnabledGroups(array $groups){
			$this->enabled_groups = $groups;
			return $this;
		}

		public function setDisabledGroups(array $groups){
			$this->disabled_groups = $groups;
			return $this;
		}

		private function checkEnabledGroups(){
			$user_groups = $this->user->getGroups();
			foreach($this->enabled_groups as $group){
				if(isset($user_groups[$group])){
					$this->access_granted = true;
					$this->access_denied = false;
					break;
				}
			}
			return $this;
		}

		private function checkDisabledGroups(){
			$user_groups = $this->user->getGroups();
			foreach($this->disabled_groups as $group){
				if(isset($user_groups[$group])){
					$this->access_granted = false;
					$this->access_denied = true;
					break;
				}
			}
			return $this;
		}

		private function checkEnabledPages(){

		}

		private function checkDisabledPages(){

		}

		private function check(){
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












	}















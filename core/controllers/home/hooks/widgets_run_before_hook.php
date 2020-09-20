<?php

	namespace Core\Controllers\Home\Hooks;

	use Core\Classes\Widgets;
	use Core\Controllers\Home\Model;

	class Widgets_Run_Before_Hook{

		private $widgets_object;
		private $widgets_list;
		private $home_model;

		public function __construct(){
			$this->widgets_object = Widgets::getInstance();
			$this->home_model = Model::getInstance();
		}

		public function run(){
			$this->widgets_list = $this->home_model->getWidgetsFromDB();
			$this->widgets_object->widgets_list = array_merge($this->widgets_object->widgets_list,$this->widgets_list);
			return true;
		}

	}















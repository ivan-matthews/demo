<?php

	namespace System\Inserts;

	use Core\Classes\Database\Database;

	class InsertAddMenu202006170306091592402769{

		public function firstStep(){
			Database::insert('menu')
				->value('widget_id','1')
				->value('name','guest_menu')
				->value('title','home.guest_menu_title')
				->get()
				->id();
			Database::insert('menu')
				->value('widget_id','2')
				->value('name','user_menu')
				->value('title','home.user_menu_title')
				->get()
				->id();
			return $this;
		}











	}
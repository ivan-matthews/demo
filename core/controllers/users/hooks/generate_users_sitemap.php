<?php

	namespace Core\Controllers\Users\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Users_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('users')
				->setTable('users')
				->setOrderField('u_id')
				->setSelectableFields('u_id','u_date_created','u_date_updated')
				->setQuery("u_status != " . Kernel::STATUS_DELETED)
				->create();
			return $this;
		}

	}
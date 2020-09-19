<?php

	namespace Core\Controllers\Comments\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Comments_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('comments')
				->setTable('comments')
				->setOrderField('c_id')
				->setSelectableFields('c_id','c_date_created','c_date_updated')
				->setQuery("c_status != " . Kernel::STATUS_DELETED)
				->create();

			return $this;
		}

	}
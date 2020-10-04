<?php

	namespace Core\Controllers\News\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_News_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('news')
				->setTable('news')
				->setOrderField('nw_id')
				->setSelectableFields('nw_id','nw_date_created','nw_date_updated')
				->setQuery("nw_status != " . Kernel::STATUS_DELETED . " AND nw_public = 1")
				->create();

			return $this;
		}

	}
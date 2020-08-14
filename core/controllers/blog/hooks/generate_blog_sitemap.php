<?php

	namespace Core\Controllers\Blog\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Blog_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('blog')
				->setTable('blog')
				->setOrderField('b_id')
				->setSelectableFields('b_id','b_date_created','b_date_updated')
				->setQuery("b_status != " . Kernel::STATUS_DELETED . " AND b_public = 1")
				->create();

			return $this;
		}

	}
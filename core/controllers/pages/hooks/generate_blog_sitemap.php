<?php

	namespace Core\Controllers\Pages\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Blog_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('pages')
				->setTable('pages')
				->setOrderField('pg_id')
				->setSelectableFields('pg_id','pg_date_created','pg_date_updated')
				->setQuery("pg_status != " . Kernel::STATUS_DELETED . " AND pg_public = 1")
				->create();

			return $this;
		}

	}
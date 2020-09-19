<?php

	namespace Core\Controllers\Files\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Files_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('files')
				->setTable('files')
				->setOrderField('f_id')
				->setSelectableFields('f_id','f_date_created','f_date_updated')
				->setQuery("f_status != " . Kernel::STATUS_DELETED)
				->create();

			return $this;
		}

	}
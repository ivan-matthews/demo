<?php

	namespace Core\Controllers\Audios\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Audios_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('audios')
				->setTable('audios')
				->setOrderField('au_id')
				->setSelectableFields('au_id','au_date_created','au_date_updated')
				->setQuery("au_status != " . Kernel::STATUS_DELETED)
				->create();

			return $this;
		}

	}
<?php

	namespace Core\Controllers\Photos\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Photos_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('photos')
				->setTable('photos')
				->setOrderField('p_id')
				->setSelectableFields('p_id','p_date_created','p_date_updated')
				->setQuery("p_status != " . Kernel::STATUS_DELETED)
				->create();

			return $this;
		}

	}
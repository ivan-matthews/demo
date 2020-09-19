<?php

	namespace Core\Controllers\Videos\Hooks;

	use Core\Classes\Kernel;
	use Core\Controllers\Sitemap\Controller;

	class Generate_Videos_Sitemap{

		private $sitemap;

		public function __construct(){
			$this->sitemap = Controller::getInstance();
		}

		public function run(){
			$this->sitemap->setController('videos')
				->setTable('videos')
				->setOrderField('v_id')
				->setSelectableFields('v_id','v_date_created','v_date_updated')
				->setQuery("v_status != " . Kernel::STATUS_DELETED)
				->create();

			return $this;
		}

	}
<?php

	#CMD: engine update [with_demo_data=false, memory_limit=1536MB]
	#DSC: cli.engine_update_description
	#EXM: engine update true 4096MB

	namespace Core\Console\Engine;

	class Update extends Install{

		public $with_demo_data;
		public $memory_limit;
		public $with_demo_server;

		public function __construct(){
			parent::__construct();
		}

		public function execute($with_demo_data = 'false', $memory_limit = '1536MB',$with_demo_server='false'){
			$this->with_demo_data	= $with_demo_data;
			$this->memory_limit		= $memory_limit;
			$this->with_demo_server = $with_demo_server;

			$this->setMemoryLimit();
			$this->renameHtaccessFile();
			$this->renameComposerJsonFile();

			$this->hooks->run('cli_composer_update_before');
			$this->runComposer();
			$this->hooks->run('cli_composer_update_after');
			
			$this->runMigrations();
			if(!fx_equal($with_demo_data,'false')){
				$this->insertMigrations();
			}
			return $this->result;
		}


















	}
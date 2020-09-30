<?php

	namespace Core\Hooks;

	use Core\Console\Engine\Install;
	use Core\Console\Server\Run as Server;

	class Cli_Engine_Install_After_Hook{

		public $install_object;
		public $arguments_list;
		public $server_object;

		public function __construct(){
			$this->server_object = new Server();
		}

		public function run(Install $install,...$arguments_list){
			$this->install_object = $install;
			$this->arguments_list = $arguments_list;

			if(fx_equal($this->install_object->with_demo_server,'true')){
				$this->server_object->execute();
			}

			return true;
		}








	}















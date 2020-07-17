<?php

	namespace Core\Classes;

	class Console{

		private static $instance;

		protected $console;

		protected $arguments;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->console[$key])){
				return $this->console[$key];
			}
			return false;
		}

		public function __construct(){

		}

		public function getArguments($arguments){
			$this->arguments = array_slice($arguments,1);
			return $this;
		}

		public function runConsoleInterface(){
			if($this->arguments){

				if(!isset($this->arguments[1])){ $this->arguments[1] = 'Index'; }

				$cli_command_class = "\\System\\Console\\{$this->arguments[0]}\\{$this->arguments[1]}";
				$class_object = new $cli_command_class();
				$arguments = array_slice($this->arguments,2);
				call_user_func_array(array($class_object,'execute'),$arguments);
			}
			return $this;
		}




























	}
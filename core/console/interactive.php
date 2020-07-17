<?php

	namespace Core\Console;

	use Core\Console\Interfaces\Types;

	class Interactive{

		private static $instance;

		private $keyboard_dialog;
		private $error;
		private $error_string;
		private $error_prefix;
		private $callback;

		protected $interactive=array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->interactive[$key])){
				return $this->interactive[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->interactive[$name] = $value;
			return $this->interactive[$name];
		}

		public function __construct(){

		}

		public function __destruct(){

		}

		public static function exec(callable $callback_function){
			return call_user_func($callback_function,new self());
		}

		public function getDialogString(){
			return $this->keyboard_dialog;
		}

		public function create($dialog_string=false){
			$this->printString($dialog_string);
			$this->keyboard_dialog = trim(fgets(STDIN));
			return $this;
		}

		public function callback(callable $callback,$error_string){
			$this->error(trim($error_string));
			$this->callback = $callback;
			$this->error = !call_user_func($callback,$this);
			return $this;
		}

		public function get(){
			$this->checkErrors();
			$this->propertiesRemove();
			return $this->getDialogString();
		}

		public function printWelcome(){
			$repeating_string = str_repeat('-',100);
			return Paint::exec(function(Types $print)use($repeating_string){
				$print->string($repeating_string)->toPaint();
				$print->eol();
				$print->tab(2);
				$print->string('Welcome to CLI-Interactive mode. ')->color('light_green')->toPaint();
				$print->string('Please enter ')->toPaint();
				$print->string('Ctrl+C')->fon('red')->toPaint();
				$print->string(' to exit.')->toPaint();
				$print->eol();
				$print->string($repeating_string)->toPaint();
				$print->eol(2);
			});
		}

		private function checkErrors(){
			if($this->error){
				$this->error = null;
				$this->create($this->error_string);
				if($this->callback){
					$this->callback($this->callback,$this->error_string);
				}
				$this->get();
			}
			return $this;
		}

		private function printString($dialog_string){
			Paint::exec(function(Types $print)use($dialog_string){
				$print->string($this->error_prefix)->fon('red')->toPaint();
				$print->string($dialog_string)->toPaint();
				$print->string("> ")->toPaint();
			});
			return $this;
		}

		private function error($printing_string){
			$this->error_prefix = 'ERROR:';
			$this->error_string = " {$printing_string}";
			return $this;
		}

		private function propertiesRemove(){
			$this->error = null;
			$this->error_string = null;
			$this->callback = null;
			$this->error_prefix = null;

			return $this;
		}

	}
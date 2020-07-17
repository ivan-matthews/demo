<?php

	namespace Core\Console;

	use ReflectionMethod as Reflect;
	use Core\Classes\Kernel;

	class Console{

		private static $instance;

		protected $console;
		protected $file_script_name;
		protected $result = true;

		protected $arguments_original_array;
		protected $arguments;
		public $aliases_file_data;
		private $aliases_file;
		private $cli_command_class;
		private $cli_command_method;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		/*
			Console::run(
				'make',
				'controller',
				'home',
				'add',
				'items',
				'drop',
				'skip',
				'flush'
			);
		*/

		public static function run($cmd_controller,$cmd_action=null,...$cmd_params){
			$console_object = self::getInstance();
			$args = func_get_args();
			array_unshift($args,$console_object->getFileScriptName());
			$console_object->getArguments(...$args);

			if(!$console_object->runConsoleInterface()){
				$console_object->callHelpCenter();
			}
			return $console_object;
		}


		public function __get($key){
			if(isset($this->console[$key])){
				return $this->console[$key];
			}
			return false;
		}

		public function __construct(){

		}

		public function getArguments(...$arguments){
			$this->arguments_original_array = $arguments;
			$this->arguments = array_slice($arguments,1);
			return $this;
		}

		public function getFileScriptName(){
			if(!$this->file_script_name){
				$this->file_script_name = fx_get_server('PHP_SELF');
			}
			return $this->file_script_name;
		}

		public function runConsoleInterface(){
			if(!$this->runCommandFromAlias()){
				if(!$this->runNativeCommand()){
					return false;
				}
			}
			return true;
		}

		private function runCommandFromAlias(){
			$this->getAliasesFile();
			$this->searchCommandInCommandsArray();
			return $this->runCommand();
		}

		private function searchCommandInCommandsArray(){
			$console_command = implode(' ', $this->arguments);
			foreach($this->aliases_file_data as $key=>$value){
				if(!fx_status($value['status'],Kernel::STATUS_ACTIVE)){
					unset($this->aliases_file_data[$key]);
					continue;
				}
				$pattern = $this->preparePattern($value['command'],fx_arr($value['pattern'],'string'));
				preg_match("#{$pattern}#{$value['modifier']}",$console_command,$result_matches);
				if(isset($result_matches[0]) && fx_equal($result_matches[0],$console_command)){
					$this->cli_command_class = $value['class'];
					$this->cli_command_method = $value['method'];
					$this->arguments = array_slice($result_matches,1);
				}
			}
			return $this;
		}

		private function preparePattern($key,$pattern){
			if(is_array($pattern)){
				return $this->prepareArrayPatterns($key,$pattern);
			}
			return $this->prepareStringPatterns($key,$pattern);
		}

		private function prepareStringPatterns($key,$pattern){
			return preg_replace("#\[(.*?)\]#",$pattern,$key);
		}

		private function prepareArrayPatterns($key,$pattern){
			$keys = array_merge(array('[',']'),array_keys($pattern));
			$values = array_merge(array('',''),array_values($pattern));
			return str_replace($keys,$values,$key);
		}

		public function setAliasesFile($file="system/assets/console_commands_aliases"){
			$this->aliases_file = $file;
			return $this;
		}

		public function getAliasesFile(){
			$this->setAliasesFile();
			if(!$this->aliases_file_data){
				$this->aliases_file_data = fx_load_helper($this->aliases_file,Kernel::IMPORT_INCLUDE);
			}
			return $this;
		}

		private function runNativeCommand(){
			if($this->arguments){
				if(!isset($this->arguments[1])){ $this->arguments[1] = 'Index'; }
				$this->cli_command_class = "\\System\\Console\\{$this->arguments[0]}\\{$this->arguments[1]}";
				$this->cli_command_method = 'execute';
				$this->arguments = array_slice($this->arguments,2);
				return $this->runCommand();
			}
			return false;
		}

		private function runCommand(){
			if(class_exists($this->cli_command_class)){
				$class_object = new $this->cli_command_class();
				if($this->countActionArguments($class_object,$this->cli_command_method,$this->arguments)){
					$result = call_user_func_array(array($class_object,$this->cli_command_method),$this->arguments);
					$this->removeProperties();
					return $result;
				}
			}
			return false;
		}

		private function removeProperties(){
			$this->cli_command_class = null;
			$this->cli_command_method = null;
			return $this;
		}

		public function callHelpCenter(){
			Paint::exec(function(Paint $print){
				$delimiter = str_repeat('-',100);
				$print->string($delimiter)->toPaint()->eol()
					->string('Something went wrong... ')->toPaint()
					->string('The "')->toPaint()
					->string('php ' . implode(' ',$this->arguments_original_array))
						->fon('red')->toPaint()
					->string('" command was not found or returned an empty response. ')->toPaint()
					->string('Help Center called:')->toPaint()->eol()
					->eol()
				;
			});
			$this->runStructuredHelpCenter();
			return $this;
		}

		private function runStructuredHelpCenter(){
			$this->getArguments($this->getFileScriptName(),'help',1);
			$this->runCommandFromAlias();
			return $this;
		}

		private function runCompactedHelpCenter(){
			$this->getArguments($this->getFileScriptName(),'help');
			$this->runNativeCommand();
			return $this;
		}

		private function countActionArguments($object,$method,$params){
			$total_params = count($params);
			$reflection = new Reflect($object,$method);
			if($reflection->getNumberOfRequiredParameters() > $total_params){ return false; }
			return true;
		}

		protected function prepareClassName($class_name,$delimiter='_'){
			return implode($delimiter,fx_array_callback(explode($delimiter,$class_name),function(&$key,&$val){
				$val = ucfirst($val);
			}));
		}






















	}

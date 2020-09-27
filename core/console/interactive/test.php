<?php

	#CMD: interactive test [someone_variable = test]
	#DSC: cli.test_interactive_shell
	#EXM: interactive test controller

	namespace Core\Console\Interactive;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;
	use Core\Classes\Console\Interfaces\Types;

	class Test extends Console{

		public $someone;
		public $default_variables=array(
			'and',
			'now',
			'other',
			'new',
			'someone',
			'command',
			'enter',
			'please'
		);
		public $default='test';
		protected $result = array();

		public function execute(...$someone){
			$this->getConsoleArguments($someone);
			$this->createConsoleDialog();
			$this->getResult();

			return $this->result;
		}

		public function getConsoleArguments($arguments){
			$this->someone = $arguments ? implode(' ',$arguments) : $this->default;
			array_unshift($this->default_variables,$this->someone);
			return $this;
		}

		public function createConsoleDialog(){
			Interactive::exec(function(Interactive $interface){
				$interface->printWelcome();
				foreach($this->default_variables as $key=>$item){
					$this->runConsoleDialog($interface,$item);
				}
			});
			return $this;
		}

		public function runConsoleDialog(Interactive $interface,$item){
			$desired_value = Paint::exec(function(Types $print)use($item){
				return $print->string($item)->fon('blue')->get();
			});
			$desired_dialog = fx_lang('cli.enter_please_desired_value',array(
				'%DESIRED_VALUE%'	=> $desired_value
			));
			$interface->create($desired_dialog);
			$interface->callback($this->getInteractiveCallBackFunction($item),$desired_dialog);
			$this->result[$item] = $interface->get();
			return $this;
		}

		public function getResult(){
			return Paint::exec(function(Types $print){

				$keys = array_keys($this->result);
				$values = array_values($this->result);

				$print->string("SUCCESS:")->fon('green')->print();
				$print->string(' string "')->print();
				$print->arr($keys,', ')->color('light_red')->print();
				$print->string('" === "')->print();
				$print->arr($values,', ')->color('light_green')->print();
				$print->string('" is valid!')->print();
				$print->eol(2);
			});
		}

		public function getInteractiveCallBackFunction($desired_value){
			return function(Interactive $interface)use($desired_value){
				if(fx_equal($interface->getDialogString(),$desired_value)){
					return true;
				}
				return false;
			};
		}
















	}
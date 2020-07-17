<?php

	#CMD: interactive test [someone_variable = test]
	#DSC: cli.test_interactive_shell
	#EXM: interactive test controller

	namespace System\Console\Interactive;

	use Core\Console\Console;
	use Core\Console\Paint;
	use Core\Console\Interactive;
	use Core\Console\Interfaces\Types;

	class Test extends Console{

		private $someone;
		private $default_variables=array(
			'and',
			'now',
			'other',
			'new',
			'someone',
			'command',
			'enter',
			'please'
		);
		private $default='test';
		protected $result = array();

		public function execute(...$someone){
			$this->getConsoleArguments($someone);
			$this->createConsoleDialog();
			$this->getResult();

			return $this->result;
		}

		private function getConsoleArguments($arguments){
			$this->someone = $arguments ? implode(' ',$arguments) : $this->default;
			array_unshift($this->default_variables,$this->someone);
			return $this;
		}

		private function createConsoleDialog(){
			Interactive::exec(function(Interactive $interface){
				$interface->printWelcome();
				foreach($this->default_variables as $key=>$item){
					$this->runConsoleDialog($interface,$item);
				}
			});
			return $this;
		}

		private function runConsoleDialog(Interactive $interface,$item){
			$desired_value = Paint::exec(function(Types $print)use($item){
				return $print->string($item)->fon('blue')->get();
			});
			$desired_dialog = fx_lang('cli.enter_please_desired_value',array(
				'DESIRED_VALUE'	=> $desired_value
			));
			$interface->create($desired_dialog);
			$interface->callback($this->getInteractiveCallBackFunction($item),$desired_dialog);
			$this->result[$item] = $interface->get();
			return $this;
		}

		private function getResult(){
			return Paint::exec(function(Types $print){

				$keys = array_keys($this->result);
				$values = array_values($this->result);

				$print->string("SUCCESS:")->fon('green')->toPaint();
				$print->string(' string "')->toPaint();
				$print->arr($keys,', ')->color('light_red')->toPaint();
				$print->string('" === "')->toPaint();
				$print->arr($values,', ')->color('light_green')->toPaint();
				$print->string('" is valid!')->toPaint();
				$print->eol(2);
			});
		}

		private function getInteractiveCallBackFunction($desired_value){
			return function(Interactive $interface)use($desired_value){
				if(fx_equal($interface->getDialogString(),$desired_value)){
					return true;
				}
				return false;
			};
		}
















	}
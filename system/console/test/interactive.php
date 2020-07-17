<?php

	#CMD: test interactive [someone_variable=test]
	#DSC: real-time test console interactive dialogs
	#EXM: test interactive controller

	namespace System\Console\Test;

	use Core\Console\Console;
	use Core\Console\Paint;
	use Core\Console\Interactive as InteractiveDialogsClass;

	class Interactive extends Console{

		private $someone;
		private $default='test';

		public function execute(...$someone){
			$this->getConsoleArguments($someone);
			$this->createConsoleDialog();
			$this->getResult();

			return $this->result;
		}

		private function getConsoleArguments($arguments){
			$this->someone = $arguments ? implode(' ',$arguments) : $this->default;
			return $this;
		}

		private function createConsoleDialog(){
			InteractiveDialogsClass::exec(function(InteractiveDialogsClass $interface){
				$desired_value = Paint::exec(function(Paint $print){
					return $print->string($this->someone)->fon('blue')->get();
				});
				$interface->printWelcome();

				$interface->create("Enter please '{$desired_value}'");
				$interface->callback($this->getInteractiveCallBackFunction(),"Enter please '{$desired_value}'");
				$this->result = $interface->get();
			});
			return $this;
		}

		private function getResult(){
			return Paint::exec(function(Paint $print){
					$print->string("SUCCESS:")->fon('green')->toPaint();
					$print->string(' string "')->toPaint();
					$print->string($this->result)->color('light_green')->toPaint();
					$print->string('" is valid!')->toPaint();
					$print->eol(2);
				});
		}

		private function getInteractiveCallBackFunction(){
			return function(InteractiveDialogsClass $interface){
				if(fx_equal($interface->getDialogString(),$this->someone)){
					return true;
				}
				return false;
			};
		}
















	}
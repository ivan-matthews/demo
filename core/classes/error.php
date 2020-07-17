<?php

	namespace Core\Classes;

	use Core\Console\Paint;

	class Error{

		private static $stop_engine = false;
		private static $instance;

		private $error_number;
		private $error_message;
		private $error_file;
		private $error_line;
		private $error_backtrace;
		private $error_msg;
		private $error_code_string;

		protected $error=array();
		private $config;
		private $debug_enabled;

		private $error_codes = array(
			1		=> 'Critical error!',
			2		=> 'Warning!',
			4		=> 'Parse error!',
			8		=> 'Notice!',
			16		=> 'Core error!',
			32		=> 'Core warning!',
			64		=> 'Compile error!',
			128		=> 'Compile warning!',
			256		=> 'User error!',
			512		=> 'User warning!',
			1024	=> 'User notice!',
			2048	=> 'Strict!',
			4096	=> 'Recoverable error!',
			8192	=> 'Deprecated!',
			16384	=> 'User deprecated!',
			32767	=> 'Error № CODE_NUMBER!',
		);

		public static function getInstance($error_number, $error_message, $error_file, $error_line, $backtrace=array(), $error_msg=false){
			$object = new self($error_number, $error_message, $error_file, $error_line, $backtrace, $error_msg);
			return $object;
		}

		public function __get($key){
			if(isset($this->error[$key])){
				return $this->error[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->error[$name] = $value;
			return $this->error[$name];
		}

		public function __construct($error_number, $error_message, $error_file, $error_line, $backtrace=array(), $error_msg=false){
			$this->config = Config::getInstance();
			$this->debug_enabled = $this->config->core['debug_enabled'];

			$this->setErrNumber($error_number);
			$this->setErrMessage($error_message);
			$this->setErrFile($error_file);
			$this->setErrLine($error_line);
			$this->setErrBacktrace($backtrace);
			$this->setErrMsg($error_msg);

			$this->renderError();
		}

		public function __destruct(){

		}

		public static function setError(){
			if(@is_array($e = @error_get_last())){
				$code = isset($e['type']) ? $e['type'] : 0;
				$msg = isset($e['message']) ? $e['message'] : '';
				$file = isset($e['file']) ? $e['file'] : '';
				$line = isset($e['line']) ? $e['line'] : '';
				if($code>0){
					self::getInstance($code,$msg,$file,$line);
				}
			}
		}

		private function renderError(){
			if(self::$stop_engine){ return die; }
			self::$stop_engine = true;
			restore_error_handler();

			if(!$this->debug_enabled){
				$this->saveToResponse();
			}else{
				if(fx_is_cli()){
					$this->renderCLIError();
				}else{
					$this->renderHTMLError();
				}
			}
			return die;
		}

		private function saveToResponse(){

		}

		private function renderHTMLError(){
			include ROOT . "/public/view/default/assets/errors/debug_error_page.tmp.php";
			return $this;
		}

		private function renderCLIError(){
			$this->getErrorCodeString();
			Paint::exec(function(Paint $print){
				$print->string($this->error_code_string)->fon('red')->toPaint()->eol();
				$print->string($this->error_message)->fon('red')->color('white')->toPaint()->eol();
				$print->string("File: {$this->error_file}, ")->fon('cyan')->toPaint();
				$print->string("Line: {$this->error_line}")->fon('blue')->toPaint()->eol();
				$print->string($this->error_msg)->fon('yellow')->toPaint()->eol();
				$print->string(str_repeat('-',100))->toPaint()->eol(2);

				foreach($this->error_backtrace as $trace){
					$print->string(isset($trace['class']) ? $trace['class'] : null)->color('light_cyan')->toPaint();
					$print->string(isset($trace['type']) ? $trace['type'] : null)->color('light_red')->toPaint();
					$print->string(isset($trace['function']) ? $trace['function'] . '()' : null)->color('light_cyan')->toPaint()->eol();
					$print->string((isset($trace['file']) ? $trace['file'] : null) . ", ")->color('brown')->toPaint();
					$print->string(isset($trace['line']) ? $trace['line'] : null)->color('brown')->toPaint()->eol();
					$print->string(str_repeat('_',30))->toPaint()->eol();
				}
				$print->eol(2);
			});
			return $this;
		}

		private function setErrNumber($number){
			$this->error_number = $number;
			return $this;
		}

		private function setErrMessage($message){
			$this->error_message = $message;
			return $this;
		}

		private function setErrFile($file){
			$this->error_file = $file;
			return $this;
		}

		private function setErrLine($line){
			$this->error_line = $line;
			return $this;
		}

		private function setErrBacktrace($backtrace=false){
			$backtrace = debug_backtrace();
			$this->error_backtrace = array_reverse($backtrace);
			return $this;
		}

		private function setErrMsg($message){
			$this->error_msg = $message;
			return $this;
		}

		private function makeCodePreview($error_file,$error_line){
			if(!file_exists($error_file)){ return array(); }
			if(!is_numeric($error_line)){ return array(); }
			$file_data = file($error_file);
			$new_data_array = array();
			for($i=$error_line-10;$i<$error_line+10;$i++){
				if(!isset($file_data[$i])){ continue; }
				$new_data_array[$i+1] = $file_data[$i];
			}
			return $new_data_array;
		}

		private function getErrorCodeString(){
			if(isset($this->error_codes[$this->error_number])){
				$this->error_code_string = $this->error_codes[$this->error_number];
			}else{
				$this->error_code_string = str_replace('CODE_NUMBER',$this->error_number,$this->error_codes[32767]);
			}
			return $this;
		}










	}















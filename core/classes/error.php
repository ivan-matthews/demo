<?php

	namespace Core\Classes;

	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Database\Database;
	use Core\Classes\Response\Response;

	class Error{

		public static $error_keys=array();
		public static $stop_engine = false;

		public $cli_error_header = "
			***********  ***********    ***********       *******     ***********  
			***********  ************   ************    ***********   ************ 
			****         ****     ****  ****     ****  *****   *****  ****     ****
			****         ****     ****  ****     ****  ****     ****  ****     ****
			***********  ************   ************   ****     ****  ************ 
			***********  ***********    ***********    ****     ****  ***********  
			****         ****  ****     ****  ****     ****     ****  ****  ****   
			****         ****   ****    ****   ****    *****   *****  ****   ****  
			***********  ****    ****   ****    ****    ***********   ****    **** 
			***********  ****     ****  ****     ****     *******     ****     ****";
		public $error_number;
		public $error_message;
		public $error_file;
		public $error_line;
		public $error_backtrace;
		public $error_msg;
		public $error_code_string;

		public $error=array();
		public $config;
		public $response;
		public $debug_enabled;
		public $shutdown=false;

		public $error_codes = array(
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

		public static function nonSetError($error_number, $error_message, $error_file, $error_line, $backtrace=array(), $error_msg=false,$shutdown=false){
			$object = new self($error_number, $error_message, $error_file, $error_line, $backtrace, $error_msg,$shutdown);
			$object->saveToDatabase();
			return $object;
		}

		public static function getInstance($error_number, $error_message, $error_file, $error_line, $backtrace=array(), $error_msg=false,$shutdown=false){
			$object = new self($error_number, $error_message, $error_file, $error_line, $backtrace, $error_msg,$shutdown);
			$object->renderError();
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

		public function __construct($error_number, $error_message, $error_file, $error_line, $backtrace=array(), $error_msg=false,$shutdown=false){
			$this->config = Config::getInstance();
			$this->response = Response::getInstance();
			$this->shutdown = $shutdown;
			$this->debug_enabled = $this->config->core['debug_enabled'];

			$this->setErrNumber($error_number);
			$this->setErrMessage($error_message);
			$this->setErrFile($error_file);
			$this->setErrLine($error_line);
			$this->setErrBacktrace();
			$this->setErrMsg($error_msg);
		}

		public static function setError($shutdown=true){
			if(@is_array($e = @error_get_last())){
				$code = isset($e['type']) ? $e['type'] : 0;
				$msg = isset($e['message']) ? $e['message'] : '';
				$file = isset($e['file']) ? $e['file'] : '';
				$line = isset($e['line']) ? $e['line'] : '';
				if($code>0){
					self::getInstance($code,$msg,$file,$line,array(),false,$shutdown);
				}
			}
		}

		private function renderError(){
			if($this->debug_enabled){
				return $this->debugEnabled();
			}
			return $this->debugDisabled();
		}

		private function debugDisabled(){
			if(fx_is_cli()){
				return $this->renderCLIError();
			}
			$this->saveToDatabase();
			if($this->shutdown){
				$this->render500();
			}
			return $this;
		}

		private function debugEnabled(){
			if(self::$stop_engine){ return die; }
			self::$stop_engine = true;
			restore_error_handler();

			if(fx_is_cli()){
				return $this->renderCLIError();
			}
			return $this->renderHTMLError();
		}

		private function saveToDatabase(){
			$error_hash = md5($this->error_number.$this->error_file.$this->error_line);
			if(isset(self::$error_keys[$error_hash])){ return true; }
			self::$error_keys[$error_hash] = true;

			return Database::insert('errors')
				->value('e_count',1)
				->value('e_number',$this->error_number ? $this->error_number : null)
				->value('e_file',$this->error_file ? $this->error_file : null)
				->value('e_line',$this->error_line ? $this->error_line : null)
				->value('e_message',$this->error_message ? $this->error_message : null)
				->value('e_backtrace',$this->error_backtrace)
				->value('e_msg',$this->error_msg ? $this->error_msg : null)
				->value('e_hash',$error_hash)
				->value('e_date_created',time())
				->update('e_date_created',time())
				->updateQuery('e_count',"e_count+1")
				->get();
		}

		/** @return mixed */
		private function renderHTMLError(){
			$this->response->setResponseCode(500);
			$this->response->sendHeaders();
			include ROOT . "/public/view/default/assets/errors/debug_error_page.html.php";
			return die;
		}

		/** @return mixed */
		private function render500(){
			$this->response->setResponseCode(500);
			$this->response->sendHeaders();
			include ROOT . "/public/view/default/assets/errors/error_500_page.html.php";
			return die;
		}

		/** @return mixed */
		private function renderCLIError(){
			$this->getErrorCodeString();
			Paint::exec(function(Types $print){
				$print->string($this->cli_error_header)->fon('red')->print()->eol()->tab();
				$print->string($this->error_code_string)->color('light_green')->print()->eol()->tab();
				$print->string($this->error_message)->fon('red')->print()->eol()->tab();
				$print->string("File: ")->print();
				$print->string($this->error_file)->color('brown')->print();
				$print->string(", ")->print();
				$print->string("Line: ")->print();
				$print->string($this->error_line)->color('light_red')->print()->eol()->tab();
				$print->string($this->error_msg)->fon('yellow')->print()->eol();
				$print->string(str_repeat('-',100))->print()->eol(2);

				foreach($this->error_backtrace as $trace){
					$print->string($trace['class'])->color('light_cyan')->print();
					$print->string($trace['type'])->color('light_red')->print();
					$print->string("{$trace['function']}()")->color('light_cyan')->print()->eol();
					$print->string("{$trace['file']}, ")->color('brown')->print();
					$print->string($trace['line'])->color('light_red')->print()->eol();
					$print->string(str_repeat('_',30))->print()->eol();
				}
				$print->eol(2);
			});
			return die;
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

		private function setErrBacktrace(){
			foreach (array_reverse(debug_backtrace()) as $index => $item) {
				$this->error_backtrace[$index]['class'] = isset($item['class']) ? $item['class'] : null;
				$this->error_backtrace[$index]['type'] = isset($item['type']) ? $item['type'] : null;
				$this->error_backtrace[$index]['function'] = isset($item['function']) ? $item['function'] : "Function: NULL";
				$this->error_backtrace[$index]['file'] = isset($item['file']) ? $item['file'] : "File: NULL";
				$this->error_backtrace[$index]['line'] = isset($item['line']) ? $item['line'] : "Line: NULL";
				$this->error_backtrace[$index]['args'] = !isset($item['args']) ? "NULL" : ($item['args'] ? fx_implode(', ',$item['args']) : "NULL");
			}
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
				$new_data_array[$i+1] = htmlspecialchars($file_data[$i]);
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















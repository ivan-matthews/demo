<?php

	/*
		Paint::exec(function(Types $p){
			$p
				->eol()
					->tab()
						->string('test string')
							->color('red')
								->fon('yellow')
									->toPaint();
		});
	*/

	namespace Core\Console;

	use Core\Classes\Response;
	use Core\Console\Interfaces\Types;

	class Paint implements Types{

		const COLOR = 'white';
		const FON = 'black';

		private static $instance;

		protected $color_key;
		protected $fon_key;

		protected $string;
		protected $color;
		protected $fon;

		private $result_string;
		private $debug_result_string;

		protected $paint;
		private $time;

		protected $foreground_colors = array(
			'black' 		=> '0;30',
			'blue' 			=> '0;34',
			'green' 		=> '0;32',
			'cyan' 			=> '0;36',
			'red' 			=> '0;31',
			'purple' 		=> '0;35',
			'brown' 		=> '0;33',
			'yellow' 		=> '1;33',
			'white' 		=> '1;37',

			'light_gray' 	=> '0;37',
			'light_purple' 	=> '1;35',
			'light_red' 	=> '1;31',
			'light_cyan' 	=> '1;36',
			'light_green' 	=> '1;32',
			'light_blue' 	=> '1;34',
			'dark_gray' 	=> '1;30',
		);
		protected $background_colors = array(
			'black' 		=> '40',
			'red' 			=> '41',
			'green' 		=> '42',
			'yellow' 		=> '43',
			'blue' 			=> '44',
			'magenta' 		=> '45',
			'cyan' 			=> '46',
			'light_gray' 	=> '47',
		);

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($key){
			if(isset($this->paint[$key])){
				return $this->paint[$key];
			}
			return false;
		}

		public function __set($name, $value){
			$this->paint[$name] = $value;
			return $this->paint[$name];
		}

		public function __construct(){
			$this->time = microtime(true);
		}

		public function __destruct(){
			Response::debug('console')
				->setQuery($this->debug_result_string)
				->setTrace(debug_backtrace())
				->setTime($this->time)
			;
			$this->debug_result_string = null;
		}

		public static function exec($callback){
			return call_user_func($callback,new self());
		}

		public function arr(array $array,$glue=''){
			$this->removeProps();
			$this->string = implode($glue,$array);
			return $this;
		}

		public function string($string){
			$this->removeProps();
			$this->string = $string;
			return $this;
		}

		public function color($color){
			$this->color_key = $color;
			$color = isset($this->foreground_colors[$color]) ? $this->foreground_colors[$color] : '';
			$this->color = "\033[" . $color . "m";
			return $this;
		}

		public function fon($fon){
			$this->fon_key = $fon;
			$fon = isset($this->background_colors[$fon]) ? $this->background_colors[$fon] : '';
			$this->fon = "\033[" . $fon . "m";
			return $this;
		}

		public function toPaint(){
			if(fx_is_cli()){
				$this->paintConsole();
			}else{
				$this->paintBrowser();
			}
			return $this;
		}

		public function get(){
			if(fx_is_cli()){
				$this->getConsole();
			}else{
				$this->getBrowser();
			}
			return $this->result_string;
		}

		protected function getConsole(){
			$this->result_string .= $this->color;
			$this->result_string .= $this->fon;
			$this->result_string .= $this->string;
			$this->result_string .= "\033[0m";

			return $this;
		}

		protected function getBrowser(){
			$this->result_string .= "<span style=";
			$this->result_string .= "\"color:{$this->color_key};";
			$this->result_string .= "background:{$this->fon_key};\"";
			$this->result_string .= ">";
			$this->result_string .= $this->string;
			$this->result_string .= "</span>";

			return $this;
		}

		protected function paintConsole(){
			print $this->color;
			print $this->fon;
			print $this->string;
			print "\033[0m";

			return $this;
		}

		protected function paintBrowser(){
			$this->debug_result_string .= "<span style=";
			$this->debug_result_string .= "\"color:{$this->color_key};";
			$this->debug_result_string .= "background:{$this->fon_key};\"";
			$this->debug_result_string .= ">";
			$this->debug_result_string .= $this->string;
			$this->debug_result_string .= "</span>";

			return $this;
		}

		protected function removeProps(){
			$this->result_string = null;
			$this->color_key = null;
			$this->fon_key = null;
			$this->string = null;
			$this->color = null;
			$this->fon = null;
			return $this;
		}

		public function eol($repeating=1){
			if(fx_is_cli()){
				$string = str_repeat(PHP_EOL,$repeating);
			}else{
				$string = str_repeat("<br>",$repeating);
			}
			$this->string($string)->toPaint();
			return $this;
		}

		public function tab($repeating=1){
			$string = str_repeat("\t",$repeating);
			$this->string($string)->toPaint();
			return $this;
		}













	}















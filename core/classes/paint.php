<?php

	namespace Core\Classes;

	class Paint{

		const COLOR = 'white';
		const FON = 'black';

		private static $instance;

		protected $color_key;
		protected $fon_key;

		protected $string;
		protected $color;
		protected $fon;

		protected $paint;

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

		}

		public function __destruct(){

		}

		public static function exec($callback){
			return call_user_func($callback,new self());
		}

		public function string($string){
			$this->removeProps();
			$this->string = $string;
			return $this;
		}

		public function color($color){
			$color = isset($this->foreground_colors[$color]) ? $color : '';
			$this->color_key = $color;
			$this->color = "\033[" . $this->foreground_colors[$color] . "m";
			return $this;
		}

		public function fon($fon){
			$fon = isset($this->background_colors[$fon]) ? $fon : '';
			$this->fon_key = $fon;
			$this->fon = "\033[" . $this->background_colors[$fon] . "m";
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

		protected function paintConsole(){
			print $this->color;
			print $this->fon;
			print $this->string;
			print "\033[0m";

			return $this;
		}

		protected function paintBrowser(){
			print "<span style=";
			print "\"color:{$this->color_key};";
			print "background:{$this->fon_key};\"";
			print ">";
			print $this->string;
			print "</span>";

			return $this;
		}

		protected function removeProps(){
			$this->color_key = null;
			$this->fon_key = null;
			$this->string = null;
			$this->color = null;
			$this->fon = null;
			return $this;
		}

		public function eol(){
			if(fx_is_cli()){
				print PHP_EOL;
			}else{
				print '<br>';
			}
			return $this;
		}

		public function tab(){
			print "\t";
			return $this;
		}













	}















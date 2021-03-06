<?php

	#CMD: server run [host=127.0.0.1], [port=8080]
	#DSC: cli.run_develop_server
	#EXM: server run

	namespace Core\Console\Server;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;

	class Run extends Console{

		public $host;
		public $port;

		public function execute($host='127.0.0.1', $port = '8080'){
			$this->prepare($host,$port);
			$this->start();
			return $this->result;
		}

		public function prepare($host,$port){
			$this->host = $host;
			$this->port = $port;
			return $this;
		}

		public function start(){
			if(!function_exists('passthru')){
				die('function "passthru" not exists!' . PHP_EOL);
			}
			$address = "{$this->host}:{$this->port}";
			$this->success($address);
			passthru("/usr/bin/env php -S {$address} server.php");
			return $this->error();
		}

		public function success($address){
			return Paint::exec(function(Types $print)use($address){
				$repeating_string = str_repeat('-',50);
				$print->string($repeating_string)->print()->eol();
				$print->string(fx_lang('cli.develop_server_date',array(
					'%DATE%'	=> $print->string(date('d F Y'))->fon('magenta')->color('white')->get(),
					'%TIME%'	=> $print->string(date('H:i:s'))->fon('magenta')->color('white')->get(),
					'%TIMEZONE%'=> $print->string(date('e'))->fon('magenta')->color('white')->get(),
				)))->print();
				$print->string(fx_lang('cli.success_header'))->fon('green')->print()->space();
				$print->string(fx_lang('cli.develop_server_started'))->color('white')->fon('green')->print()->eol();
				$print->string(fx_lang('cli.develop_server_details',array(
					'%ADDRESS%'	=> $print->string("http://{$address}")->fon('red')->color('white')->get(),
				)))->color('light_green')->print()->eol();
				$print->string(fx_lang('cli.enter_please_cmd_to_exit',array(
					'%COMMAND%'	=> $print->string('CTRL+C')->fon('green')->color('white')->get(),
				)))->print()->eol();
				$print->string($repeating_string)->print()->eol(2);
			});
		}

		public function error(){
			return Paint::exec(function(Types $print){
				$print->eol();
				$print->string(fx_lang('cli.develop_server_date',array(
					'%DATE%'	=> $print->string(date('d F Y'))->fon('magenta')->color('white')->get(),
					'%TIME%'	=> $print->string(date('H:i:s'))->fon('magenta')->color('white')->get(),
					'%TIMEZONE%'=> $print->string(date('e'))->fon('magenta')->color('white')->get(),
				)))->print();
				$print->string(fx_lang('cli.error_header'))->fon('red')->print()->space();
				$print->string(fx_lang('cli.develop_server_down'))->color('white')->fon('red')->print()->eol(2);
			});
		}
















	}
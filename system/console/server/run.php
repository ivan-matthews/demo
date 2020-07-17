<?php

	#CMD: server run [host=127.0.0.1], [port=8080]
	#DSC: cli.run_develop_server
	#EXM: server run

	namespace System\Console\Server;

	use Core\Classes\Console\Console;
	use Core\Classes\Console\Interfaces\Types;
	use Core\Classes\Console\Paint;
	use Core\Classes\Console\Interactive;

	class Run extends Console{

		private $host;
		private $port;

		public function execute($host='127.0.0.1', $port = '8080'){
			$this->prepare($host,$port);
			$this->start();
			return $this->result;
		}

		private function prepare($host,$port){
			$this->host = $host;
			$this->port = $port;
			return $this;
		}

		private function start(){
			$address = "{$this->host}:{$this->port}";
			$this->success($address);
			passthru("/usr/bin/env php -S {$address} " . "server.php");
			return $this->error();
		}

		private function success($address){
			return Paint::exec(function(Types $print)use($address){
				$print->string(fx_lang('cli.develop_server_started',array(
					'ADDRESS'	=> $print->string("http://{$address}")->fon('red')->color('white')->get(),
					'COMMAND'	=> $print->string('CTRL+C')->fon('green')->color('white')->get(),
					'DATE'		=> $print->string(date('d F Y'))->fon('magenta')->color('white')->get(),
					'TIME'		=> $print->string(date('H:i:s'))->fon('magenta')->color('white')->get()
				)))->color('light_green')->toPaint();
				$print->eol(2);
			});
		}

		private function error(){
			return Paint::exec(function(Types $print){
					$print->eol();
					$print->string(fx_lang('cli.develop_server_down',array(
						'DATE'		=> $print->string(date('d F Y'))->fon('magenta')->color('white')->get(),
						'TIME'		=> $print->string(date('H:i:s'))->fon('magenta')->color('white')->get(),
						'CONTENT'	=> $print->string(fx_lang('cli.develop_server_down_content'))->color('white')->fon('red')->get()
					)))->toPaint();
					$print->eol();
				});
		}
















	}